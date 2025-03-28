<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'method', 'ip', 'platform', 'browser', 'user_id','log_name','event','description','subject_type','localtion'
    ];

    /**
     * Get the user that owns the log activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
