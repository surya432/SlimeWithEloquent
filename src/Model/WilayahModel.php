<?php 
namespace App\Model;
use Illuminate\Database\Eloquent\Model as Model;
class WilayahModel extends Model {
 protected $table = "wilayah_propinsi";

 public function scopePopular($query)
 {
     return $query->select('*')->get();
 }
}
?>
