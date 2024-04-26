<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class ChatListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    /* STATIC DATA */
    public function toArray($request)
    {
		$type = 'received';
		if($this->user_id == Auth::user()->id){
			$type = 'sent';
		}
		
        return [
            'id'                => (string)$this->id,
            'message'			=> $this->message ? (string)$this->message : '',
            'is_read'			=> $this->is_read ? (string)$this->is_read : '0',
            'datetime'			=> $this->created_at ? (string)$this->created_at : '',
            'type'				=> $type,
        ];
    }
}
