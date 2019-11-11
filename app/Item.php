<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class Item extends Model
{
    protected $table = "items";



    static function GetItemsByCompany($CId)
    {
        $c_items = DB::table('proposedcompany_item as c_item')
        ->leftjoin('items as item','c_item.item_id','=','item.id')
        ->select('item.id as id','item.name')
        ->where('c_item.proposed_company_id',$CId)
        ->get();
        return response()->json([
            'status'=>'success',
            'data'=>$c_items
        ]);
    }

    public function CompanyItems(){
        return $this->hasMany('App\proposedCompany_items');
    }

    static function getStore(Request $request){
       $item = new Item ;
       $item->name = $request->name;
       $item->description = $request->description;
       $item->save();

       $company = new proposedCompany_items;
       $company->proposed_company_id = $request->companyId;
       $company->item_id = $item->id;
       $company->save();
    }

    static function getUpdate(Request $request, $id){
        //
        DB::table("items")
            ->where('id',$id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        DB::table("proposedcompany_item")
            ->where("item_id",$id)
            ->update([
                "proposed_company_id" => $request->company_id
            ]);
    }

    static function getShow($id){
        $data= Item::select("id", "name", "description")
            ->where('id',$id)
            ->get();
        $data->map(function ($item) {
            $item->proposed_company = $item->CompanyItems[0]->company['name'];
            unset($item->CompanyItems);
        });
        return $data;
    }

    static function getItem(){
        $allData=Item::all();
        return response()->json([
            'status'=>'success',
            'data'=>$allData
        ]);
    }

    static function getDestroy($id){
        Item::findOrFail($id)->delete();
    }

    static function getSearch(Request $request){
        $data = Item::where('name', 'LIKE', '%' . $request->searchInput . '%')
            ->orwhere('description', 'LIKE', '%' . $request->searchInput . '%')
            ->get();
        return $data;
    }
}
