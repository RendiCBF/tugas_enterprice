<?php

if (!function_exists('helper_log')) {
    /**
     * Pastikan nama fungsi ini tepat: helper_log
     */
    function helper_log($action, $description)
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        
        $userId = $session->get('user_id') ?? 1;

        $data = [
            'user_id'     => $userId,
            'action'      => strtoupper($action),
            'description' => $description,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        return $db->table('activity_logs')->insert($data);
    }
}