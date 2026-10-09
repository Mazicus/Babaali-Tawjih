<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class GoogleAccount extends Model
{
    protected $table = 'google_accounts';
    protected $primaryKey = 'google_sub';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['google_sub','user_id'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
