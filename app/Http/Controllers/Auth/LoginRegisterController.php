<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $client = new Client();
        $guzzleResponse = $client->get(
                'https://randomuser.me/api/', [
                'headers' => [
                    'APP_KEY'=>'QAWLhIK2p5'
                ],
            ]);
         $response = json_decode($guzzleResponse->getBody(),true);
         $username  = $response['results'][0]['login']['username'];
        return view('auth.register')->with(['username' => $username]);
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'username' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        //dd('done');
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('backend.auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
       // dd($request->all());
        $credentials = $request->validate([
            'password' => 'required'
        ]);

        if(Auth::attempt(['username' => $request->email, 'password' => $request->password], $request->remember) )
        {
            //dd('yes');
            $request->session()->regenerate();
                   return view('backend.pages.dashboard.index');

        }else{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember) )
                {
                    //dd('yes');
                    $request->session()->regenerate();
                           return view('backend.pages.dashboard.index');

                }
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    } 
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::check())
        {
               $client = new Client();
        $guzzleResponse = $client->get(
                'https://http.cat/401', [
                'headers' => [
                    'APP_KEY'=>'QAWLhIK2p5'
                ],
            ]);
        // dd($guzzleResponse->getBody());
         $response = json_decode($guzzleResponse->getBody(),true);
          
            return view('backend.pages.dashboard.index');
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }    

}