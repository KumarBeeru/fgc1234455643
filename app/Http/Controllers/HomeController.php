<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $ac_bal = 0;
        $Account_balance = DB::table('account_table')
                    ->select('total_amt')
                    ->where('user_id',Auth::id())
                    ->get();
        
        $user_type = User::where('id',Auth::id())->pluck('user_type');

        $profile = [];
        if($user_type[0] == "shop"){
            $profile = DB::table('shop_table')
                    ->select('aadhar_no')
                    ->where('user_id',Auth::id()) 
                    ->get(); 
        }
        else{
            $profile = DB::table('wor_info_tab')
                ->select('aadhar_no')
                ->where('user_id',Auth::id()) 
                ->get();
        }

        if(sizeof($Account_balance,1)){
            $ac_bal = $Account_balance[0]->total_amt;
        }

        $ratting = DB::table('feedback_table')
                ->join('lot_tab','feedback_table.lot_id' ,'=', 'lot_tab.lot_id')
                ->where('lot_tab.shopID',Auth::id())
                ->avg('ratting');


        
        $active_work = DB::table('lot_tab')
                        ->select('')



        return view('dashboard',['balance'=>$ac_bal,'check'=>$profile[0]->aadhar_no]);
    }
}
