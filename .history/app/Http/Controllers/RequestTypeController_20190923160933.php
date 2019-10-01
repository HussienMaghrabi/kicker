<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\request_type;

class RequestTypeController extends Controller
{
    public function AllTypes()
    {
        return request_type::getAll();
    }
}
