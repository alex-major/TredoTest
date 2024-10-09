<?php

namespace App\Filament\Resources\UserDeviceResource\Pages;

use App\Filament\Resources\UserDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUserDevice extends CreateRecord
{
    protected static string $resource = UserDeviceResource::class;
	
	protected function handleRecordCreation(array $data): Model
	{
		$device = static::getModel()::where([
			'user_id' => $data['user_id'], 
			'fcm_token' => $data['fcm_token']
		])->first();
		
		if(!$device) {
			return static::getModel()::create($data);
		}
		
		return null;
	}
}
