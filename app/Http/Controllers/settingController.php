<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\User;

class settingController extends Controller
{
    public $user_type = "";

    public function setting(Request $request){

        $user_type = User::where('id',Auth::id())->pluck('user_type');

        $setting = [];
        if($user_type[0] == "shop"){
            $setting = DB::table('shop_table')
                ->select('working_hour','work_exp','city','home_delivery')
                ->where('user_id',Auth::id())
                ->get();
        }
        else {
            $setting = DB::table('wor_info_tab')
                ->select('work_hour as working_hour','work_exp','city')
                ->where('user_id',Auth::id())
                ->get();
        }

        $area = DB::table('worker_service_area_tab')
                ->join('arealist_table','arealist_table.arealist_id','=','worker_service_area_tab.arealist_id')
                ->select('area_name','arealist_table.arealist_id','mini_price','wor_service_area_id')
                ->where('wor_info_id',Auth::id())
                ->get();


        $addable = DB::table('arealist_table')
                    ->select('area_name','arealist_id')
                    ->where('cityList_id',$setting[0]->city)
                    ->get();    
                    
        return view('pages.setting',['setting'=>$setting,'area'=>$area,'addableArea'=>$addable,'user_type'=>$user_type[0]]);
    }

    public function worklist(Request $request){

        $workList = DB::table('wor_price_list')
                    ->join('wor_list_tab','wor_price_list.wor_list_id','=','wor_list_tab.wor_list_id')
                    ->select('wor_list_tab.work_name','wor_price_list.*')
                    ->where('wor_info_id',Auth::id())
                    ->get();

        // var_dump($workList);
        // exit();
        return view('pages.worklist',['work_list'=>$workList]);
    }


    public function getsubcat(Request $request){

        $subcat = DB::table('wor_subcat_tab')
                ->where('wor_cat_id',$request->get('cat_id'))
                ->get();
            
        return $subcat;
    }

    public function getworklist(Request $request){

        $workListid = DB::table('wor_price_list')
                    ->select('wor_list_id')
                    ->where('wor_info_id',Auth::id())
                    ->get();

        $worklist = DB::table('wor_list_tab')
                ->where('wor_info_id',Auth::id())
                ->whereNotIn('wor_list_id',$workListid)
                ->get();

        return $worklist;
    }

    public function updateWorklist(Request $request){
        
        $worklist = DB::table('wor_list_tab')
            ->insert();

    }

    public function AddworklistView(Request $request){
        
        $workListid = DB::table('wor_price_list')
                    ->select('wor_list_id')
                    ->where('wor_info_id',Auth::id())
                    ->get();
        
        $idArray = [];
        foreach ($workListid as  $value) {
            array_push($idArray,$value->wor_list_id);
        }
        
        //var_dump($workListid);exit();


        $cat = DB::table('wor_cat_tab')
                ->get();

        $subcat = DB::table('wor_subcat_tab')
                ->where('wor_cat_id',$cat[0]->wor_cat_id)
                ->get();
       
        $worklist = DB::table('wor_list_tab')
                ->where('wor_subcat_id',54)
                ->whereNotIn('wor_list_id',$idArray)
                ->get();
        
        return view('pages.addworklist',['cat'=>$cat,'subcat'=>$subcat,'worklist'=>$worklist]);
    }

    public function Addworklist(Request $request){

        $worklist = DB::table('wor_list_tab')
                ->insert();
    }

    public function updateAreaList(Request $request){
        
        DB::table('worker_service_area_tab')
            ->updateOrInsert(
                ['wor_service_area_id' => $request->get('wlist_id')],
                ['area_name' => $request->get('name'), 'mini_price' => $request->get('price')]
            );

        return back();
    }


    /**
     * Update the setting 
     */
    public function updateSetting(Request $request){

    }
}
