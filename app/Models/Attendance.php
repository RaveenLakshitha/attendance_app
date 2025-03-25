<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // ✅ Allow mass assignment for these fields
    protected $fillable = ['user_id', 'latitude', 'longitude', 'checked_in_at', 'photo_path'];

    /**
     * Function: user
     * @relationType: belongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}