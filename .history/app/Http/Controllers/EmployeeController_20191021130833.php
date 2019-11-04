<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\City;
use App\Contact;
use App\Country;
use App\Custody;
use App\Employee;
use App\HrSetting;
use App\JobCategory;
use App\JobTitle;
use App\Photo;
use App\employee_image;
use App\Rate;
use App\employeeContact;
use App\employeecontactemail;
use App\employeecontactphone;
use App\Salary;
use App\SalaryDetail;
use App\User;
use App\Vacation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('employees') or @auth()->user()->type == 'admin' or @auth()->user()->type == 'employee') {
                return $next($request);
            } else {
                session()->flash('error', __('admin.you_dont_have_permission'));
                return back();
            }
        });
    }


    public function getAllData()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('employees') or @auth()->user()->type == 'admin') {
            $employees = Employee::paginate(20);
            return response()->json($employees);
            // return view('admin.employee.index', ['title' => trans('admin.Employees'), 'employees' => $employees]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return response()->json('you dont have permission');
            // return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (checkRole('employees') or @auth()->user()->type == 'admin') {
            $title = __('admin.employee');
            $categories = JobCategory::pluck('en_name', 'id')->all();
            $job_titles = JobTitle::pluck('en_name', 'id')->all();
            return view('admin.employee.create', compact('title', 'job_titles', 'categories'));
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // return $request->all();
        $rules = [
            'en_first_name' => 'required',
            'en_middle_name' => 'required',
            'en_last_name' => 'required',
            'ar_first_name' => 'required',
            'ar_middle_name' => 'required',
            'ar_last_name' => 'required',
            'national_id' => 'required',
            'salary' => 'required',
            'phone' => 'required',
            'personal_mail' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_first_name' => trans('admin.en_first_name'),
            'en_middle_name' => trans('admin.en_middle_name'),
            'en_last_name' => trans('admin.en_last_name'),
            'ar_first_name' => trans('admin.ar_first_name'),
            'ar_middle_name' => trans('admin.ar_middle_name'),
            'ar_last_name' => trans('admin.ar_last_name'),
            'national_id' => trans('admin.national_id'),
            'salary' => trans('admin.salary'),
            'phone' => trans('admin.phone'),
            'personal_mail' => trans('personal_email'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            try {
                DB::beginTransaction();
                $user = new User();
                $user->email = $request->personal_mail;
                $user->password = bcrypt($request->password);
                $user->name = $request->en_first_name;
                $user->phone = $request->phone;
                $user->type = 'admin' == $request->type ? 'admin' : 'employee';
                $user->role_id = $request->role_id;
                $user->agent_type_id = 0;
                $user->user_id = 0;
                $user->save();
                $employee = new Employee();
                $employee->en_first_name = $request->en_first_name;
                $employee->en_middle_name = $request->en_middle_name;
                $employee->en_last_name = $request->en_last_name;
                $employee->ar_first_name = $request->ar_first_name;
                $employee->ar_middle_name = $request->ar_middle_name;
                $employee->ar_last_name = $request->ar_last_name;
                $employee->national_id = $request->national_id;
                $employee->salary = $request->salary;
                $employee->gender = $request->gender;
                $employee->marital_status = $request->marital_status;
                $employee->military_status = $request->military_status;
                $employee->phone = $request->phone;
                $employee->personal_mail = $request->personal_mail;
                // $employee->company_mail = $request->company_mail;
                $employee->job_category_id = $request->job_category_id;
                $employee->job_title_id = $request->job_title_id;
                $employee->day_value = $request->salary / 30;
                // $employee->photo_id = $request->profile_photo;
                $employee->user_id = $user->id;
                if ('admin' == $request->type) {
                    $employee->is_hr = 1;
                }
                // $hr_setting_anuual = HrSetting::where('name', '=', 'annual_vacation')->first();
                // if($hr_setting_anuual){
                //     $employee->annual_vacations = $hr_setting_anuual->value;
                // }
                // $hr_setting_unscheduled = HrSetting::where('name', '=', 'unscheduled_vacation')->first();
                // if($hr_setting_unscheduled){
                //     $employee->unscheduled_vacation = $hr_setting_unscheduled->value;                
                // }
                $employee->save();

                if ($file = $request->file('profile_photo')) {
                    $image = uploads($request, 'profile_photo');
                    $photo = employee_image::create(['image' => $image, 'employee_id' => $employee->id]);
                    $em = Employee::where('photo_id', $request->profile_photo)->first();
                    $em->photo_id = $photo->id;
                    $em->save();
                }

                $us = User::where('id', $employee->id)->first();
                if($us){
                    $us->employee_id = $employee->id;  
                    $us->save();
                }
             

                if ($request->has('contact_name')) {
                    foreach ($request->contact_name as $k => $v) {
                        $contact = new Contact;
                        $contact->employee_id = $employee->id;
                        $contact->name = $request->contact_name[$k];
                        $contact->relation = $request->contact_relation[$k];
                        $contact->nationality = $request->contact_nationality[$k];
                        $contact->title_id = $request->contact_title_id[$k];
                        $contact->email = $request->contact_email[$k];
                        $contact->other_emails = json_encode($request->contact_other_emails[$k]);
                        $contact->phone = $request->contact_phone[$k];
                        $contact->other_phones = json_encode($request->contact_other_phones[$k]);
                        $contact->social = json_encode($request->contact_social[$k]);
                        if ($request->has('contact_other_phones')) {
                            foreach ($request->contact_other_phones[$k] as $k1 => $v1) {
                                $contactPhones[] = [
                                    $request->contact_other_phones[$k][$k1] => $request->contact_other_socials[$k][$k1],
                                ];
                            }
                            $contact->other_phones = json_encode($contactPhones);
                        };
                        $contact->save();
                    }
                }
                if ($request->has('salary')) {
                    $basic = new Salary;
                    $basic->basic = $request->salary;
                    $basic->full_salary = $request->salary;
                    $basic->hour_value = $request->salary / (30 * 8);
                    $basic->employee_id = $employee->id;
                    $basic->save();
                }

                DB::commit();
                session()->flash('success', trans('admin.created'));
            } catch (Exception $ex) {
                DB::rollBack();
                session()->flash('error', trans('admin.failed'));
                return back();
            }
            
            return response()->json(["status"=>"Added"],200);
            // return redirect(adminPath() . '/employees/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

       

        if (auth()->user()->employee_id == $employee->id || auth()->user()->type == 'admin' || Employee::find(auth()->user()->employee_id)->is_hr == 1) {
            $attends = Attendance::where('finger_print_id', $employee->finger_print_id)->get();
            $employee_id = $employee->id;
            $custodies = Custody::all();
            $salaries = Salary::where('employee_id', $employee_id)->get();
            $toltal_basic_salary = $salaries->sum('basic');
            $total_gross = $salaries->sum('gross');
            $total_net = $salaries->sum('net');
            $total_full_salary = $salaries->sum('full_salary');
            $vacations = Vacation::where('type', 'request')->where('employee_id', '=', $employee->id)->get();
            $national_vacations = Vacation::where('type', 'annual')->get();
            $title = __('admin.employee');

            $remps = Rate::where('employee_id', '=', $employee->id)
                ->where('Is_rated', '=', 0)
                ->pluck('rated_employee_id');
            $rated_employees = [];
            foreach ($remps as $value) {
                $rated_employees[] = @\App\Employee::where('id', $value)->first();
            }
            $ratour_count = Rate::where('rated_employee_id', '=', $employee_id)->count();
            if (0 != $ratour_count) {
                $rated_work = Rate::where('rated_employee_id', '=', $employee_id)->sum('work') / $ratour_count;
                $rated_apperance = Rate::where('rated_employee_id', '=', $employee_id)->sum('apperance') / $ratour_count;
                $rated_effeciant = Rate::where('rated_employee_id', '=', $employee_id)->sum('effeciant') / $ratour_count;
                $rated_target = Rate::where('rated_employee_id', '=', $employee_id)->sum('target') / $ratour_count;
                $rated_ideas = Rate::where('rated_employee_id', '=', $employee_id)->sum('ideas') / $ratour_count;
                $total_kpi = $rated_work + $rated_apperance + $rated_effeciant + $rated_target + $rated_ideas;
                $kpi_percent = (int) (($total_kpi / 25) * 100);
            } else {
                $kpi_percent = 0;
                $rated_work = 0;
                $rated_apperance = 0;
                $rated_effeciant = 0;
                $rated_target = 0;
                $rated_ideas = 0;
            }

        $employeeData = DB::table('employees as employee')
        ->join('countries as country','employee.country_id','=','country.id')
        ->join('cities as city','employee.city_id','=','city.id')
        ->join('job_titles as title','employee.job_title_id','title.id')
        ->select('country.name as countryName','city.name as cityName','title.en_name as jobtitle')
        ->get();
            return response()->json([
                "employee"=>$employee,
                "employeeData"=>$employeeData
            ]);

            // return response()->json($employee);
            // return view('admin.employee.show', compact('employee', 'title', 'salaries', 'toltal_basic_salary', 'total_gross', 'total_net', 'total_full_salary', 'vacations', 'national_vacations', 'custodies', 'rated_employees', 'employee_id', 'kpi_percent', 'rated_work', 'rated_apperance', 'rated_effeciant', 'rated_target', 'rated_ideas', 'attends'));
        } else {
            // session()->flash('error', __('admin.you_dont_have_permission'));
            // return back();
            return response()->json('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (checkRole('employees') or @auth()->user()->type == 'admin') {
            $title = __('admin.employee');
            $categories = JobCategory::pluck('en_name', 'id')->all();
            $job_titles = JobTitle::pluck('en_name', 'id')->all();
            $employee = Employee::findOrFail($id);
            return view('admin.employee.edit', compact('employee', 'title', 'job_titles', 'categories'));
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'en_first_name' => 'required',
            'en_middle_name' => 'required',
            'en_last_name' => 'required',
            'ar_first_name' => 'required',
            'ar_middle_name' => 'required',
            'ar_last_name' => 'required',
            'national_id' => 'required',
            'salary' => 'required',
            'phone' => 'required',
            'personal_mail' => 'required',
            'finger_id' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_first_name' => trans('admin.en_first_name'),
            'en_middle_name' => trans('admin.en_middle_name'),
            'en_last_name' => trans('admin.en_last_name'),
            'ar_first_name' => trans('admin.ar_first_name'),
            'ar_middle_name' => trans('admin.ar_middle_name'),
            'ar_last_name' => trans('admin.ar_last_name'),
            'national_id' => trans('admin.national_id'),
            'salary' => trans('admin.salary'),
            'phone' => trans('admin.phone'),
            'password' => trans('admin.password'),
            'personal_mail' => trans('admin.personal_email'),
            'finger_id' => trans('admin.finger_id'),
            'role_id' => trans('admin.role_id'),
            'type' => trans('admin.type'),

        ]);
        if ($validator->fails()) {
            // return back()->withInput()->withErrors($validator);
            return response()->json(["data"=>"bad request"],402);
        } else {
            $employee = Employee::find($id);
            $employee->en_first_name = $request->en_first_name;
            $employee->en_middle_name = $request->en_middle_name;
            $employee->en_last_name = $request->en_last_name;
            $employee->ar_first_name = $request->ar_first_name;
            $employee->ar_middle_name = $request->ar_middle_name;
            $employee->ar_last_name = $request->ar_last_name;
            $employee->national_id = $request->national_id;
            // $employee->national_id_images = $request->national_id_images;
            $employee->salary = $request->salary;
            $employee->day_value = $request->salary / 30;
            $employee->gender = $request->gender;
            $employee->marital_status = $request->marital_status;
            $employee->military_status = $request->military_status;
            $employee->phone = $request->phone;
            $employee->personal_mail = $request->personal_mail;
            $employee->company_mail = $request->company_mail;
            $employee->job_category_id = $request->job_category_id;
            $employee->job_title_id = $request->job_title_id;
            $employee->photo_id = $request->photo_id;
            $user = User::find($employee->user_id);
            $user->email = $request->personal_mail;
            $user->password = bcrypt($request->password);
            $user->name = $request->en_first_name;
            $user->phone = $request->phone;
            $user->type = 'admin' == $request->type ? 'admin' : 'employee';
            $user->role_id = $request->role_id;
            $user->save();

            if ($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file' => $name]);
                $employee['photo_id'] = $photo->id;
            }

            $employee->save();
            // $user = User::where('id', Auth::user()->id);
            // $user->email = $request->personal_mail;
            // $user->password = bcrypt($request->password);
            // $user->name = $request->en_first_name;
            // $user->phone = $request->phone;

            // session()->flash('success', trans('admin.updated'));
            // return redirect(adminPath() . '/employees/');

            return response()->json(["status"=>"Updated"],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        @unlink(public_path() . $employee->Photo->file);

        $employee->delete();
        session()->flash('success', trans('admin.deleted'));
        // return redirect(adminPath() . '/employees');
        return response()->json(["status"=>"Deleted"],200);
    }

    public function updateEmployee(Request $request)
    {
        if (auth()->user()->type == 'admin' || Employee::find(auth()->user()->employee_id)->is_hr == 1) {
            $new_cities = '';
            $id = $request->id;
            $type = $request->type;
            $value = $request->value;

            if ('birth_date' == $type) {
                $value = $request->value;
            }
            $employee = Employee::find($id);
            $employee->$type = $value;
            $employee->save();
            if ('nationality' == $type) {
                $value = Country::find($value)->name;
            }

            if ('religion' == $type) {
                $value = __('admin.' . $value);
            }
            if ('job_title_id' == $type) {
                $value = JobTitle::find($value)->name;
            }

            if ('facebook' == $type) {
                $value = '<a href="https://www.facebook.com/' . $value . '" target="_blank"><b><i class="fa fa-facebook" aria-hidden="true"></i></b></a>';
            }
            if ('country_id' == $type) {
                $new_cities = '';
                $new_cities .= '<option></option>';
                foreach (City::where('country_id', $value)->get() as $country) {
                    $new_cities .= '<option value="' . $country->id . '">' . $country->name . '</option>';
                }
                $value = Country::find($value)->name;
            }
            if ('city_id' == $type) {
                $value = City::find($value)->name;
            }

            return response()->json([
                'value' => $value,
                'type' => $type,
                'new_cities' => $new_cities,
            ]);
        }
    }

    public function getAllContacts($id){
        $getContacts = DB::table('employee_contact as contact')
        ->leftJoin('employee_contact_email as contact_mail','contact_mail.employee_contact_id','=','contact.id')
        ->leftJoin('employee_contact_phone as contact_phone','contact_phone.employee_contact_id','=','contact.id')
        ->select('contact.id as id','contact.name','contact.email','contact.phone','contact.relation')
        ->where('contact.id',$id)
        ->get();
        return $getContacts;
    }

    public function imageCollector(Request $request)
    {
        $rules = [
            'code' => 'required',
            'employee_id' => 'required',
            'image' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'code' => trans('admin.code'),
            'employee_id' => trans('admin.employee_id'),
            'image' => trans('admin.image'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            if ($file = $request->file('image')) {
                $image = uploads($request, 'image');
                $photo = new Photo();
                $photo->image = $image;
                $photo->code = $request->code;
                $photo->employee_id = $request->employee_id;
                $photo->save();
            }

            return back();
        }
    }

    public function EmployeeController(Request $request)
    {
        dd($request->all());
    }

    public function salaryNotes(Request $request)
    {
        $rules = [
            'date' => 'required',
            'by' => 'required',
            'details' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'date' => trans('admin.date'),
            'by' => trans('admin.by'),
            'details' => trans('admin.details'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $salary = Salary::where('employee_id', $request->employee_id)->first();
            $salary_detail = new SalaryDetail();
            $salary_detail->employee_id = $request->employee_id;

            if ($request->allowances) {
                $salary_detail->allowances = $request->allowances;

                $salary->gross = $request->allowances + $salary->gross;

                $salary_detail->full_salary = $salary->full_salary + $request->allowances;
                $salary->full_salary = $salary->basic + $salary->gross - $salary->net;
                $salary_detail->status = 'increase';
            } elseif ($request->deductions) {
                $salary_detail->deductions = $request->deductions;
                $salary_detail->full_salary = $salary->full_salary - $request->deductions;
                $salary->net = $request->deductions + $salary->net;
                $salary->full_salary = $salary->basic + $salary->gross - $salary->net;
                $salary_detail->status = 'decrease';
            }

            $salary_detail->ordered_time = $request->date;
            $salary_detail->ordered_by = $request->by;
            $salary_detail->details = $request->details;
            $salary->employee_id = $request->employee_id;
            $salary_detail->save();
            $salary->save();
            return back();
        }
    }

    public function addErContact(request $request){
        // dd($request->all());
        $employeeContact = new employeeContact;
        $employeeContact->name = $request->name;
        $employeeContact->email = $request->email;
        $employeeContact->employee_id = $request->employee_id;
        $employeeContact->relation = $request->relation;
        $employeeContact->relation = $request->relation;
        $employeeContact->phone = $request->phone;
        $employeeContact->save();
         foreach($request->phones as $phone){
             $EatcPhone = json_decode($phone);
             if($EatcPhone){
                 foreach($EatcPhone as $objectPhone){
                     $contactPhone = new employeecontactphone;
                     $contactPhone->phone = $objectPhone->phone;
                     $contactPhone->employee_contact_id = $employeeContact->id;
                     $contactPhone->save();
                 }
             }
         }
         foreach($request->emails as $email){
             $eatchEmail = json_decode($email);
             if($eatchEmail){
                foreach($eatchEmail as $objectEmail){
                    $contactEmail = new employeecontactemail;
                    $contactEmail->email = $objectEmail->email;
                    $contactEmail->employee_contact_id = $employeeContact->id;
                    $contactEmail->save();
                }
             }
         }
    }

    // public function oldaddErContact(request $request)
    // {
    //     // dd($request->all());
    //     foreach ($request->emails as $email) {
    //         $A = json_decode($email);
    //         return $A;
    //     }
    //     // $A = json_decode($request->emails);
    //     // return $request->emails;
    //     // if ($request->has('contact_name')) {
    //         foreach ($request->contact_name as $k => $v) {
    //             $contact = new Contact;
    //             $contact->employee_id = $request->employee_id;
    //             $contact->name = $request->contact_name[$k];
    //             $contact->relation = $request->contact_relation[$k];
    //             $contact->nationality = $request->contact_nationality[$k];
    //             $contact->title_id = $request->contact_title_id[$k];
    //             $contact->email = $request->contact_email[$k];
    //             $contact->other_emails = json_encode($request->contact_other_emails[$k]);
    //             $contact->phone = $request->contact_phone[$k];
    //             $contact->other_phones = json_encode($request->contact_other_phones[$k]);
    //             $contact->social = json_encode($request->contact_social[$k]);
    //             if ($request->has('contact_other_phones')) {
    //                 foreach ($request->contact_other_phones[$k] as $k1 => $v1) {
    //                     $contactPhones[] = [
    //                         $request->contact_other_phones[$k][$k1] => $request->contact_other_socials[$k][$k1],
    //                     ];
    //                 }
    //                 $contact->other_phones = json_encode($contactPhones);
    //             };
    //             $contact->save();
    //         }
    //     // }
    //     return back();
    // }

    public function addCustody(Request $request)
    {
        $rules = [
            'title' => 'required',
            'qr_code' => 'required',
            'status' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'title' => trans('admin.title'),
            'qr_code' => trans('admin.qr_code'),
            'status' => trans('admin.status'),
            'date' => trans('admin.date'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            if ($request->has('employee_id')) {
                $custody = new Custody();
                $custody->title = $request->title;
                $custody->employee_id = $request->employee_id;
                $custody->qr_code = $request->qr_code;
                $custody->status = $request->status;
                $custody->date = $request->date;
                $custody->save();
                return back();
            }
        }
    }

    public function allowRate(Request $request)
    {
        if ($request->has('rated_employee_id')) {
            for ($x = 0; $x < count($request->employee_id); $x++) {
                $rate = new Rate();
                $rate->rated_employee_id = $request->rated_employee_id;
                $rate->employee_id = $request->employee_id[$x];
                $rate->save();
            }
            return back();
        }
    }

    public function employee_slip(Request $request)
    {
        $rules = [
            'foo' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withInput()->withErrors('Whoops! There were some problems with your input.Please select atleast one to print!');
        } else {
            $dates = $request->foo;
            $dates_count = count($dates);
            $employee_id = $request->employee_id;
        }
        return view('admin.employee.salary_slip', compact('dates', 'dates_count', 'employee_id'));
    }

    public function searchEmployees(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $employees = DB::table('employees')
			->where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('en_first_name', 'LIKE', '%' . $search . '%')  
            ->orWhere('personal_mail', 'LIKE', '%' . $search . '%')  
            ->orWhere('phone', 'LIKE', '%' . $search . '%')  
            ->orWhere('gender', 'LIKE', '%' . $search . '%')    
            ->select('id','en_first_name','personal_mail','phone','gender')
            ->get();
            return $employees;
        }

    }

    public function getAllJobTitles(){
        $jobTitles = DB::table('job_titles')->select('id','en_name')->get();
        return response()->json($jobTitles);
    }
    
    public function getAllRoles(){
        $roles= DB::table('roles')->select('id','name')->get();
        return response()->json($roles);
    }

    public function updateEmployees(Request $request)
	{
		// dd($request->all());
		$employees = Employee::where('id',$request->employee_id)->first();
		$employeeData = Employee::where('id',$request->employee_id)->first();
		// if(!empty($request->first_name and $request->last_name)){
		// 	$employees->full_name = $request->first_name.' '.$request->last_name;
		// }
		if($request->en_first_name){
			$employees->en_first_name = $request->en_first_name;
		}
		if($request->en_last_name){
			$employees->en_last_name = $request->en_last_name;
		}
		if($request->ar_first_name){
			$employees->ar_first_name = $request->ar_first_name;
		}
		if($request->ar_last_name){
			$employees->ar_last_name = $request->ar_last_name;
		}
        if($request->nationality){
			$employees->nationality = $request->nationality;
		}
		if($request->religion){
			$employees->religion = $request->religion;
		}
		if($request->country_id){
			$employees->country_id = $request->country_id;
        }
        if($request->jobtitle){
			$employeeData->jobtitle = $request->jobtitle;
		}
		if($request->city_id){
			$employeeData->city_id = $request->city_id;
        }
        if($request->birth_date){
			$employees->birth_date = $request->birth_date;
        }
        if($request->school){
			$employees->school = $request->school;
        }
        if($request->company){
			$employees->company = $request->company;
		}
		if($request->facebook){
			$employees->facebook = $request->facebook;
        }
        if($request->notes){
			$employees->notes = $request->notes;
		}
		$employees->update();
		return response()->json([
			'status' => 200,
			'massege' => 'Employee updated'
		]);
	}
    
}
