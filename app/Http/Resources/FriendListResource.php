<?php

namespace App\Http\Resources;
use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class FriendListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        $last_message = Chat::select('chat.*')
					->rightJoin('users as t2', 't2.id', '=', 'chat.user_id')
					->whereIn("chat.user_id", [Auth::user()->id, $this->id])
					->whereIn("chat.friend_id", [$this->id, Auth::user()->id])
					->orderBy('chat.id','DESC')->get()->first();

		return [
            'id'            		=> (string)$this->id,
            'name'          		=> $this->name,
            'image'					=> $this->profile_image ? (string) asset('data/public/'. $this->profile_image) : asset('public/'. config('constants.DEFAULT_THUMBNAIL')),
            'is_online'        		=> $this->isOnline ? (string)$this->isOnline : '0',
            'last_message'          => $last_message->message ?? 'No new messages',
			'bio'   				=> $this->bio ? new BioDataResource($this->bio) : null
        ];
    }
}
