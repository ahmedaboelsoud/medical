<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
          'user_id','photo','brief','birthday','status'
    ];
    protected $appends = ['image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     
    public function scopeWhenName($query, $name)
    {
        return $query->when($name, function ($query) use ($name) {
            $query->whereHas('user', function ($query) use ($name) {
               $query->where('name', 'LIKE', "%{$name}%");
            });
        });
    }// end of scopeWhenGender

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {

            if ($status == 'popular') {
                return $q->user->where('status', null);
            }
            return $q->where('status',$status);
        });
    }// end of scopeWhenGender


    public function educations()
    {
        return $this->hasMany(Education::class)->orderBy('start_year', 'DESC');
    }


    public function experiences()
    {
        return $this->hasMany(Experience::class)->orderBy('start_year', 'DESC');
    }
    
    public function getImageAttribute() {
        return ('/assets/doctors/' .$this->photo);
    }

   

    
    

    



}
