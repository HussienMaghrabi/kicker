<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\adminSeo;
use \App\admin_ar_meta;

class adminSeoController extends Controller
{
    public function index()
    {
        // dd($request->all());
        $seo = adminSeo::first();
        return $seo;
    }
    public function update(Request $request)
    {
        dd($request->AR_Keywords);
        if($request->AR_Keywords){
            foreach (admin_ar_meta::all() as $key => $value) {
                $value->delete();
            }
            foreach ($request->AR_Keywords as $key => $value) {
                $a = json_decode($value);
                dd($a->name);
                $n = new admin_ar_meta;
                $n->name = $a->name;
                $n->seo_id = 1;
                $n->save();
            }
        }
        if($request->EN_Keywords){
            foreach (admin_en_meta::all() as $key => $value) {
                $value->delete();
            }
            foreach ($request->EN_Keywords as $key => $value) {
                $a = json_decode($value);
                // dd($a);
                $n = new admin_en_meta;
                $n->name = $a->name;
                $n->seo_id = 1;
                $n->save();
            }
        }
        $seo = adminSeo::first();
        $seo->meta_ar = $request->meta_ar;
        $seo->meta_en = $request->meta_en;
        $seo->google_js_f = $request->google_js_f;
        $seo->google_js_s = $request->google_js_s;
        $update = $seo->update();
        if ($update) {
            return response()->json([
                'massege' => 'update'
            ],200);
        }
    }
}
