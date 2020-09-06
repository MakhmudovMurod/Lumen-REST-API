<?php

namespace App;

 
use Illuminate\Database\Eloquent\Model;
 

class User_profile extends Model  
{
    
     
    protected $fillable = [
        'first_name','user_id','last_name','phone_number','date_of_birth'
    ];
    

    public function users(){
        return $this->belongsTo('App\User');
    }


    public function accounts(){
        return $this->hasMany('App\Accounts' );
    }

   
}
