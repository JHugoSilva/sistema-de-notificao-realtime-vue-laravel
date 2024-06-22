<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordEmail;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], Response::HTTP_BAD_REQUEST);
        }

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Account Successfully Created.'
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], Response::HTTP_BAD_REQUEST);
        }


        if (!auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
               'message' => 'The credentials you entered are incorrect.'
            ], Response::HTTP_UNAUTHORIZED);
            // throw ValidationException::withMessages([
            //     'message' => 'The credentials you entered are incorrect.'
            // ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken('APP_NOTIFICATION', ['user'])->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'user' => $user->load('notifications'),
            'access_token' => $token
        ], Response::HTTP_OK);
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout Success'
        ], Response::HTTP_OK);
    }

    public function testMail(Request $request) {
        $data = [
            'name' => 'Joao da Silva',
            'body' => 'Esta mensagem e um teste'
        ];
        Mail::to('teste@email.com')->send(new TestMail('ola', $data));
    }

    public function forgetPasswordRequest(Request $request) {

        $request->validate([
            'name' => 'require|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'errors' => ['email' => ['Account with this email not found']]
            ]);
        }

        $code = rand(11111, 99999);

        $user->remember_token = $code;
        $user->save();

        $data = [
            'name' => $user->first_name.' '.$user->last_name,
            'code' => $code
        ];

        Mail::to($user->email)->send(new ForgotPasswordEmail('Forgot Password Request', $data));

        return response()->json([
            'message' => 'We have sended code to you email.'
        ], Response::HTTP_OK);
    }

    public function verifyAndChangePassword(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'code' => 'required|integer',
            'password' => 'required|confirmed'
        ]);

        $user = User::where('email', $request->email)
            ->where('remember_token', $request->code)->first();

        if (!$user) {
            return response()->json([
                'errors' => ['code' => ['invalid otp']]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->remember_token = null;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password successfull change.'
        ], Response::HTTP_OK);
    }

    public function changePassword(Request $request) {

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed'
        ]);

        $user = $request->user();

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully'
        ], Response::HTTP_OK);
    }

    public function updateProfile(Request $request) {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
             'email' => 'required|unique:users,email,'.$request->user()->id
        ]);

        $user = $request->user();

        // if ($user->email != $request->email) {
        //     $request->validate([
        //         'email' => 'required|unique:users,email'
        //     ]);
        //     $user->email = $request->email;
        // }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $user
        ], Response::HTTP_OK);
    }
}
