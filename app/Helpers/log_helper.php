<?php

use App\Models\M_log;

if (!function_exists('log_activity')) {
    function log_activity($id_user, $activity) {
        $logModel = new M_log();

        $data = [
            'id_user'    => $id_user,
            'activity'     => $activity,
            'created_at' => date('Y-m-d H:i:s'), 
            'ip_address' => $_SERVER['REMOTE_ADDR'],
       ];

        $logModel->insert($data);
    }
}
