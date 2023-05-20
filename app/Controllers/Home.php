<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function getIndex()
    {
        $data = [
            'title' => 'Home'
        ];
        return view('home', $data);
    }
    public function getContact()
    {
        echo 'Kontak';
    }
}
