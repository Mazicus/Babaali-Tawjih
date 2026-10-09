<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    protected $attributes = ['auth_version'=>0];
    protected $fillable = ['full_name','adress_email','phonenumber','mot_de_passe','auth_version'];
    protected $hidden = ['mot_de_passe','remember_token'];
    protected function casts(): array { return ['auth_version'=>'integer']; }
    public function getAuthPasswordName(): string { return 'mot_de_passe'; }
    public function getEmailForPasswordReset(): string { return $this->adress_email; }
    public function routeNotificationForMail(): string { return $this->adress_email; }
    public function favorites(): HasMany { return $this->hasMany(Favorite::class); }
    public function avatar(): HasOne { return $this->hasOne(Avatar::class); }
}
