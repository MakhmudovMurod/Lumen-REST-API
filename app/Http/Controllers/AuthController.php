<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Entrance_log;
use Carbon\Carbon;
use App\User_profile;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'username' => 'required|string|unique:users',
            'password' => 'required|confirmed',
            
        ]);

        try 
        {
            $user = new User;
            $user->username= $request->input('username');
            $user->password = app('hash')->make($request->input('password'));
            $user->user_ip = $request->ip();
            $user->register_date =Carbon::now();
            $user->isAdmin = true;
            $user->save();

            return response()->json( [
                        'entity' => 'users', 
                        'action' => 'create', 
                        'result' => 'success'
            ], 201);

        } 
        catch (\Exception $e) 
        {
            return response()->json( [
                       'entity' => 'users', 
                       'action' => 'create', 
                       'result' => 'failed'
            ], 409);
        }
    }

    
    
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */	 
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) 
        {			
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        if($token = Auth::attempt($credentials))
        {

            $new_log = new Entrance_log;

            $new_log->log_ip = $request->ip();
            $new_log->user_agent = $request->server('HTTP_USER_AGENT');
            $new_log->log_date = Carbon::now();

            $new_log->save();

        } 
        
        return $this->respondWithToken($token);

    }

    
     /**
     * Get user details.
     *
     * @param  Request  $request
     * @return Response
     */	 	
    public function me()
    {
        return response()->json(auth()->user());
    }


    /**
     * Store a new profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create_profile(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number'=>'required',
            'date_of_birth'=>'required'
            
        ]);

        try 
        {
            $profile = new User_profile();
            
            $profile->user_id = $request->input('user_id');
            $profile->first_name = $request->input('first_name');
            $profile->last_name = $request->input('last_name');
            $profile->phone_number = $request->input('phone_number');
            $profile->date_of_birth = $request->input('date_of_birth');

            $profile->save();

            return response()->json( [
                        'entity' => 'profile', 
                        'action' => 'create', 
                        'result' => 'success'
            ], 201);

        } 
        catch (\Exception $e) 
        {
            return response()->json( [
                       'entity' => 'profile', 
                       'action' => 'create', 
                       'result' => 'failed'
            ], 409);
        }
    } 

    

 
    /**
     * Create a new account .
     *
     * @param  Request  $request
     * @return Response
     */
    public function create_account(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'account_number' => 'required',
            'currency' => 'required|string'
        ]);

        try 
        {
            $account = new Accounts;
             
             
            $account->account_number = $request->input('account_number');
            $account->currency = $request->input('currency');
             
            $account->save();

            return response()->json( [
                        'entity' => 'account', 
                        'action' => 'create', 
                        'result' => 'success'
            ], 201);

        } 
        catch (\Exception $e) 
        {
            return response()->json( [
                       'entity' => 'account', 
                       'action' => 'create', 
                       'result' => 'failed'
            ], 409);
        }
    } 
 

}
	