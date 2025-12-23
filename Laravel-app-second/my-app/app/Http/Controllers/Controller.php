<?php

namespace App\Http\Controllers;

class Controller
{
    //
    function hello() {
            return view('hello',['name' => 'RAKIB']);
    }

    public function dashboard() {
        return view('dashboard');
    }
}
