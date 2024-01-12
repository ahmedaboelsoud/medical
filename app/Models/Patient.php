<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'email', 'mobile', 'job', 'birthday', 'adress', 'gender','height', 'weight'
    ];


    public function scopeWhenTitle($query, $title)
    {
        return $query->when($title, function ($q) use ($title) {

            if ($title == 'popular') {
                return $q->where('title', null);
            }
            return $q->where('title', 'LIKE', "%{$title}%");
        });

    }// end of scopeWhenGender

    public function scopeWhenMobile($query, $mobile)
    {
        return $query->when($mobile, function ($q) use ($mobile) {

            if ($mobile == 'popular') {
                return $q->where('mobile', null);
            }
            return $q->where('mobile', 'LIKE', "%{$mobile}%");
        });

    }// end of scopeWhenGender

}
