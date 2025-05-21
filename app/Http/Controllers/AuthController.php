<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //admin: nrtnhab 20082003
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Minimum password length is 6')
                ->withInput();
        }
        $username = $request->input('username');
        $password = $request->input('password');


        // User::create([
        //     'username' => 'nrtnhab',
        //     'email' => 'pkbinhchuannrtnhab@gmail.com',
        //     'password' => Hash::make('20082003'),
        // ]);

        $remember = $request->has('remember');
        $user = DB::table('users')->where('username', $username)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                session(['user_login' => $user->id]);
                session(['redirect' => 'admin.users.index']);
                $response = redirect()->route('admin.users.index')->with('success', 'Login successful!');
                if ($remember) {
                    $response->withCookie(cookie('user_login', $user->id, 60 * 24 * 7));
                } else {
                    $response->withCookie(cookie()->forget('user_login'));
                }
                return $response;
            } else {
                return redirect()->back()
                    ->with('error', 'Wrong password!')
                    ->withInput($request->only('username'));
            }
        }
        return redirect()->back()->with('error', 'User not found!');
    }
    public function forgotPassword()
    {
        return view('pages.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'This email is invalid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', $validator->errors()->first('email'))
                ->withInput();
        }

        $otp = rand(100000, 999999);

        // Lưu OTP vào DB
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'created_at' => now()]
        );

        // Gửi email (bạn phải cấu hình Mail trước)
        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Reset your password');
        });

        return redirect()->route('password.verifyForm', ['email' => $request->email])
            ->with('success', 'OTP sent to your email.');
    }

    public function showOtpForm(Request $request)
    {
        return view('pages.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with('error', 'Minimum password length is 6')
                ->withInput();
        }

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 15) {
            return back()->with('error', 'Invalid or expired OTP');
        }

        // Update password
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Xoá OTP
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset.');
    }
}
