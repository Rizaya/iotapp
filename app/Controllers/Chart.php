<?php

namespace App\Controllers;

use App\Models\Data_sensorModel;

class Chart extends BaseController
{
    protected $dataModel;
    public function __construct()
    {
        $this->dataModel = new Data_sensorModel();
    }
    public function getIndex()
    {
        return view('chart');
    }

    public function getPhChart()
    {
        $data = [
            'title' => 'Grafik Perubahan pH'
        ];
        return view('phChart', $data);
    }
    public function getTdsChart()
    {
        $data = [
            'title' => 'Grafik Perubahan TDS'
        ];
        return view('tdsChart', $data);
    }
    public function getTempChart()
    {
        $data = [
            'title' => 'Grafik Perubahan Suhu'
        ];
        return view('tempChart', $data);
    }

    public function getFetchData()
    {
        $latestDataId = $this->request->getVar('latestDataId');

        $data = $this->dataModel->where("id > $latestDataId")->findAll();

        return $this->response->setJSON($data);
    }

    public function getFetchDataStat()
    {
        $value = $this->request->getVar('value');
        $min = $this->request->getVar('min');
        $max = $this->request->getVar('max');
        $avg = $this->request->getVar('avg');
        $stat = $this->dataModel->getStatistikValue($value, $min, $max, $avg);

        return $this->response->setJSON($stat);
    }

    public function getData()
    {
        $data = $this->dataModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON($data);
    }
}
