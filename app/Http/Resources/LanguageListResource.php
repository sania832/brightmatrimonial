<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageListResource extends JsonResource
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
            'id'            	=> (string)$this->id,
            'title'				=> (string)$this->title,
            'code'				=> (string)$this->code,
            'slug'				=> (string)$this->slug,
        ];
    }
}
