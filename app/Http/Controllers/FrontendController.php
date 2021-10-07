<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\FrontendRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param  \App\Repositories\PageRepository $repository
     *
     */
    public function __construct(FrontendRepository $repository)
    {
        $this->repository = $repository;
    }
    public function viewSignIn()
    {
        return view('layout_index.signin');
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
                }            
            } else {
                return redirect()->back();
            }
        }
    }

    public function postLogout()
    {
        Auth::logout();
        return redirect()->route('signin');
    }
}
