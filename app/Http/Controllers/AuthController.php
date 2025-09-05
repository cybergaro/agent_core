<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Services\BrevoMailer;

use App\Models\User;
use App\Models\EmailVerifyToken;

class AuthController extends Controller
{
    public function showLogin()
    {
        $header = false;
        $title = "Login";

        return view('auth.login', compact('header', 'title'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['error' => 'Username o password errati']);
        }

        if(!$user->email_verified_at){

            $token = new EmailVerifyToken();
            
            $html = view('emails.auth.verifyEmail', ['token' => $token->createToken($user->id)])->render();

            $mailer = new BrevoMailer();

            $mailer->sendCustomEmail(
                $user->email,
                $user->name . ' ' . $user->surname,
                'Verifica la tua email',
                $html
            );

            $header = false;

            return view("auth.verifyEmail", compact("header"));
            
        }
    
        $remember = $request->has('remember');

        Auth::login($user, $remember);
        
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function createAdmin(){
        $user = new User();
        $user->name = 'Francesco';
        $user->surname = 'Garofolo';
        $user->email = 'francyclimber@gmail.com';
        $user->phone = '3791508192';
        $user->password = Hash::make('cybergaro');
        $user->role = 'admin';
        $user->save();
    }

    public function showUserSettings()
    {
        $user = Auth::user();
        return view('dash.account.show', compact('user'));
    }

    public function saveUserSettings(Request $request){
        $request->validate([
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'phone' => 'string|max:255'
        ]);

        $user = Auth::user();
        $user->name = $request->input("name");
        $user->surname = $request->input("surname");
        $user->phone = $request->input("phone");
        $user->promotional_emails = $request->has("promotional_emails");

        if($user->role == "admin"){
            $user->admin_order_notify = $request->has("admin_order_notify");
        }

        $user->save();

        return redirect()->back()->with('success', 'Impostazioni salvate con successo');
    }

    public function changePassword(Request $request){
        $user = Auth::user();

        // $request->validate([
        //     'old_password' => 'required',
        //     'password' => 'required|min:6|confirmed',
        // ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = $request->input("password");
            $user->save();
            
            return redirect()->back()->with('success', 'Password cambiata con successo');
        } else {
            return redirect()->back()->withErrors(['error' => 'Password corrente errata']);
        }
    }

    public function showRegistration(Request $request)
    {   
        $header = false;

        return view('auth.registration', compact('header'));
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'phone' => 'string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $existingUser = User::where('email', $request->input("email"))->first();
        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['error' => 'Email già in uso']);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
        $user->save();

        // Log::info('User created', 'AuthController:registration',[], $user->id);
    
        $token = new EmailVerifyToken();
            
        $html = view('emails.auth.verifyEmail', ['token' => $token->createToken($user->id)])->render();

        $mailer = new BrevoMailer();

        $mailer->sendCustomEmail(
            $user->email,
            $user->name . ' ' . $user->surname,
            'Verifica la tua email',
            $html
        );

        $header = false;

        return view("auth.verifyEmail", compact("header"));
    }

    public function emailCheck($token)
    {
        $token = EmailVerifyToken::where("token", $token)->first();

        if(!$token){
            return "token not found";
        }

        $user = User::find($token->id_user);

        if($user->email_verified){
            return redirect()->route("login");
        }

        $user->email_verified_at = date("Y-m-d");
        $user->save();

        Auth::login($user, true);

        return redirect()->route("dashboard");
    }
}
