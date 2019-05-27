<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use DB;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function ShowFeedback(Request $request){

        $feedback = DB::table('feedback_table')
                ->join('lot_tab','feedback_table.lot_id' ,'=', 'lot_tab.lot_id')
                ->join('customer_info_tab','customer_info_tab.customer_info_id','=','lot_tab.customer_info_id')
                ->select('lot_tab.lot_id','ratting','feedback','remark','customer_info_tab.cname')
                ->where('lot_tab.shopID',Auth::id())
                ->get();

        return view('pages.feedback',['feedback'=>$feedback]);
    }
}
