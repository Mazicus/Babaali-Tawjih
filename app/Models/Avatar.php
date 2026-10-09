<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Avatar extends Model
{
    protected $table = 'user_avatars';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['user_id','mime_type','image_data','updated_at'];
    protected $hidden = ['image_data'];
}
