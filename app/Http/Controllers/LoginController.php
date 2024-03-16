<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Session;
use Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class LoginController extends Controller
{
    public function userDashboard()
    {
        $users = User::all();
        $success =  $users;
        $user = Auth::user();

        if($user->hasVerifiedEmail()){
            return response()->json($success, 200);
        }else {
            return response()->json(['error' => ['Go verify email']], 200);
        }
        
    }

    public function adminDashboard()
    {
        $users = Admin::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'user']);
            
            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function socialLogin(Request $request)
    {
        $user = Socialite::driver($request->provider)->userFromToken($request->accessToken);

        if(!$user->email){
            return response()->json(['error' => ['Something is Wrong.']], 200);
        }
        //$user = $request->accessToken;
        if($finduser = User::where('email',$user->email)->first()){
            $success = $finduser;
            $success['token'] = $finduser->createToken('MyApp',['user'])->accessToken; 
        }else{
            //$input = $user->all();
            //return response()->json($user->user['given_name'], 200);
            //return response()->json($user);
            if($request->provider == "google"){
                $input['name'] = $user->user['given_name'] ." ".$user->user['family_name'];
            }else{
                $input['name'] = $user->user['name'];
            }
            //$input['lastname'] = "not set";
            $input['email'] = $user->email;
            $input['company'] = " ";
            $input['job'] = 0;
            $input['password'] = 'JustPassForSocialLogin123';
            $input['password'] = bcrypt($input['password']);
            $input['type'] = 1;
            $createdUser = User::create($input);
            //event(new Registered($createdUser));
            $success = $createdUser;
            if ($createdUser->markEmailAsVerified())
            event(new Verified($createdUser));
            $success['token'] =  $createdUser->createToken('MyApp',['user'])->accessToken;
            
            //
        }
        
        return response()->json($success, 200);
        
    }
    public function adminLoginNext (Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin/dashboard/index')
                        ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'admin']);
            
            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
        //return response()->json(['error' => ['Email and Password are Wrong.']], 200);
    }
   
    public function userRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
   
        if($validator->fails()){
            //return $this->sendError('Validation Error.', $validator->errors());       
            return response()->json(['error' => $validator->errors()->all()], 200);
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 1;
        $user = User::create($input);
        event(new Registered($user)); // not working
        $success = $user;
        $success['token'] =  $user->createToken('MyApp',['user'])->accessToken;
        $user->sendEmailVerificationNotification();  // not working
   
        return response()->json($success, 200);
        // return response()->json(['error' => ['Email and Password are Wrong.']], 200);
    }

    public function userRegisterStep2 (Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'company' => 'required',
            'job' => 'required'
        ]);
        if($validator->fails()){
            //return $this->sendError('Validation Error.', $validator->errors());       
            return response()->json(['error' => $validator->errors()->all()], 200);
        }
        $user = User::find($request->user()->id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->company = $request->company;
        $user->job = $request->job;

        $user->save();

        return response()->json($user);


    }

    public function emailVerify (Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            ]);
            $data = $request->all();
            $createUser = $this->create($data);
            $token = Str::random(64);
            UserVerify::create([
            'user_id' => $createUser->id, 
            'token' => $token
            ]);
            Mail::send('email.emailVerificationEmail', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
            });
            return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
            
    }
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->markEmailAsVerified())
            event(new Verified($user));

            return Redirect::to('https://automatr.io/login');
    }

    public function resendEmailVerify(){
        $user = Auth::user();
        return response()->json(['error' => [$user]]);
    }
    public function verificationNotice () {
        return response()->json(['error' => ['Verify your email.']], 200);

    }

    public function updateUser (Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'company' => 'required',
            'job' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8',
        ]);
   
        if($validator->fails()){
            //return $this->sendError('Validation Error.', $validator->errors());       
            return response()->json(['error' => $validator->errors()->all()], 200);
        }

        $user = User::find($request->user()->id);

        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->company = $request->company;
        $user->job = $request->job;
        $user->phone = $request->phone;
        $user->emailContact = $request->emailContact;

        $user->save();

        return response()->json($user, 200);

    }

    public function forgotPassword (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = User::where('email','=',$request->email)->first();
        //$user->broker()->sendResetLink();
        Password::broker()->sendResetLink(['email' => $user->email]);
        return response()->json($user, 200);

    }

    public function passwordReset (Request $request) {
        //return response()->json('ok', 200);
        /*$this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);*/
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
            return response()->json($user, 200);
            //$user2 = $user;
            //return response()->json('ok'.$user->id.'&email='.$password, 200);
        });
        return response()->json(['error' => [$response]],200);
        //return redirect('http://localhost:5000/new-password?token='.$request->token.'&email='.$request->email);
        //return Redirect::to('http://localhost:5000/login');

    }

    public function resetPassword ($user, $password){
        $user->password = bcrypt($password);

        $user->save();
        return response()->json($user, 200);

    }
    /*public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Admin::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return response()->json($success, 200);
        //return response()->json(['error' => ['Email and Password are Wrong.']], 200);
    }*/
    public function adminLogOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function userLogout (Request $request){
        $request->user()->token()->revoke();

        return response()->json('success',200);
    }
}