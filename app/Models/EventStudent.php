<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventStudent extends Pivot
{
    protected $table = 'event_student';

    protected $fillable = [
        'event_id',
        'student_id',
        'status',
        'amount_paid',
        'user_id',
    ];

    public $timestamps = true;

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
