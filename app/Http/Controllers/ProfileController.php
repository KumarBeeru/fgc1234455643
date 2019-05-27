<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use DB;
use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;

class ProfileController extends Controller
{
    public $user_type = "";
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */

    public function edit()
    {

        global $user_type;

        $user_type = User::where('id',Auth::id())->pluck('user_type');
        
        $profile = [];
        if($user_type[0] == "shop"){
            $profile = DB::table('shop_table')
                        ->where('user_id',Auth::id()) 
                        ->get(); 
        }
        else{
            $profile = DB::table('wor_info_tab')
                ->select('name as shop_name','city','pic','aadhar_no','phone1','phone2','address','area','pin_code as pincode')
                ->where('user_id',Auth::id()) 
                ->get();
        }

        $city = DB::table('citylist_table')->get();
        $area = array();
        if(sizeof($city,1)){
            global $area;
            $area = DB::table('arealist_table')
                ->where('cityList_id',$city[0]->city_id)
                ->get();
        }

        // var_dump($area);
        // exit();

        return view('profile.edit',['profile'=>$profile,'city'=>$city,'area'=>$area]);
    }

    /** 
     * Get Area useing city List id
     */
    public function getArea(Request $request){
        
        $area = DB::table('arealist_table')
                ->where('cityList_id',$request->city_id)
                ->get();
        return $area;
    }

    

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    private function upload_image(ProfileRequest $request){

        // request()->validate([

        //     'profile_pic' => 'required|profile_pic|mimes:jpeg,png,jpg,gif,svg|max:2048',
        
        // ]);

        echo "print";
        $imageName = time().'.'.request()->profile_pic->getClientOriginalExtension();

        request()->profile_pic->move(public_path('images'), $imageName);

        return $imageName;
    } 

    public function update(ProfileRequest $request)
    {

        $imageName = "";
        $imagePath = "";
        //var_dump($_FILES);
        $files = $request->file('image');
        //var_dump($files);
        if ($files != null ) {
           //echo "profile pic found";
           $destinationPath = 'public/worker/'; 
           $imageName = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $imageName);
           $imagePath = $destinationPath . $imageName;
        }    

        global $user_type;
        
        $user_type = User::where('id',Auth::id())->pluck('user_type');

        if($user_type[0] == "shop"){

            $shop_data = array(
                'shop_name'=>$request->get('name'),
                'city'=>$request->get('city'),
                'area'=>$request->get('area'),
                'phone1'=>$request->get('phone1'),
                'phone2'=>$request->get('phone2'),
                'address'=>$request->get('address'),
                'pincode'=>$request->get('pincode'),
                'aadhar_no'=>$request->get('aadhar'),
            );
            if($imageName != ""){
                $shop_data['pic'] = $imagePath;
            }
            DB::table('shop_table')
                ->where('user_id',Auth::id())
                ->update($shop_data);

        }
        else {
            $shop_data = array(
                'name'=>$request->get('name'),
                'city'=>$request->get('city'),
                'area'=>$request->get('area'),
                'phone1'=>$request->get('phone1'),
                'phone2'=>$request->get('phone2'),
                'address'=>$request->get('address'),
                'pin_code'=>$request->get('pincode'),
                'aadhar_no'=>$request->get('aadhar'),
            );

            if($imageName != ""){
                $shop_data['pic'] = $imagePath;
            }

            // var_dump($shop_data);
            // exit();

            DB::table('wor_info_tab')
                ->where('user_id',Auth::id())
                ->update($shop_data);
        }
       // auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
}
