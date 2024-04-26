<?php

namespace App\Http\Resources;
use App\Models\City;
use App\Models\Country;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPlanListResource extends JsonResource
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
            'tagline'		=> $this->tagline ? (string) $this->tagline : '',
            'line_one'		=> $this->line_one ? (string) $this->line_one : '',
            'line_two'		=> $this->line_two ? (string) $this->line_two : '',
            'line_three'	=> $this->line_three ? (string) $this->line_three : '',
            'line_four'		=> $this->line_four ? (string) $this->line_four : '',
            'line_five'		=> $this->line_five ? (string) $this->line_five : '',
            'packages'		=> $this->packages ? $this->packages : [],
        ];
    }
}