<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Library\Services\ResponseService;
use App\Mail\Welcome;
use Validator;
use Config;
use Exception;
use Illuminate\Support\Str;
use Mail;
use Laravel\Socialite\Facades\Socialite;
use DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => [
            'login', 
            'socialLogin',
            'register', 
            'redirectToGoogleLogin', 
            'handleGoogleLoginCallback', 
            'redirectToGoogleRegisterEmployer',
            'redirectToGoogleRegisterStaff',
            'handleGoogleRegisterEmployerCallback',
            'handleGoogleRegisterStaffCallback',
            'redirectToFacebook', 
            'handleFacebookCallback'
        ]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $data       =   json_decode(base64_decode($request['formData']), true);

    	$validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:16',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Either email or password is incorrect'], 401);
        }
        //auditing login
        $user   =   User::where('email', $data['email'])->first();
        $update =   User::find($user->id);
        $update->latest_login_at  =   date('Y-m-d H:i:s');
        $update->save();

        return $this->createNewToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function socialLogin(Request $request){
        if ($request->input('formData')) {
            auth('api')->setToken($request->input('formData'));
            $user   =   auth('api')->authenticate();
            if ($user) {
                return   $this->createNewToken($request->input('formData'));
            }
        }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, ResponseService $response) {
        $result = DB::transaction(function() use ($request, $response) {

            $data       =   json_decode(base64_decode($request['formData']), true);
            
            $validator  =   Validator::make($data, [
                'first_name'    =>  'required|max:255',
                'last_name'     =>  'required|max:255',
                'email'         =>  'required|unique:users',
                'password'      =>  'required',
                'password_confirmation' =>  'required'
            ]);

            if ($validator->fails()) {
                foreach ($validator->messages()->get('*') as $v => $message) {
                    return $response->response(null, $message, 'failed');
                }
            }

            $user = User::create([
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'], 
                'name'              => $data['first_name'].' '.$data['last_name'],
                'role_id'           => $data['role_id'],
                'email'             => $data['email'],
                'password'          => bcrypt($data['password']),
                'remember_token'    => Str::random(60),
            ]);

            $credentials    =   array(
                                    'email'         => $data['email'],
                                    'password'      => $data['password']
                                );

            if (!$token = $this->guard()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            Mail::to($user->email)->send(new Welcome($user));
            
            return $token;
        });
        return $this->createNewToken($result);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        $this->guard()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken($this->guard()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return response()->json($this->guard()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'token'         => $token,
            'loggedIn'      => true,
            'token_type'    => 'bearer',
            'expires_in'    => $this->guard()->factory()->getTTL() * 60,
            'user'          => $this->guard()->user()
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogleLogin()
    {
        config(['services.google.redirect' => config('url.google_login')]);
        return Socialite::driver('google')->stateless()->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleLoginCallback()
    {
        config(['services.google.redirect' => config('url.google_login')]);
        $user       =   Socialite::driver('google')->stateless()->user();
        $find_user   =   User::where('google_id', $user->id)->first();
        if($find_user){
            return redirect()->away(config('url.front_url').'/auth/social-callback/success?token='.auth('api')->fromUser($find_user));
        }else{
            return redirect()->away(config('url.front_url').'/auth/social-callback/failed?reason=not_exists');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogleRegisterEmployer()
    {
        config(['services.google.redirect' => config('url.google_register_employer')]);
        return Socialite::driver('google')->stateless()->redirect();
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogleRegisterStaff()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleRegisterEmployerCallback()
    {
        config(['services.google.redirect' => config('url.google_register_employer')]);
        $user           =   Socialite::driver('google')->stateless()->user();
        $find_user      =   User::where('google_id', $user->id)->first();
        if($find_user){
            return redirect()->away(config('url.front_url').'/auth/social-callback/failed?reason=exists');
        }else{
            try {
                $new_user = User::create([
                    'first_name'        => $user->user['given_name'],
                    'last_name'         => $user->user['family_name'], 
                    'name'              => $user->name,
                    'role_id'           => 1,
                    'email'             => $user->email,
                    'password'          => bcrypt('123456'),
                    'remember_token'    => Str::random(60),
                    'google_id'         => $user->id,
                ]);
                
                Mail::to($new_user->email)->send(new Welcome($new_user));

                return redirect()->away(config('url.front_url').'/auth/social-callback/success?token='.auth('api')->fromUser($new_user));
            } catch (Exception $e) {
                $update         =   User::where('email', $user->email)->update(['google_id' => $user->id]);  
                $find_user      =   User::where('google_id', $user->id)->first();

                Mail::to($find_user->email)->send(new Welcome($find_user));

                return redirect()->away(config('url.front_url').'/auth/social-callback/success?token='.auth('api')->fromUser($find_user));
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleRegisterStaffCallback()
    {
        $user       =   Socialite::driver('google')->stateless()->user();
        $find_user   =   User::where('google_id', $user->id)->first();
        if($find_user){
            return redirect()->away(config('url.front_url').'/auth/social-callback/failed?reason=exists');
        }else{
            try {
                $new_user = User::create([
                    'first_name'        => $user->user['given_name'],
                    'last_name'         => $user->user['family_name'], 
                    'name'              => $user->name,
                    'role_id'           => 0,
                    'email'             => $user->email,
                    'password'          => bcrypt('123456'),
                    'remember_token'    => Str::random(60),
                    'google_id'         => $user->id,
                ]);

                Mail::to($new_user->email)->send(new Welcome($new_user));
                
                return redirect()->away(config('url.front_url').'/auth/social-callback/success?token='.auth('api')->fromUser($new_user));
            } catch (Exception $e) {
                $update         =   User::where('email', $user->email)->update(['google_id' => $user->id]);  
                $find_user      =   User::where('google_id', $user->id)->first();

                Mail::to($find_user->email)->send(new Welcome($find_user));

                return redirect()->away(config('url.front_url').'/auth/social-callback/success?token='.auth('api')->fromUser($find_user));
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
      
        $user       = Socialite::driver('facebook')->stateless()->user();
        $find_user   = User::where('facebook_id', $user->id)->first();

        if($find_user){
   
            return redirect()->away(config('url.front_url').'/auth/social-callback?token='.auth('api')->fromUser($find_user));
   
        }else{

            try {
                $newUser = User::create([
                    'email'             => $user->email,
                    'password'          => bcrypt('123456'),
                    'facebook_id'       => $user->id,
                ]);
                return redirect()->away(config('url.front_url').'/auth/social-callback?token='.auth('api')->fromUser($newUser));
            } catch (Exception $e) {
                $updateUser     =   User::where('email', $user->email)->update(['facebook_id' => $user->id]);  
                $find_user       =   User::where('facebook_id', $user->id)->first();

                return redirect()->away(config('url.front_url').'/auth/social-callback?token='.auth('api')->fromUser($find_user));
            }
        }
    }

}