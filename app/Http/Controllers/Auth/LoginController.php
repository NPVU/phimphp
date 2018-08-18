<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Input;
class LoginController extends Controller
{
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');        
    }
    
    public function showLoginForm(){
        if(Input::get('backURL') != null){
            Session::put('backURL', url()->previous());
        }        
        return view('auth.login');
    }
    
    public function postLogin(Request $request){
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        if(!$this->checkActive($request)){
            return $this->sendLockResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            
            $user = Auth::user();
            $roles = DB::table('users_roles')->selectRaw('role_code')->where('user_id', $user->id)->get();
            if(count($roles) > 0){
                Session::put('roles', $roles);
            }
            
            return $this->sendLoginResponse($request);
        }
        
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
    function checkActive(Request $request){
        $active = DB::table('users')->where([
            ['email', $request->email],
            ['active', 1]
        ])->count();
        return $active>0?true:false;
    }
    
    function sendLockResponse(Request $request){
        $reason = DB::table('users')->where('email', $request->email)->get();
        if(count($reason) == 0){
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.noExist')],            
            ]);
        } else {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.locked').' ('.$reason[0]->reason.').'],            
            ]);
        }
        
    }
}
