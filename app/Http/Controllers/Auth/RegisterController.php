<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


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

    protected $redirectTo = '/logout';

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
            'mobile' => [
                'required',
                'numeric',
                'digits:11',
                'unique:users,mobile'
                ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function SendREST($username,$password, $Source, $Destination, $MsgBody, $Encoding)
    {

        $URL = "http://panel.asanak.ir/webservice/v1rest/sendsms";
        $msg = urlencode(trim($MsgBody));
        $url = $URL.'?username='.$username.'&password='.$password.'&source='.$Source.'&destination='.$Destination.'&message='. $msg;
        $headers[] = 'Accept: text/html';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        try
        {
            if(($return = curl_exec($process)))
            {
                return $return;
            }
        } catch (Exception $ex)
        {
            return $ex->errorMessage();
        }
    }

    protected function create(array $data)
    {
        $pass = rand(100000,999999);
        $user = User::create([
            'mobile' => $data['mobile'],
            'user_type' => '1',
            'password' => Hash::make($pass),
        ]);

        $message= "با سلام رمز ورود شما به سامانه سفارش آنلاین:  ".$pass;

        $mobile = $data['mobile'];

        $encoding = (mb_detect_encoding($message) == 'ASCII') ? "1" : "8";

        $this->SendREST('mahdikazemi1364','Mahan@1395', '982133119674', $mobile, $message, $encoding);

        return $user;
    }

    public function showMobileForm()
    {
        return view('auth.mobile');
    }
    public function resetMobile(Request $request, User $user)
    {
        $pass = rand(100000,999999);

        $this->validate($request, [
            'mobile' => [
                'required',
                'numeric',
                'digits:11',
            ],

        ]);

        $inputs = $request->all();

        $result = User::where('mobile', $inputs['mobile'])->update([
            'password' => Hash::make($pass)
        ]);

        if($result)
        {
            $message= "با سلام رمز ورود شما به سامانه سفارش آنلاین:  ".$pass;

            $mobile = $inputs['mobile'];

            $encoding = (mb_detect_encoding($message) == 'ASCII') ? "1" : "8";

            $this->SendREST('mahdikazemi1364','Mahan@1395', '982133119674', $mobile, $message, $encoding);

            return redirect('/login');

        }
        else{
            $this->validate(
                $request,
                ['existMobile' => 'required'],
                ['existMobile.required' => 'شماره همراه وارد شده وجود ندارد!']
            );
        }

    }
}
