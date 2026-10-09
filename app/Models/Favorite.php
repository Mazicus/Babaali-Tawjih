<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Favorite extends Model
{
    protected $table = 'user_favorites';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['user_id','school_id'];
    protected function casts(): array { return ['school_id'=>'integer']; }
}
