<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryImageResource extends JsonResource
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
        // return parent::toArray($request);
         return [
            'id'	=> (string) $this->id,
            'image'	=> $this->image ? asset('data/public/'. $this->image) : '',
        ];
    }
}
