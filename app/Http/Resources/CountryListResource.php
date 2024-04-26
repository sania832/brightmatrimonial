<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryListResource extends JsonResource
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
            'country_name'		=> (string)$this->country_name,
            'slug'				=> (string)$this->slug,
            'country_code'		=> (string)$this->country_code,
            'dial_code'    	 	=> (string)$this->dial_code,
            'currency'        	=> (string)$this->currency,
            'currency_code'		=> (string)$this->currency_code,
            'currency_symbol'	=> (string)$this->currency_symbol,
        ];
    }
}
