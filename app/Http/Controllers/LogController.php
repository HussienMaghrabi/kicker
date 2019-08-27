<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('settings') or @auth()->user()->type == 'admin' || @auth()->user()->agent_type_id == '7') {
                return $next($request);
            } else {
                session()->flash('error', __('admin.you_dont_have_permission'));
                return back();
            }
        });
    }

    public static function add_log($ar, $en, $route, $route_id, $type, $user_id, $old_data = null, $new_data = null)
    {
        $log = new Log;
        $log->ar_title = $ar;
        $log->en_title = $en;
        $log->route = $route;
        $log->route_id = $route_id;
        $log->type = $type;
        $log->user_id = $user_id;
        if (isset($old_data)) {
            $log->old_data = $old_data;
        }
        if (isset($new_data)) {
            $log->new_data = $new_data;
        }

        $log->save();
    }

    public function index()
    {
        $logs = DB::table('logs as log')
            ->join('users as user','log.user_id','=','user.id')
            ->select('log.id','log.route','log.'.app()->getLocale().'_title as title','log.type','user.name as agent','log.created_at')
            ->orderBy('log.id', 'desc')
            ->paginate(100);
        return response()->json($logs);
        // return view('admin.logs.index', ['title' => __('admin.logs'), 'logs' => Log::all()]);
    }

    public function show(Log $log)
    {
        // return view('admin.logs.show', ['title' => __('admin.log'), 'log' => Log::find($id)]);
        $user_name = DB::table('logs as log')
                    ->join('users as user','log.user_id','=','user.id')
                    ->where('log.id',$log->id)
                    ->select('user.name')
                    ->value('user.name');

        return response()->json([
            'logs'=>$log,
            'user_name'=>$user_name
        ]);

    }
}
