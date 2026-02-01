<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Login extends BaseController
{
	public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->M_ekskul = new \App\Models\M_ekskul(); 
		helper(['url', 'log']);
    }

    public function index () {
        $angka1 = rand(1, 10);
		$angka2 = rand(1, 10);
		$soal = "$angka1 + $angka2";
		session()->set('captcha_jawaban', $angka1 + $angka2);

		echo view('login', ['soal_captcha' => $soal]);
    }
    public function aksi_login ()
	{
		$isOnline = $this->request->getPost('is_online');
	
		if ($isOnline == "1") {
			
			$recaptcha_secret = "6LfW-uArAAAAAMUqNUbMgjygjENArvbPBjGRkV69"; 
			$recaptcha_response = $_POST['g-recaptcha-response'];
	
			$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 2); // ⬅ PENTING (2 detik max)

$response = curl_exec($ch);
curl_close($ch);

$response_keys = json_decode($response, true);

if (empty($response_keys['success'])) {
    return redirect()->back()->with('error', 'reCAPTCHA gagal');
}

			// $verify_url = "https://www.google.com/recaptcha/api/siteverify";
			// $response = file_get_contents($verify_url . "?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
			// $response_keys = json_decode($response, true);
		
			// if (!$response_keys["success"]) {
			// 	return redirect()->back()->with('error', 'reCAPTCHA verification failed. Please try again.');
			// }
			} else {
			$jawabanUser = $this->request->getPost('captcha_jawaban');
			$jawabanBenar = session()->get('captcha_jawaban');
			if ((int)$jawabanUser !== (int)$jawabanBenar) {
				return redirect()->back()->with('error', 'Jawaban captcha salah!');
			}
		}
		$a=$this->request->getPost('email');
		$b=$this->request->getPost('pswd');

		$love = new M_ekskul;
		$data = array(
			"username"=>$a,
			"password"=>MD5($b),
		);

		$cek = $love->getWhere('user', $data);

if ($cek != null) {

    // 🔐 TENTUKAN SUPERADMIN DI SINI
    $isRoot = false;

    if (
        $cek->username === 'mey' &&
        $cek->level == 1
    ) {
        $isRoot = true;
    }

    // ✅ SET SESSION
    session()->set([
        'id'      => $cek->id_user,
        'u'       => $cek->username,
        'level'   => $cek->level,
        'is_root' => $isRoot
    ]);

    log_activity(
        $cek->id_user,
        'Login berhasil'
    );

    return redirect()->to('/dashboard');

} else {

    log_activity(
        null,
        'Login gagal untuk username: ' . $a
    );

    return redirect()->back()->with('error', 'Email atau password salah!');
}

		

		}
    public function logout()
{
    $id_user = session()->get('id');

    // HANCURKAN SESSION DULU (biar cepat ke user)
    session()->destroy();

    // LOG BELAKANGAN (session sudah mati)
    if ($id_user) {
        log_activity($id_user, 'Logout');
    }

    return redirect()->to('/login');
}

}