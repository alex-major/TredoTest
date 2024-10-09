<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FCMAPITest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_fcm_api(): void
    {
		$user = User::create([
			'name' => 'test',
			'email' => 'test@test.com',
			'password' => 'test',
		]);
		
		if($user) {
			$base64 = base64_encode('test:test');
			$response = $this->withHeaders([
				'Authorization' => $base64,
			])->get('/api/fcm/auth');

			$response->assertStatus(200);
			$response->assertJson([
				'status' => 'success',
			]);
		}
		
		$token = User::where(['name' => 'test'])->first()->auth_token;
		
		if($token) {
			$response = $this->withHeaders([
				'X-Auth' => $token,
			])->get('/api/fcm/set-token');

			$response->assertStatus(200);
			$response->assertJson([
				'status' => 'success',
			]);
		}
    }
}
