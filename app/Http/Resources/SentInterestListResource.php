<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SentInterestListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'		=> (string)$this->id,
            'user_id'	=> $this->person_id ? $this->person_id : '0',
            //'status'	=> $this->status ? $this->status : '',
			'image'       	=> $this->profile_image ? (string) asset('data/public/'. $this->profile_image) : asset('public/'. config('constants.DEFAULT_THUMBNAIL')),
            'name'       	=> $this->name ? (string) $this->name : '',
            'bio'   		=> $this->bio ? new BioDataResource($this->bio) : null,
        ];
    }
}
