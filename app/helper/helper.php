 
 <?php

if (! function_exists('appointments')) {
    function appointments($id)
    {
        $date = date("Y-m-d");
        $x = "";
        $obj = App\Models\Appointment::where('patient_id',$id)->orderBy('appdata', 'DESC')->first();
        if($obj){
             $obj2 =  $obj->where('patient_id',$id)->where('appdata','>=',$date)->orderBy('appdata', 'DESC')->count();
             if($obj2 >= 1){
                $x = '<a href='.url("appointments/change_appointments/".$id).' class="btn default btn-xs blue"><i class="fa fa-eye"></i>'.__('appointments.waiting').'</a>';
             }else{
                 $x = '<a href='.url("appointments/receive_appointments/".$id).' class="btn default btn-xs purple"><i class="fa fa-eye"></i>'.__('appointments.done').'</a>';
             }
        }else{
             $x = '<a href='.url("appointments/receive_appointments/".$id).' class="btn default btn-xs green"><i class="fa fa-eye"></i>'.__('appointments.no_appointments').'</a>';
        }
        echo  $x;        
    }
}
