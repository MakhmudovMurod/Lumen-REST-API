<?php

namespace App;

 
use Illuminate\Database\Eloquent\Model;
 

class User_profile extends Model  
{
    
     
    protected $fillable = [
        'date','status','amount','currency','source_account_id','destination_account_id'
    ];
    
 


   
}
