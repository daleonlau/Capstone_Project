<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'event_id',
        'student_id', // hashed or encrypted
        'answers',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'answers' => 'array', // Automatically convert JSON to array
    ];

    /**
     * Get the event that this evaluation belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
