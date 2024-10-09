<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\History;
use App\Filament\Resources\HistoryResource;
use App\Filament\Resources\HistoryResource\Pages\ListHistories;
use App\Filament\Resources\HistoryResource\Pages\CreateHistory;
use App\Filament\Resources\HistoryResource\Pages\EditHistory;

class HistoryResourceTest extends TestCase
{
    use RefreshDatabase;
	
    protected function setUp(): void
	{
		parent::setUp();

		$this->actingAs(User::factory()->create());
	}
	
	public function test_it_can_list_histories()
	{
		$histories = History::factory()->count(10)->create();

		Livewire::test(ListHistories::class)
			->assertSee($histories->pluck('status')->toArray());
	}
}
