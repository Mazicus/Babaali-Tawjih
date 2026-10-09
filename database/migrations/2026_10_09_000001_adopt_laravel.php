<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema, DB};
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('users')) Schema::create('users',function(Blueprint $t) { $t->id(); $t->string('full_name'); $t->string('adress_email',254)->unique(); $t->string('phonenumber',32); $t->string('mot_de_passe'); });
        if (!Schema::hasColumn('users','remember_token')) Schema::table('users',fn(Blueprint $t)=>$t->rememberToken());
        if (!Schema::hasColumn('users','auth_version')) {
            Schema::table('users',fn(Blueprint $t)=>$t->unsignedBigInteger('auth_version')->default(0));
            if (Schema::hasTable('account_auth_versions')) DB::table('account_auth_versions')->orderBy('user_id')->chunk(500,function($rows) { foreach($rows as $row) DB::table('users')->where('id',$row->user_id)->update(['auth_version'=>$row->version]); });
        }
        if (!Schema::hasTable('contact')) Schema::create('contact',function(Blueprint $t) { $t->id(); $t->string('full_name'); $t->string('adresse_email',254); $t->text('message_TEXT'); });
        if (!Schema::hasTable('google_accounts')) Schema::create('google_accounts',function(Blueprint $t) { $t->string('google_sub')->primary(); $t->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete(); });
        if (!Schema::hasTable('user_favorites')) Schema::create('user_favorites',function(Blueprint $t) { $t->foreignId('user_id')->constrained('users')->cascadeOnDelete(); $t->unsignedInteger('school_id'); $t->timestamp('saved_at')->useCurrent(); $t->primary(['user_id','school_id']); });
        if (!Schema::hasTable('user_avatars')) {
            Schema::create('user_avatars',function(Blueprint $t) { $t->foreignId('user_id')->primary()->constrained('users')->cascadeOnDelete(); $t->string('mime_type',32); $t->binary('image_data'); $t->timestamp('updated_at')->useCurrent(); });
            if (DB::getDriverName()==='mysql') DB::statement('ALTER TABLE user_avatars MODIFY image_data MEDIUMBLOB NOT NULL');
        }
        if (!Schema::hasTable('laravel_password_reset_tokens')) Schema::create('laravel_password_reset_tokens',function(Blueprint $t) { $t->string('email')->primary(); $t->string('token'); $t->timestamp('created_at')->nullable(); });
        if (!Schema::hasTable('laravel_sessions')) Schema::create('laravel_sessions',function(Blueprint $t) { $t->string('id')->primary(); $t->foreignId('user_id')->nullable()->index(); $t->string('ip_address',45)->nullable(); $t->text('user_agent')->nullable(); $t->longText('payload'); $t->integer('last_activity')->index(); });
        if (!Schema::hasTable('laravel_cache')) Schema::create('laravel_cache',function(Blueprint $t) { $t->string('key')->primary(); $t->mediumText('value'); $t->integer('expiration'); });
        if (!Schema::hasTable('laravel_cache_locks')) Schema::create('laravel_cache_locks',function(Blueprint $t) { $t->string('key')->primary(); $t->string('owner'); $t->integer('expiration'); });
    }
    public function down(): void { throw new LogicException('This adoption migration preserves account data. Restore a verified database backup to reverse it.'); }
};
