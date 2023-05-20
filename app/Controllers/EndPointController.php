<?php

namespace App\Controllers;

use App\Models\Data_sensorModel;
use CodeIgniter\I18n\Time;

class EndpointController extends BaseController
{
    public function handlePostRequest()
    {
        function input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $data = new Data_sensorModel();

        $api_key_value = "tPmAT5Ab3j7F9";

        $api_key = input($this->request->getPost('api_key'));
        if ($api_key == $api_key_value) {
            $data->save([
                'value1' => input($this->request->getPost('value1')),
                'value2' => input($this->request->getPost('value2')),
                'value3' => input($this->request->getPost('value3')),
                'reading_time' => Time::createFromTimestamp(time(), 'WITA', 'id_ID')
            ]);

            return $this->response->setJSON(['status' => 'Success']);
        } else {
            return $this->response->setJSON(['status' => 'Error', 'message' => 'Wrong API Key provided.']);
        }
    }
}
