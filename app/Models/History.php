<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Notification;

class History extends Model
{
    use HasFactory;
	
	protected $table = 'history';
	const UPDATED_AT = null;
	
	protected $fillable = [
		'user_id',
        'notification_id',
		'status',
		'created_at',
    ];
	
	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
	
	public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
