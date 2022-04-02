<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use Hash;
use Carbon\Carbon;
use Session;
use Brian2694\Toastr\Facades\Toastr;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    public function login() {

        return view('auth.login');
    }

    public function proceed_login(Request $request) {
        
        $phone = $request->phone;

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        $user = User::where('phone_number', $phone)->first();

        $activityLog = [
            'name' => $user->email,
            'email' => $user->email,
            'description' => 'has log in',
            'date_time' => $todayDate,
        ];
        
  
        if (Auth::attempt(['phone_number' => $phone, 'email' => $user->email, 'password' => Hash::check('plain-text', $user->password)])) {
            DB::table('activity_logs')->insert($activityLog);
        }
        echo json_encode("success");
       
    }

    public function LogMeIn(Request $request) {
        $fields = $request->validate([
            'phone' => 'required'
        ]);

        $user = User::where('phone_number', $fields['phone'])->first();
        if (!$user || ($user['status'] != "Active")) {
            echo 'bad credentials';
        } else {
            echo 'success';
        }
    }

    public function authenticate(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $email = $request->email;
        $password = $request->password;

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $activityLog = [
            'name' => $email,
            'email' => $email,
            'description' => 'has log in',
            'date_time' => $todayDate,
        ];
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 'Active'])) {
            //DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully :)', 'Success');
            //return redirect()->intended('home');

            return redirect('login');
        } elseif (Auth::attempt(['email' => $email, 'password' => $password, 'status' => null])) {
            DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully :)', 'Success');
            return redirect()->intended('home');
        } else {
            Toastr::error('fail, WRONG USERNAME OR PASSWORD :)', 'Error');
            return redirect('login');
        }
    }

    public function logout() {
        $user = Auth::User();
        Session::put('user', $user);
        $user = Session::get('user');

        $name = $user->name;
        $email = $user->email;
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $activityLog = [
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        Toastr::success('Logout successfully :)', 'Success');
        return redirect('login');
    }

}
