<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('users')->where('username', 'demo')->countAllResults() === 0) {
            $this->db->table('users')->insert([
                'username'   => 'demo',
                'full_name'  => 'Demo User',
                'email'      => 'demo@example.com',
                'password'   => password_hash('TaskDemo123!', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if ($this->db->table('tasks')->countAllResults() === 0) {
            $this->db->table('tasks')->insertBatch([
                [
                    'title'      => 'Review today\'s priorities',
                    'status'     => 'pending',
                    'task_date'  => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title'      => 'Plan the week ahead',
                    'status'     => 'pending',
                    'task_date'  => date('Y-m-d', strtotime('+1 day')),
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ]);
        }
    }
}