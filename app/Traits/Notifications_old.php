<?php
 
namespace App\Traits;

use Illuminate\Http\Request;


trait Notifications {
   

   public static function sendNotfic($token,$id,$doctor_id,$message_ar,$message_en,$title_ar,$title_en,$image,$type,$android_channel_id)
   {
         // android_channel_id = SLAMTACD ID -- Doctor
         // android_channel_id = SLAMTAC ID  -- Salmtc   
        $path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
        $server_key = env('FCM_KEY', '');

        $headers = [
            'Authorization:key='.$server_key,
            'Content-Type:application/json'
        ];
        
        $arra['id'] = $id;
        $arra['is_rate'] = 1;
        $arra['doctor_id'] = $doctor_id;
        $arra['message_ar'] = $message_ar;
        $arra['message_en'] = $message_en;
        $arra['title_ar'] = $title_ar;
        $arra['title_en'] = $title_en;
        $arra['image'] = $image;
        $arra['type'] = $type;
        $arra['android_channel_id'] = $android_channel_id; 
        $fields = array('to' => $token,'notification'=>array($arra));
        $payload = json_encode($fields);

            
        $curl_session = curl_init();
        curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
        curl_setopt($curl_session,CURLOPT_POST,true);
        curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER ,false);
        curl_setopt($curl_session,CURLOPT_IPRESOLVE,false);
        curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);
        $result = curl_exec($curl_session);
        var_dump($result);
   }
  
}


                // "id":0,
                // "":0,
                // "":0,
                // "":"",
                // "":"",
                // "":"",
                // "":"",
                // "":"",
                // "":0,
                // "":"SLAMTAC ID"
