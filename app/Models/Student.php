<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'firstname',
        'lastname',
        'yearlevel',
        'course',
        'department',
        'user_id',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_student', 'student_id', 'event_id')
                    ->withPivot('status', 'amount_paid', 'user_id')
                    ->withTimestamps();
    }
}
