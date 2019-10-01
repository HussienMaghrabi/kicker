<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";
    protected $fillable = ['user_id','en_first_name','en_middle_name','en_last_name'
    ,'ar_first_name','ar_middle_name','ar_last_name','phone','personal_mail','company_mail'
    ,'job_category_id','job_title_id','industry_id','birth_date','address',
    'job_history','national_id','salary','is_hr','day_value',
    'finger_print_id','annual_vacations','unscheduled_vacation','requested_vacation',
    'gender','marital_status','military_status'];
    public function vacations(){
        return $this->hasMany('App\Vacation');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function requests(){
        return $this->hasMany('App\employee_request','id');
    }

    public function salary()
    {
        return $this->hasMany('App\Salary','employee_id');
    }

    public function rates(){
        return $this->hasMany('App\Rate','employee_id');
    }

}
