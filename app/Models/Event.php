<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_date',
        'year_level',
        'course',
        'department',
        'event_fee',
        'status',
        'user_id',
    ];

    // Many-to-many relationship with students
    public function students()
    {
        return $this->belongsToMany(Student::class, 'event_student', 'event_id', 'student_id')
                    ->withPivot('status', 'amount_paid', 'user_id')
                    ->using(EventStudent::class)
                    ->withTimestamps();
    }

        // One-to-many relationship with evaluations
        public function evaluations()
        {
            return $this->hasMany(Evaluation::class, 'event_id');
        }

        // Event creator (organization)
        public function creator()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        // Optional: Generate public evaluation link
        public function getEvaluationLinkAttribute()
        {
            return route('evaluations.form', ['event' => $this->id]);
        }
}
