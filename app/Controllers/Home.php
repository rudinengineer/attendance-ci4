<?php

namespace App\Controllers;

use App\Libraries\Api;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/attendance/index');
    }

    public function admin()
    {
        return view('pages/admin/index');
    }

    public function store()
    {
        // Validation Request
        if (!$this->validate([
            'employee_id' => [
                'label' => 'Employee ID',
                'rules' => 'required|numeric'
            ],
        ])) {
            $errors_msg = \Config\Services::validation()->getErrors();
            return $this->response->setJSON([
                'status' => false,
                'message' => $errors_msg[array_keys($errors_msg)[0]]
            ]);
        }

        $data = [
            'employee_id' => $this->request->getPost('employee_id'),
            'description' => $this->request->getPost('description'),
        ];

        // Check IN
        $response = Api::send('POST', '/attendance', [
            'json' => $data
        ]);

        // Success
        if ($response['status']) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Check-in successful'
            ]);
        } else if ($response['data']['status_code'] === "10") {
            // Check Out
            $response = Api::send('PUT', '/attendance', [
                'json' => $data
            ]);

            // Success
            if ($response['data']['status_code'] == "00") {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Check-out successful'
                ]);
            } else {
                // Fail
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $response['data']['message']
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => $response['data']['message']
            ]);
        }
    }
}
