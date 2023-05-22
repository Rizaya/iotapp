<?php

namespace App\Models;

use CodeIgniter\Model;

class Data_sensorModel extends Model
{
    protected $table = 'data_sensor';
    protected $allowedFields = ['value1', 'value2', 'value3', 'reading_time'];

    public function getStatistikValue($value, $min_value, $max_value, $avg_value)
    {
        $builder = $this->builder();
        $builder->selectMin($value, $min_value);
        $builder->selectMax($value, $max_value);
        $builder->selectAvg($value, $avg_value);
        $query = $builder->orderBy('id', 'DESC')->get();

        return $query->getRow();
    }
}
