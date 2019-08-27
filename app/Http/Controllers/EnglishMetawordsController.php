<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\admin_en_meta;

class EnglishMetawordsController extends Controller
{
    public function index()
    {
        $data = admin_en_meta::all();
        return $data;
    }
}
