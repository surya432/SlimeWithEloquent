<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model as Model;

class TutorialModel extends Model {
    protected $table = "otp_vendor";  
    
    public function scopePopular($query){
        return $query->select('*')->get();
    }
}

