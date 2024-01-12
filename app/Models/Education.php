<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Education extends Model
{
    use HasFactory;
    
    protected $table = 'educations';
    protected $fillable = [
          'doctor_id','school','degree','start_year','start_month','end_year','end_month','grade'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    

    public function getEndMonthAttribute($value)
    {
        return date("F", mktime(0, 0, 0, $value, 10));
    }

    public function getStartMonthAttribute($value)
    {
        return date("F", mktime(0, 0, 0, $value, 10));
    }



}
