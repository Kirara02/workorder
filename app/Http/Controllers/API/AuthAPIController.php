<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthAPIController extends Controller
{
    public function login(Request $request){
        try {

           if(Auth::guard('employee')->attempt(['email' => $request->input('email'),'password' => $request->input('password')])){
            $user = Auth::guard('employee')->user();

            $token = $user->createToken('MyApp',['employee'])->plainTextToken;

            return response()->json(['message' => 'User logged in!', 'data' => $user, 'token' => $token]);
           }else{
               return response()->json(['error'=>'Invalid email or password.'],400);
           }

        } catch (\Throwable $th) {
            return ResponseFormatter::error('Something went wrong in '.$th->getMessage(),400);
        }
    }

    public function logout(Request $request)
    {
        try {

            $user = Employee::findOrFail($request->input('id'));

            $user->tokens()->delete();

            return response()->json(['message' => 'User logged out!'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }
}
