<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Model\Rating;


class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'photo_url',
        'teacher_id',
        'price',
        'is_active',
    ];

    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

}
