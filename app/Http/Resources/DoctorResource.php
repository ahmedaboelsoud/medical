<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->user->name,
            'email'    => $this->user->email,
            'status'   => $this->status,
            'brief'    => $this->brief,
            'birthday' => $this->birthday,
            'image'    => $this->image,
            'photo'    => $this->photo,
            
            
        ];
    }
}
