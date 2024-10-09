<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Notification;
use App\Filament\Resources\NotificationResource;
use App\Filament\Resources\NotificationResource\Pages\ListNotifications;
use App\Filament\Resources\NotificationResource\Pages\CreateNotification;
use App\Filament\Resources\NotificationResource\Pages\EditNotification;

class NotificationResourceTest extends TestCase
{
    use RefreshDatabase;
	
    protected function setUp(): void
	{
		parent::setUp();

		$this->actingAs(User::factory()->create());
	}
	
	public function test_it_can_list_notifications()
	{
		$notifications = Notification::factory()->count(10)->create();

		Livewire::test(ListNotifications::class)
			->assertSee($notifications->pluck('title')->toArray());
	}
	
	public function test_it_can_create_notification()
	{
		$newNotification = Notification::factory()->make();

		Livewire::test(CreateNotification::class)
			->set('data.user_id', $newNotification->user->id)
			->set('data.title', $newNotification->title)
			->set('data.body', $newNotification->body)
			->set('data.send_at', $newNotification->send_at)
			->call('create')
			->assertHasNoErrors();

		$this->assertDatabaseCount('notifications', 1);
		$this->assertDatabaseHas('notifications', [
			'title' => $newNotification->title,
			'body' => $newNotification->body,
			'send_at' => $newNotification->send_at,
		]);
	}
	
	public function test_title_is_required_for_creating_notification()
	{
		$newNotification = Notification::factory()->make();

		Livewire::test(CreateNotification::class)
			->set('data.user_id', $newNotification->user->id)
			->set('data.title', NULL)
			->set('data.body', $newNotification->body)
			->set('data.send_at', $newNotification->send_at)
			->call('create')
			->assertHasFormErrors(['title' => 'required']);
	}
	
	public function test_it_can_render_edit_page()
	{
		$notification = Notification::factory()->create();

		Livewire::test(EditNotification::class, [
			'record' => $notification->getRouteKey(),
		])->assertSuccessful();
	}
	
	public function test_it_can_retrieve_data()
	{
		$notification = Notification::factory()->create();

		Livewire::test(EditNotification::class, [
			'record' => $notification->getRouteKey(),
		])
			->set('data.user_id', $notification->user->id)
			->set('data.title', $notification->title)
			->set('data.body', $notification->body)
			->set('data.send_at', $notification->send_at)
			->assertHasNoFormErrors();
	}
	
	public function test_it_can_update_notification_data()
	{
		$notification = Notification::factory()->create();
		$newData = Notification::factory()->make();

		Livewire::test(EditNotification::class, [
			'record' => $notification->getRouteKey(),
		])
			->set('data.user_id', $newData->user->id)
			->set('data.title', $newData->title)
			->set('data.body', $newData->body)
			->set('data.send_at', $newData->send_at)
			->call('save')
			->assertHasNoFormErrors();

		$this->assertDatabaseHas('notifications', [
			'user_id', $newNotification->user->id,
			'title' => $newData->title,
			'body' => $newData->body,
			'send_at' => $newData->send_at,
		]);
	}
}
