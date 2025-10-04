<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Api;
use CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController
{
    public function index()
    {
        // Fetch Report
        $params = [];
        if ($this->request->getGet('date')) {
            $params['date'] = $this->request->getGet('date');
        } else {
            $params['date'] = date('Y-m-d');
        }
        if ($this->request->getGet('departement_id')) {
            $params['departement_id'] = $this->request->getGet('departement_id');
        }

        $report = Api::send('GET', '/report', [
            'query' => $params
        ]);

        if (!$report['status']) {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to get data!');
        }

        // Fetch Departement
        $departement = Api::send('GET', '/departement');
        if (!$departement['status']) {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to get data departement!');
        }

        $data = [
            'data' => $report['data']['data'],
            'departement' => $departement['data']['data']
        ];

        return view('pages/admin/report/index', $data);
    }

    public function history($id = null)
    {
        // Fetch Report
        $report = Api::send('GET', '/report/' . $id);

        if (!$report['status']) {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to get data!');
        }

        $data = [
            'data' => $report['data']['data'],
        ];

        return view('pages/admin/report/history', $data);
    }
}
