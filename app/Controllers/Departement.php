<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use CodeIgniter\HTTP\ResponseInterface;

class Departement extends BaseController
{
    public function index()
    {
        $departement = Api::send('GET', '/departement');
        if (!$departement['status']) {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to get data departement!');
        }

        $data = [
            'data' => $departement['data']['data']
        ];

        return view('pages/admin/departement/index', $data);
    }

    public function store()
    {
        // Validation Request
        if (!$this->validate([
            'name' => [
                'label' => 'Departement Name',
                'rules' => 'required'
            ],
            'max_clock_in_time' => [
                'label' => 'Max Clock In Time',
                'rules' => 'required'
            ],
            'max_clock_in_out' => [
                'label' => 'Max Clock In Out',
                'rules' => 'required'
            ]
        ])) {
            $errors_msg = \Config\Services::validation()->getErrors();
            return redirect()->to(base_url('admin/departement'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        $data = [
            'departement_name' => $this->request->getPost('name'),
            'max_clock_in_time' => $this->request->getPost('max_clock_in_time') . ':00',
            'max_clock_in_out' => $this->request->getPost('max_clock_in_out') . ':00',
        ];

        $response = Api::send('POST', '/departement', [
            'json' => $data
        ]);

        if ($response['data']['status_code'] === "00") {
            return redirect()->to('admin/departement')
                ->with('success', 'Data saved successfully!');
        } else {
            return redirect()->to('admin/departement')
                ->with('error', 'Failed to save data!');
        }
    }

    public function update($id = null)
    {
        // Validation Request
        if (!$this->validate([
            'name' => [
                'label' => 'Departement Name',
                'rules' => 'required'
            ],
            'max_clock_in_time' => [
                'label' => 'Max Clock In Time',
                'rules' => 'required'
            ],
            'max_clock_in_out' => [
                'label' => 'Max Clock In Out',
                'rules' => 'required'
            ]
        ])) {
            $errors_msg = \Config\Services::validation()->getErrors();
            return redirect()->to(base_url('admin/departement'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        $data = [
            'departement_name' => $this->request->getPost('name'),
            'max_clock_in_time' => $this->request->getPost('max_clock_in_time') . ':00',
            'max_clock_in_out' => $this->request->getPost('max_clock_in_out') . ':00',
        ];

        $response = Api::send('PUT', '/departement/' . $id, [
            'json' => $data
        ]);

        if ($response['data']['status_code'] === "00") {
            return redirect()->to('admin/departement')
                ->with('success', 'Data saved successfully!');
        } else {
            return redirect()->to('admin/departement')
                ->with('error', 'Failed to save data!');
        }
    }

    public function delete($id = null)
    {
        $response = Api::send('DELETE', '/departement/' . $id);

        if ($response['status']) {
            return redirect()->to('admin/departement')
                ->with('success', 'Data deleted successfully!');
        } else {
            return redirect()->to('admin/departement')
                ->with('error', 'Failed to delete data!');
        }
    }
}
