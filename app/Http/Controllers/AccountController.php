<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use DB;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function showAccountPage(Request $request){

        $ac_bal = 0;
        $Account_balance = DB::table('account_table')
                        ->select('total_amt')
                        ->where('user_id',Auth::id())
                        ->get();

        $transaction = DB::table('transaction_table')
                    ->where('user_id' , Auth::id())
                    ->skip(0)->take(10)
                    ->get();

        if(sizeof($Account_balance,1)){
            $ac_bal = $Account_balance[0]->total_amt;
        }
        
        // var_dump($ac_bal);

        // var_dump($transaction);
        // exit();

        return view('pages.map',['account'=>$ac_bal,'transaction'=>$transaction]);

    }
}
