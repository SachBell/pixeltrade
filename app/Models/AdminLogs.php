<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLogs extends Model
{
    use HasFactory;

    protected $table = 'admin_logs';

    protected $fillable = [
        'user_id',
        'action',
    ];

    public function adminLogsUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
