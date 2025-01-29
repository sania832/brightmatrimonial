<?php

namespace App\Http\Resources;
use App\Models\City;
use App\Models\Country;
use App\Models\UserBio;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchesListResource extends JsonResource
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
            'image'       	=> $this->profile_image ? (string) asset('bright-metromonial/public/' . $this->profile_image) : asset('default/default-user.jpg'),
            'name'       	=> $this->name ? (string) $this->name : '',
            'bio'   		=> $this->bio ? new BioDataResource($this->bio) : new BioDataResource(new UserBio),
        ];
    }
}
