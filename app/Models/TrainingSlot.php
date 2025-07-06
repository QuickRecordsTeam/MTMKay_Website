<?php

namespace App\Models;

use App\Traits\GenerateUUIDTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSlot extends Model
{
    use HasFactory, SoftDeletes;

    use GenerateUUIDTrait;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'available_seats',
        'status',
        'program_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function countCompletedEnrollments($id) {
        $slot = TrainingSlot::findOrFail($id);
         
        return $slot->enrollments()->whereNotNull('enrollment_date')->count();
    }


}
