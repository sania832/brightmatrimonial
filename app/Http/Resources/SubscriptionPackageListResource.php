<?php

namespace App\Http\Resources;
use App\Models\City;
use App\Models\Country;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPackageListResource extends JsonResource
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
            'id'            => (string) $this->id,
			'title'       	=> $this->title ? (string) $this->title : '',
			'days_included'	=> $this->days_included ? (string) $this->days_included : '',
			'price'       	=> $this->price ? (string) $this->price : '',
        ];
    }
}