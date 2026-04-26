<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function store(Request $request){
        $email = $request->input('email');

        return $email;
    }
}
