<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\vacancy_type;

class VacancyTypeController extends Controller
{
    public function index()
    {
        return vacancy_type::vacancyType();
    }
}
