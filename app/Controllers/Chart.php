<?php

namespace App\Controllers;

use App\Models\Data_sensorModel;

class Chart extends BaseController
{
    public function getIndex()
    {
        return view('chart');
    }

    public function getFetchData()
    {
        $latestDataId = $this->request->getVar('latestDataId');
        $model = new Data_sensorModel();
        $data = $model->where("id > $latestDataId")->findAll();

        return $this->response->setJSON($data);
    }
}
