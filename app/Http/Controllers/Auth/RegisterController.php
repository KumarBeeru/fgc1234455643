<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use PHPUnit\Framework\Constraint\Exception;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],
        ]);
       
        $user_id = User::max('id');
        if($data['user_type'] == 'worker')
        {
            $shop = array(
                'name'=> $data['name'],
                'user_id' => $user_id,
            );
            try{
                DB::table('wor_info_tab')
                ->insert($shop);
            }catch(Exception $e){
            }
        }else{
            $shop = array(
                'shop_name'=> $data['name'],
                'user_id' => $user_id,
            );
            try{
                DB::table('shop_table')
                ->insert($shop);
            }catch(Exception $e){
    
            }
        }

        DB::table('account_table')
            ->insert([
                'user_id' => $user_id,
                'total_amt' => 0
            ]);

        return $data;
    }
}