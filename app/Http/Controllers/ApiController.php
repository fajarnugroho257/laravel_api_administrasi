<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function index($pageNumber)
    {
        // get all data
        $data = User::paginate(5, ['*'], 'page', $pageNumber);
        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function show($user_id)
    {
        //
        $data = User::where('id', $user_id)->first();
        // respon
        if (empty($data)) {
            return response()->json(['error' => 'Data tidak ditemukan'], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data pengurus tersedia',
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function Update(Request $request, User $user)
    {
        //Validate data
        $data = $request->only('username', 'name', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'username' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // dd($request);
        //update post
        $params = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
                'status' => $request->status,
                ];
        if (!empty($request->password)) {
            $params = [
                'password' => bcrypt($request->password)
            ];
        }
        $profesi = User::where('id', $request->user_id)
                    ->update($params);

        //created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Data pengurus updated successfully',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
     //Validate data
        $data = $request->only('name', 'username', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Request is valid, create new user
        $user = User::create([
         'name' => $request->name,
         'username' => $request->username,
         'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required|string|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                 'success' => false,
                 'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
     return $credentials;
            return response()->json([
                 'success' => false,
                 'message' => 'Could not create token.',
                ], 500);
        }
  
   //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => User::where('username', $request->username)->first()
        ]);
    }
 
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

  //Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }

    public function get_user_deta($token)
    { 
        $user = JWTAuth::authenticate($token);
 
        return response()->json(['user' => $user]);
    }
}