<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerPreference extends Model
{
    protected $table = 'partner_preference';
    
    protected $fillable = ['user_id', 'age','height','marital_status','religion','community','start_age','end_age','mother_tongue','state_living_in','city_living_in','qualification','working_with','profession_area','income','diet'];

    // Get User detail
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}