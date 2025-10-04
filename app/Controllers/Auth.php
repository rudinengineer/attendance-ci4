<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        if (session('access_token')) {
            return redirect()->to(base_url('admin'));
        }

        return view('pages/auth/login');
    }

    public function store()
    {
        // Validation Request
        if (!$this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required'
            ]
        ])) {
            $errors_msg = \Config\Services::validation()->getErrors();
            return redirect()->to(base_url('login'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
        ];

        $response = Api::send('POST', '/auth/login', [
            'json' => $data
        ]);

        if ($response['status']) {
            session()->set('access_token', $response['data']['data']['access_token']);

            return redirect()->to(base_url('admin'));
        } else if ($response['error'] === 'server not ready') {
            return redirect()->to(base_url('login'))
                ->with('error', 'Something went wrong');
        } else {
            return redirect()->to(base_url('login'))
                ->with('error', 'Invalid username or password.');
        }
    }
}
