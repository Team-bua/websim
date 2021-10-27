<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\AutoBank;
use App\Models\User;
use App\Repositories\FrontendRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class FrontendController extends Controller
{
    /**
     * The ProductRepository instance.
     *
     * @var \App\Repositories\front\FrontendRepository
     *
     */
    protected $repository;



    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\FrontendRepository $repository
     *
     */
    public function __construct(FrontendRepository $repository)
    {
        $this->repository = $repository;
    }
    public function viewSignIn()
    {
        if(Auth::check()){
            if(Auth::user()->role == 1){
                return redirect()->route('admin');
            }else{
                return redirect()->route('user.service');
            }
        }else{
            return view('layout_index.signin');
        }
    }

    public function postSignIn(LoginRequest $request)
    {
        $remember = false;
        if(isset($request->rememberMe)){
            $remember = true;
        }
        $credentaials = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($credentaials, $remember)) {
            if (Auth::user()->banned_status == 0) {
                return redirect()->route('admin')->with('message', '1');
            } else {
                Auth::logout();
                return redirect()->back()->with('message', '4');
            }
        } else {
            return redirect()->back()->with('message', '3');
        }
    }

    public function viewSignUp()
    {
        return view('layout_index.signup');
    }

    public function postSignup(RegisterRequest $request)
    {
        $sign_up = $this->repository->createUser($request);
        if ($sign_up == true) {
            $credentaials = array('email' => $request->email, 'password' => $request->password);
            if (Auth::attempt($credentaials)) {
                if(Auth::user()->role == 1){
                    return redirect()->route('admin')->with('message', '1');
                }else{
                    return redirect()->route('signin')->with('message', '1');
                }
            } else {
                return redirect()->back();
            }
        }
    }

    public function postLogout()
    {
        Auth::logout();
        $rememberMeCookie = Auth::getRecallerName();

        $cookie = Cookie::forget($rememberMeCookie);

        return Redirect::to('/')->withCookie($cookie);
    }

    public function transtionInfo(Request $request)
    {
        $res_json = $request->data[0];
        $data = new AutoBank();
        $data->data = json_encode($res_json);
        $data->save();
        $this->repository->autoBank($data->data, $data->id);
    }

    // public function test()
    // {
    //     $res_json = json_decode('{"id":536760,"tid":"5078 - 93023","description":"MBVCB.1457193831.CODE329014.CT tu 0291000285902 VU HUYEN TUAN toi0071000962707 NGUYEN MINH TRI","amount":1000,"cusum_balance":0,"when":"2021-10-27 21:20:12","bank_sub_acc_id":"0071000962707","subAccId":"0071000962707"}');
    //     $arr_description = explode('.', $res_json->description);
    //     $users = User::all();
    //     foreach($users as $user){
    //         $key = array_search($user->code_name, $arr_description);
    //         if($key != false){
    //             $code_name = $arr_description[$key];
    //             $amount = $res_json->amount;
    //             break;
    //         }else{
    //             $momo = explode('-',$arr_description[3]);
    //             $key_momo = array_search($user->code_name, $momo);
    //             if($key_momo != false){
    //                 $code_name = $momo[$key_momo];
    //                 $amount = $res_json->amount;
    //                 break;
    //             }else{
    //                 $code_name = '123';
    //                 $amount = 0;
    //             }
    //         }
    //     }
    //     dd($res_json);
       
    //     return view('test');
    // }
}
