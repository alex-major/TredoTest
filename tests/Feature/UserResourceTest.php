<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;

class UserResourceTest extends TestCase
{
	use RefreshDatabase;
	
    protected function setUp(): void
	{
		parent::setUp();

		$this->actingAs(User::factory()->create());
	}
	
	public function test_it_can_list_users()
	{
		$users = User::factory()->count(9)->create();

		Livewire::test(ListUsers::class)
			->assertSee($users->pluck('name')->toArray());
	}
	
	public function test_it_can_create_user()
	{
		$newUser = User::factory()->make();

		Livewire::test(CreateUser::class)
			->set('data.name', $newUser->name)
			->set('data.email', $newUser->email)
			->set('data.password', $newUser->password)
			->call('create')
			->assertHasNoErrors();

		$this->assertDatabaseCount('users', 2);
		$this->assertDatabaseHas('users', [
			'name' => $newUser->name,
			'email' => $newUser->email,
			'password' => $newUser->password,
		]);
	}
	
	public function test_email_is_required_for_creating_user()
	{
		$newUser = User::factory()->make();

		Livewire::test(CreateUser::class)
			->set('data.email', NULL)
			->set('data.name', $newUser->name)
			->set('data.password', $newUser->password)
			->call('create')
			->assertHasFormErrors(['email' => 'required']);
	}
	
	public function test_it_can_render_edit_page()
	{
		$user = User::factory()->create();

		Livewire::test(EditUser::class, [
			'record' => $user->getRouteKey(),
		])->assertSuccessful();
	}
	
	public function test_it_can_retrieve_data()
	{
		$user = User::factory()->create();

		Livewire::test(EditUser::class, [
			'record' => $user->getRouteKey(),
		])
			->set('data.name', $user->name)
			->set('data.email', $user->email)
			->set('data.password', $user->password)
			->assertHasNoFormErrors();
	}
	
	public function test_it_can_update_user_data()
	{
		$user = User::factory()->create();
		$newData = User::factory()->make();

		Livewire::test(EditUser::class, [
			'record' => $user->getRouteKey(),
		])
			->set('data.name', $newData->name)
			->set('data.email', $newData->email)
			->set('data.password', $newData->password)
			->call('save')
			->assertHasNoFormErrors();

		$this->assertDatabaseHas('users', [
			'name' => $newData->name,
			'email' => $newData->email,
			'password' => $newData->password,
		]);
	}
}
