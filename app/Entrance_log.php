<?php

namespace App;

 
use Illuminate\Database\Eloquent\Model;
 

class Entrance_log extends Model  
{
    
     
    protected $fillable = [
        'username','log_date','log_ip','user_agent'
    ];
    


   
}
