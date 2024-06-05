<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HTMLTemplateController extends Controller
{
    public function Notification()
    {
        return view('HTMLTemplate.Notificationitem');
    }
}
