<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\hrSettings;

class hrSettingsController extends Controller
{
    public function index()
    {
        $hr = new hrSettings;
        return $hr->getAll();
    }
}
