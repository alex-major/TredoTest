<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'user_id',
        'fcm_token',
    ];
	
	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
