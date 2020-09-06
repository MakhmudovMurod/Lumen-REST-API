<?php

namespace App;

 
use Illuminate\Database\Eloquent\Model;
 

class Accounts extends Model  
{
    
     
    protected $fillable = [
        'account_number','currency','balance','isActive','profile_id'
    ];
    

    public function transactions(){
        return $this->hasMany('App\Transaction' );
    }

   
}
