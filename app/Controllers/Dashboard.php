<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Dashboard extends BaseController
{

 	protected $session;
    protected $M_ekskul;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->M_ekskul = new \App\Models\M_ekskul(); 
		helper(['url', 'log']);
    }

    public function index () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $logModel = new M_log(); 
        $db = \Config\Database::connect();

        // ambil semua menu
        $menu_all = $db->table('menu')
            ->orderBy('parent_id', 'ASC')
            ->orderBy('id_menu', 'ASC')
            ->get()
            ->getResultArray();

        // ambil privileges user
        $privs = $db->table('privileges')
            ->where('id_level', $level)
            ->get()
            ->getResultArray();

        $privileges = [];
        foreach ($privs as $p){
            $privileges[$p['id_menu']] = true;
        }

        // passing ke view
        $hee['menu_all'] = $menu_all;
        $hee['privileges'] = $privileges;
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Dashboard.');

        echo view('/admin/header', $hee);
        echo view('/dashboard');
        echo view('/admin/footer');
    }
public function downloadSql()
{
    $filename = 'backup_' . date('Ymd_His') . '.sql';
    $dir = WRITEPATH . 'backups\\';

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $tempPath = $dir . $filename;

    // PATH mysqldump XAMPP (WAJIB)
    $mysqldump = 'C:\xampp\mysql\bin\mysqldump.exe';

    // nama database kamu
    $database = 'pointofsale';

    // command SAMA kayak yang kamu tes manual
    $command = "\"$mysqldump\" -u root $database > \"$tempPath\" 2>&1";

    exec($command, $output, $code);

    if ($code !== 0 || !file_exists($tempPath) || filesize($tempPath) === 0) {
        return $this->response->setJSON([
            'error' => true,
            'command' => $command,
            'output' => $output
        ]);
    }

    return $this->response
        ->download($tempPath, null)
        ->setFileName($filename);
}

    
}