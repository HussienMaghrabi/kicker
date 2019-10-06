<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\deduction;
class deductionController extends Model
{
    public function store(Request $request)
    {
        dd($request->all());
    }
}
