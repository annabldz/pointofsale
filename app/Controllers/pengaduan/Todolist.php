<?php

namespace App\Controllers;

use App\Models\M_todolist;

class Todolist extends BaseController
{
   public function index()
    {
        $inimodel = new M_todolist();

        // list task (yang sudah kamu punya)
        $mey['yupi'] = $inimodel->todolistdone();
        $mey['yupigkdone'] = $inimodel->todolistnotdone();

        // summary card
        $summary = $inimodel->getSummaryTask();

        $mey['totalTask'] = $summary['total_task'];
        $mey['taskSelesai'] = $summary['task_selesai'];
        $mey['taskBelumSelesai'] = $summary['task_belum_selesai'];

        echo view('header');
        echo view('todolist', $mey);
        echo view('footer');
    }

    public function input()
    {
        
        echo view('header');
        echo view('input');
        echo view('footer');
    }

    public function inputsave()
    {
        $taskData = [
            'nama' => $this->request->getPost('nama'),
            'status' => $this->request->getPost('status'),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal' => $this->request->getPost('tanggal'),
        ];

        $inimodel = new M_todolist;
        $inimodel->input('task', $taskData);

        return redirect()->to(base_url('/task'));
    }
public function edit($id)
{
    $model = new M_todolist();

    // ambil 1 baris saja
    $data['love'] = $model->where('id', $id)->first();

    echo view('header');
    echo view('edit', $data);
    echo view('footer');
}



    public function editsave()
    {

        $dataUser = [
            'nama' => $this->request->getPost('nama'),
            'status' => $this->request->getPost('status'),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal' => $this->request->getPost('tanggal'),
        ];

        $inimodel = new M_todolist;
        $whereUser = ['id' => $this->request->getPost('id')];


        $inimodel->edit('task', $dataUser, $whereUser);

        return redirect()->to('/task');
    }

    public function delete($id)
    {
        $inimodel = new M_todolist;
        $task = $inimodel->find($id);
        if (!$task) {
            return redirect()->to('/task')->with('error', 'Data tidak ditemukan');
        }

        $inimodel->delete($id);

        return redirect()->to('/task')->with('success', 'Data berhasil dihapus');
    }

public function updatestatus()
{
    $json = $this->request->getJSON();
    $id = $json->id;
    $status = $json->status;

    $model = new M_todolist();
    $task = $model->find($id);

    // Pastikan task ada dan statusnya benar
    if ($task) {
        $model->update($id, ['status' => $status]);
        return $this->response->setJSON(['success' => true]);
    }

    return $this->response->setJSON(['success' => false]);
}

}
