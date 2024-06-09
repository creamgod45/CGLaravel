<?php

namespace App\Http\Controllers;

class HTMLTemplateController extends Controller
{
    public function Notification()
    {
        return view('HTMLTemplate.Notificationitem');
    }
}
