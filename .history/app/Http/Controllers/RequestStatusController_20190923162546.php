<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\request_status;

class RequestStatusController extends Controller
{
    public function AllStatus()
    {
        return request_status::paginate(100);
    }
}
