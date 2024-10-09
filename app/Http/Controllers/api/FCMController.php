<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FCMController extends Controller
{
	public function auth(Request $request)
	{
		$auth = $request->header('Authorization');
		
		if($auth) {
			$data = explode($auth);
		} else {
			return response()->json([
				'status' => 'error',
				'data' => [
					'message' => 'needed authentication credentials'
				]
			]);
		}
		
		if(isset($data) && is_array($data) && $data[0] == 'basic') {
			$authData = explode(':', base64_decode($data[1]));
			
			$user = User::where([
				'name' => $authData[0],
				'password' => Hash::make($authData[1])
			])->first();
			
			if (auth()->attempt($credentials)) {
				$user = auth()->user();
				$user->token = base64_encode($user->id.$user->name.date('Y-m-d H:i:s'));
				$user->save();
				
				return response()->json([
					'status' => 'success',
					'data' => [
						'token' => $user->token
					]
				]);
			}
		} else {
			return response()->json([
				'status' => 'error',
				'data' => [
					'message' => 'invalid authentication credentials'
				]
			]);
		}
	}
	
    public function setToken(Request $request) {
		$auth = $request->header('X-Auth');
		
		if($auth) {
			$data = explode($auth);
		} else {
			return response()->json([
				'status' => 'error',
				'data' => [
					'message' => 'needed authorization'
				]
			]);
		}
		
		if(isset($data) && is_array($data) && $data[0] == 'basic') {
			$token = $data[1];
			
			$user = User::where('token', '=', $token)->first();
		
			$fcm_token = FireBase::auth()->createCustomToken(Str::uuid());
			UserDevice::create([
				'user_id' => $user->id,
				'fcm_token' => $fcm_token,
			]);
			
			return response()->json([
				'status' => 'success',
				'data' => [
					'token' => $fcm_token
				]
			]);
		} else {
			return response()->json([
				'status' => 'error',
				'data' => [
					'message' => 'invalid authorization token'
				]
			]);
		}
	}
}
