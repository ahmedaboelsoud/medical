<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'patient_id', 'medicine', 'note', 'note','appdata'
    ];
    


      

    public function scopeWhenStartdate($query, $startdate)
    {
        return $query->when($startdate, function ($q) use ($startdate) {
            return $q->where('appdata','>=', $startdate);
        });
    }//

    public function scopeWhenEnddate($query, $enddate)
    {
        return $query->when($enddate, function ($q) use ($enddate) {
            return $q->where('appdata','<=', $enddate);
        });
    }//

    public function scopeWhenPatientId($query, $patientId)
    {
        return $query->when($patientId, function ($q) use ($patientId) {
            return $q->where('patient_id', $patientId);
        });

    }//

    public function scopeWhenDoctorId($query, $doctorId)
    {
        return $query->when($doctorId, function ($q) use ($doctorId) {
            return $q->where('doctor_id', $doctorId);
        });

        // return $query->when($doctorId, function ($q) use ($doctorId) {

        //     return $q->whereHas('doctors', function ($qu) use ($doctorId) {

        //         return $qu->where('doctors.id', $doctorId);

        //     });

        // });

    }//

    public function scopeWhenAppdata($query, $appdata)
    {
        return $query->when($appdata, function ($q) use ($appdata) {

            if ($appdata == 'popular') {
                return $q->where('appdata', null);
            }

            return $q->where('appdata', $appdata);

        });

    }// end of scopeWhenGender


    public function doctors()
    {
        return $this->belongsTo(Doctor::class,'doctor_id'); 
    }

    public function profits()
    {
        return $this->hasMany(Profit::class);
    }    
    

    public function patients()
    {
        return $this->belongsTo(Patient::class,'patient_id'); 
    }

}
