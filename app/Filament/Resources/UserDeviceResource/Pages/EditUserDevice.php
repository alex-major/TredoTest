<?php

namespace App\Filament\Resources\UserDeviceResource\Pages;

use App\Filament\Resources\UserDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserDevice;

class EditUserDevice extends EditRecord
{
    protected static string $resource = UserDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
	
	protected function handleRecordUpdate(Model $record, array $data): Model
	{
		$device = UserDevice::where([
			'user_id' => $data['user_id'], 
			'fcm_token' => $data['fcm_token']
		])->first();
		
		if(!$device) {
			$record->update($data);
		}
	 
		return $record;
	}
}
