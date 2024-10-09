<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'title',
        'body',
		'send_at',
    ];
	
	public function history(): HasMany
    {
        return $this->HasMany(History::class);
    }
}
