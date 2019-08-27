<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\admin_ar_meta;

class arabicMetawordsController extends Controller
{
    public function index()
    {
        $data = admin_ar_meta::all();
        return $data;
    }
}
