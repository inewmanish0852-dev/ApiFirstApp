<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public function register(Request $request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return $this->success($user, 'User Registered Successfully');
    }

    public function login(Request $request)
    {   
        
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error('Invalid Credentials', 401);
        }
        $user = auth('api')->user();
        $user->token = $token;
        return $this->success($user);
    }

    public function logout()
    {
        auth('api')->logout();
        return $this->success([], 'Logout Successfully');
    }

    public function user()
    {   
        return $this->success(auth('api')->user());
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $user->update($request->all());
        if($request->hasFile('profile_image')){
            $user->profile_image = $request->file('profile_image')->store('profile_images');
        }
        $user->save();  
        return $this->success($user, 'Profile Updated Successfully');
    }

    public function changePassword(Request $request)
    {
        $user = auth('api')->user();
        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;
        $confirmPassword = $request->confirm_password;
        $user->password = Hash::make($newPassword);
        $user->save();
        return $this->success($user, 'Password Changed Successfully');
    }
}
