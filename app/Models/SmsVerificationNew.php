<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsVerificationNew extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_verifications';

    protected $fillable = ['mobile_number','code','status'];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
   
}
