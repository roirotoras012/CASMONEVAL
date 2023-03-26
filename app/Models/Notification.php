<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = ['user_type_ID', 'user_ID', 'division_ID', 'opcr_ID', 'province_ID', 'year', 'type', 'data', 'read_at'];

    protected $casts = [
        'data' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_ID');
    }

    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }

    public function markAsUnread()
    {
        $this->read_at = null;
        $this->save();
    }
}