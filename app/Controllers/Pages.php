<?php

namespace App\Controllers;

use App\Models\Data_sensorModel;

class Pages extends BaseController
{
    public function getIndex()
    {
        $dataModel = new Data_sensorModel();
        $statTemp = $dataModel->getStatistikValue('value3', 'min_temp', 'max_temp', 'avg_temp');
        $data = [
            'title' => 'Dashboard',
            'avg_temp' => $statTemp->avg_temp
        ];
        return view('dashboard', $data);
    }
    public function getTable()
    {
        $dataModel = new Data_sensorModel();
        $Sensor = $dataModel->findAll();
        $data = [
            'title' => 'Teble',
            'data' => $Sensor
        ];


        return view('table', $data);
    }
}
