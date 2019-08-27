<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    public function lead()
    {
        return $this->belongsTo('App\Lead','leads');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function getPendingTodayTodos(){
        $todaystart = strtotime('today 00:00');
        $todayend = strtotime('today 23:59:59');
        $userID = auth()->user()->id;
        $followUpCount = ToDo::where([
            ['status','=','pending'],
            ['due_date','>=',$todaystart],
            ['due_date','<=',$todayend],
            ['user_id','=',$userID]
        ])->count();
        return $followUpCount;
    }

}
