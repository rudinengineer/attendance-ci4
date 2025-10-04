<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use CodeIgniter\HTTP\ResponseInterface;

class Employee extends BaseController
{
    public function index()
    {
        // Fetch Data Employee
        $employee = Api::send('GET', '/employee');
        if (!$employee['status']) {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to get data employee!');
        }

        // fetch Data Departement
        $departement = Api::send('GET', '/departement');
        if (!$departement['status']) {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to get data departement!');
        }

        $data = [
            'data' => $employee['data']['data'],
            'departement' => $departement['data']['data']
        ];

        return view('pages/admin/employee/index', $data);
    }

    public function store()
    {
        // Validation Request
        if (!$this->validate([
            'departement_id' => [
                'label' => 'Departement',
                'rules' => 'required|numeric'
            ],
            'employee_id' => [
                'label' => 'Employee ID',
                'rules' => 'required|numeric'
            ],
            'name' => [
                'label' => 'Name',
                'rules' => 'required'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'required'
            ],
        ])) {
            $errors_msg = \Config\Services::validation()->getErrors();
            return redirect()->to(base_url('admin/employee'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        $data = [
            'departement_id' => intval($this->request->getPost('departement_id')),
            'employee_id' => $this->request->getPost('employee_id'),
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
        ];

        $response = Api::send('POST', '/employee', [
            'json' => $data
        ]);

        // Handle Validation Error From API
        if ($response['data']['status_code'] === "04") {
            $errors_msg = $response['data']['data'];
            return redirect()->to(base_url('admin/employee'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        // Redirect With Send Status
        if ($response['data']['status_code'] === "00") {
            return redirect()->to('admin/employee')
                ->with('success', 'Data saved successfully!');
        } else {
            return redirect()->to('admin/employee')
                ->with('error', $response['data']['message']);
        }
    }

    public function update($id = null)
    {
        // Validation Request
        if (!$this->validate([
            'departement_id' => [
                'label' => 'Departement',
                'rules' => 'required|numeric'
            ],
            'employee_id' => [
                'label' => 'Employee ID',
                'rules' => 'required|numeric'
            ],
            'name' => [
                'label' => 'Name',
                'rules' => 'required'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'required'
            ],
        ])) {
            $errors_msg = \Config\Services::validation()->getErrors();
            return redirect()->to(base_url('admin/employee'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        $data = [
            'departement_id' => intval($this->request->getPost('departement_id')),
            'employee_id' => $this->request->getPost('employee_id'),
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
        ];

        $response = Api::send('PUT', '/employee/' . $id, [
            'json' => $data
        ]);

        // Handle Validation Error From API
        if ($response['data']['status_code'] === "04") {
            $errors_msg = $response['data']['data'];
            return redirect()->to(base_url('admin/employee'))
                ->with('error', $errors_msg[array_keys($errors_msg)[0]]);
        }

        // Redirect With Send Status
        if ($response['data']['status_code'] === "00") {
            return redirect()->to('admin/employee')
                ->with('success', 'Data saved successfully!');
        } else {
            return redirect()->to('admin/employee')
                ->with('error', $response['data']['message']);
        }
    }

    public function delete($id = null)
    {
        $response = Api::send('DELETE', '/employee/' . $id);

        if ($response['data']['status_code'] === "00") {
            return redirect()->to('admin/employee')
                ->with('success', 'Data deleted successfully!');
        } else {
            return redirect()->to('admin/employee')
                ->with('error', 'Failed to delete data!');
        }
    }
}
