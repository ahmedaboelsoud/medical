<?php
 
namespace App\Traits;

use Illuminate\Http\Request;


trait Notifications {

   public static function sendNotfic($token,$id,$doctor_id,$message_ar,$message_en,$title_ar,$title_en,$image,$type,$android_channel_id,$click_action)
   {
        //$message = trans('stitac.new_reservation');
        //$title = trans('stitac.new_reservation');
        $path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
        $server_key = env('FCM_KEY', '');

        $headers = [
            'Authorization:key='.$server_key,
            'Content-Type:application/json'
        ];


       
        $fields = array('to' => $token,'data'=>array('body'=>array('id' => $id, 'is_rate'=>1, 'doctor_id'=>$doctor_id, 'message_ar'=>$message_ar, 'message_en'=>$message_en, 'title_ar'=>$title_ar, 'title_en'=>$title_en, 'image'=>$image, 'type'=>$type )),'notification'=>array('click_action'=>$click_action,'title'=>$title_en,'text'=>$message_en,'sound'=>'default','content_available'=>'true','android_channel_id'=>$android_channel_id));
        $payload = json_encode($fields);
        //var_dump($payload);
            
        $curl_session = curl_init();
        curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
        curl_setopt($curl_session,CURLOPT_POST,true);
        curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER ,false);
        curl_setopt($curl_session,CURLOPT_IPRESOLVE,false);
        curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);
        $result = curl_exec($curl_session);
        //var_dump($result);
   }
  
}


// {
//  "to":"d1ORif0GtxM:APA91bEm3Bvi08uCWgQ9mFOJ87JXj9STlgRtLn9cvOpNBg_ZwZfDKJcHg0K_ffpSHGGLgKPH5W6r2eVi_oyM90ecAXFHGEHPJkFGcbdnTEbE9nfMEm19-T6gYyJl0MvBXO4wptxd-7JD",
//  "data":
//  		{
// 			"body":
// 	 				{
// 					//"id":4,
// 					//"doctor_id":0,
// 					//"is_rate":1,
// 					//"message_ar":"ما هو تقييمك لدكتور شادى",
// 					//"message_en":"What is your rating of Dr. Shady",
// 					//"title_ar":"رايك يهمنا",
// 					//"title_en":"Your opinion matters",
// 					//"image":"",
// 					//"type":1
// 					}
//  },"notification":{
// 	  			"click_action" : "SLAMTAC_PATIENT",
//  			"title":"Your opinion matters",
// 				"text":"What is your rating of Dr. Shady",
// 				"sound":"default",
// 				"content_available":"true",
// 				"android_channel_id":"SLAMTAC ID"
//  }
// }


/*
SLAMTAC_PATIENT
SLAMTAC_DOCTOR
SLAMTAC_HOSPITAL
SLAMTAC_PHARMACY
SLAMTAC_LAB

 SLAMTAC ID
 SLAMTACD ID
*/