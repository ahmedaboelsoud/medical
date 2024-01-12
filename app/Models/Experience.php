<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Experience extends Model
{
    use HasFactory;
    
    protected $table = 'experiences';
    protected $fillable = [
          'doctor_id','title','company','start_year','start_month','end_year','end_month'
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
