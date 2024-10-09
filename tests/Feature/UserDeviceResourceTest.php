<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\UserDevice;
use App\Filament\Resources\UserDeviceResource;
use App\Filament\Resources\UserDeviceResource\Pages\ListUserDevices;
use App\Filament\Resources\UserDeviceResource\Pages\CreateUserDevice;
use App\Filament\Resources\UserDeviceResource\Pages\EditUserDevice;

class UserDeviceResourceTest extends TestCase
{
    use RefreshDatabase;
	
    protected function setUp(): void
	{
		parent::setUp();

		$this->actingAs(User::factory()->create());
	}
	
	public function test_it_can_list_user_devices()
	{
		$user_devices = UserDevice::factory()->count(10)->create();

		Livewire::test(ListUserDevices::class)
			->assertSee($user_devices->pluck('fcm_token')->toArray());
	}
	
	public function test_it_can_create_user_device()
	{
		$newUserDevice = UserDevice::factory()->make();

		Livewire::test(CreateUserDevice::class)
			->set('data.user_id', $newUserDevice->user->id)
			->set('data.fcm_token', $newUserDevice->fcm_token)
			->call('create')
			->assertHasNoErrors();

		$this->assertDatabaseCount('user_devices', 1);
		$this->assertDatabaseHas('user_devices', [
			'user_id' => $newUserDevice->user->id,
			'fcm_token' => $newUserDevice->fcm_token,
		]);
	}
	
	public function test_fcm_token_is_required_for_creating_user_device()
	{
		$newUserDevice = UserDevice::factory()->make();

		Livewire::test(CreateUserDevice::class)
			->set('data.user_id', $newUserDevice->user->id)
			->set('data.fcm_token', NULL)
			->call('create')
			->assertHasFormErrors(['fcm_token' => 'required']);
	}
	
	public function test_it_can_render_edit_page()
	{
		$userDevice = UserDevice::factory()->create();

		Livewire::test(EditUserDevice::class, [
			'record' => $userDevice->getRouteKey(),
		])->assertSuccessful();
	}
	
	public function test_it_can_retrieve_data()
	{
		$userDevice = UserDevice::factory()->create();

		Livewire::test(EditUserDevice::class, [
			'record' => $userDevice->getRouteKey(),
		])
			->set('data.user_id', $userDevice->user->id)
			->set('data.fcm_token', $userDevice->fcm_token)
			->assertHasNoFormErrors();
	}
	
	public function test_it_can_update_user_device_data()
	{
		$userDevice = UserDevice::factory()->create();
		$newData = UserDevice::factory()->make();

		Livewire::test(EditUserDevice::class, [
			'record' => $userDevice->getRouteKey(),
		])
			->set('data.user_id', $newData->user->id)
			->set('data.fcm_token', $newData->fcm_token)
			->call('save')
			->assertHasNoFormErrors();

		$this->assertDatabaseHas('user_devices', [
			'user_id' => $newData->user_id,
			'fcm_token' => $newData->fcm_token,
		]);
	}
}
