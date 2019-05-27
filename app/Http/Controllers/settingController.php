<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\User;
use Mockery\Exception;
use Illuminate\Support\Facades\Redirect;

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


        //echo $setting[0]->city;

        $addable = DB::table('arealist_table')
                    ->select('area_name','arealist_id')
                    ->where('cityList_id',$setting[0]->city)
                    ->get();    
        
        //var_dump($addable);

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
                    ->where('wor_subCat_id',$request->get('sub_id'))
                    ->get();
        
        $idArray = [];
        foreach ($workListid as  $value) {
            array_push($idArray,$value->wor_list_id);
        }

        $worklist = DB::table('wor_list_tab')
                ->where('wor_subcat_id', $request->get('sub_id'))
                ->whereNotIn('wor_list_id', $idArray)
                ->get();

        return $worklist;
    }

    public function updateWorklist(Request $request){

        DB::table('worker_service_area_tab')
            ->update(
                ['wor_service_area_id' => $request->get('wlist_id')],
                ['area_name' => $request->get('name'), 'mini_price' => $request->get('price')]
            );
        return back();
    }

    public function workpriceUpdate(Request $request){
        
        try{
            DB::table('wor_price_list')
                ->where('wor_info_id',Auth::id())
                ->where('wor_list_id',$request->get('wl_id'))
                ->update(['price' => $request->get('price')]);

            return 'Updated successfully.';
        }
        catch(Exception $e){
            return 'Somrthing is wrong.';
        }

        
    }

    public function workListDelete(Request $request){
        //setting/wldelete

        try{
            DB::table('wor_price_list')
                ->where('wor_info_id',Auth::id())
                ->where('wor_list_id',$request->get('wl_id'))
                ->delete();

            return 'Deleted successfully.';
        }
        catch(Exception $e){
            return 'Somrthing is wrong.';
        }
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
                ->where('wor_subcat_id',$subcat[0]->wor_subcat_id)
                ->whereNotIn('wor_list_id',$idArray)
                ->get();

        return view('pages.addworklist',['cat'=>$cat,'subcat'=>$subcat,'worklist'=>$worklist]);
    }

    public function AddWorklist(Request $request){

             DB::table('wor_price_list')
                ->insert([
                        'wor_cat_id' => $request->get('cat_name'), 
                        'wor_subCat_id' => $request->get('sub_name'),
                        'wor_info_id' => Auth::id(),
                        'wor_list_id' => $request->get('name'),
                        'price' => $request->get('price'),
                    ]);

        // var_dump($_POST);
        // exit();

        return Redirect::to('worklist');
    }

    public function updateAreaList(Request $request){
        
        // var_dump($_POST);
        // exit();
        try{
            DB::table('worker_service_area_tab')
                ->where('wor_service_area_id', $request->get('wlist_id'))
                ->update(
                    ['arealist_id' => $request->get('name'), 'mini_price' => $request->get('price')]
                );

            
            return back();
        }
        catch(Exception $ex){
            return back()->withStatus_(__('Updated Successfully.'));
        }
    }

    public function AddAreaList(Request $request){
        
        try{
            DB::table('worker_service_area_tab')
            ->Insert(
                ['arealist_id' => $request->get('name'), 
                'mini_price' => $request->get('price'),
                'wor_info_id' => Auth::id()]
            );
            return back()->withStatus_(__('Updated Successfully.'));
        }
        catch(Exception $ex){
            return back()->withStatus_(__('Updated Successfully.'));
        }
    }


    /**
     * Update the setting 
     */
    public function updateSetting(Request $request){
       
        var_dump($_POST);

        $h_d = 0;

        if(isset($_POST['home_delivery']))
        {
            $h_d = 1;
        }

        $user_type = User::where('id',Auth::id())->pluck('user_type');

        if($user_type[0] == "shop"){

            $shop_data = array(
                'work_exp'=>$request->get('workexp'),
                'working_hour'=>$request->get('strhour'),
                'home_delivery'=>$h_d
            );
            DB::table('shop_table')
                ->where('user_id',Auth::id())
                ->update($shop_data);

        }
        else {
            $shop_data = array(
                'work_exp'=>$request->get('workexp'),
                'work_hour'=>$request->get('strhour'),
            );
            DB::table('wor_info_tab')
                ->where('user_id',Auth::id())
                ->update($shop_data);
        }

        return back()->withStatus(__('Profile successfully updated.'));
    }
}
