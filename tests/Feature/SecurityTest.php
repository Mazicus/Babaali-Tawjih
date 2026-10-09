<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Http, Notification, Password, Schema, DB, Hash};
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
class SecurityTest extends TestCase
{
    use RefreshDatabase;
    private function user(): User { return User::create(['full_name'=>'Existing Member','adress_email'=>'existing@example.com','phonenumber'=>'0700000000','mot_de_passe'=>Hash::make('password123')]); }
    public function test_real_csrf_protection_rejects_missing_token_and_accepts_valid_token(): void {
        $this->app['env']='local';
        $this->post('/login.php',['email'=>'existing@example.com','password'=>'password123'])->assertStatus(419);
        $this->get('/login.php')->assertOk(); $token=session()->token();
        $this->post('/login.php',['_token'=>$token,'email'=>'existing@example.com','password'=>'incorrect'])->assertSessionHasErrors('email');
    }
    public function test_recovery_sends_native_notification_and_hides_account_existence(): void {
        config(['services.resend.key'=>'test-key','mail.from.address'=>'accounts@example.com']); Notification::fake(); $user=$this->user();
        $this->post('/forgot-password.php',['email'=>$user->adress_email])->assertSessionHas('success');
        Notification::assertSentTo($user,ResetPassword::class,function($notification)use($user) { return Password::tokenExists($user,$notification->token); });
        $message=session('success'); $this->post('/forgot-password.php',['email'=>'unknown@example.com'])->assertSessionHas('success',$message);
    }
    public function test_google_cannot_silently_link_an_existing_password_account(): void {
        $user=$this->user(); config(['services.google.client_id'=>'client','services.google.client_secret'=>'secret','services.google.redirect_uri'=>'http://localhost/google-callback.php']);
        Http::fake(['oauth2.googleapis.com/*'=>Http::response(['access_token'=>'testtoken']),'openidconnect.googleapis.com/*'=>Http::response(['sub'=>'existing-google','email'=>$user->adress_email,'email_verified'=>true,'name'=>'Member'])]);
        $this->get('/google-oauth.php'); $state=session('google_oauth.state');
        $this->get('/google-callback.php?state='.$state.'&code=test')->assertRedirect('/login.php')->assertSessionHas('oauth_error'); $this->assertGuest(); $this->assertDatabaseCount('google_accounts',0);
        $this->actingAs($user)->withSession(['auth_version'=>0])->get('/google-oauth.php'); $state=session('google_oauth.state');
        $this->get('/google-callback.php?state='.$state.'&code=test')->assertRedirect('/Dashboard.php'); $this->assertDatabaseHas('google_accounts',['user_id'=>$user->id]);
    }
    public function test_google_rejects_invalid_state_without_contacting_provider(): void {
        Http::fake(); $this->withSession(['google_oauth'=>['state'=>'correct','expires'=>time()+600,'user_id'=>null,'verifier'=>'test','remember'=>false]])->get('/google-callback.php?state=wrong&code=test')->assertRedirect('/login.php'); Http::assertNothingSent();
    }
    public function test_adoption_migration_preserves_existing_accounts_and_personal_data(): void {
        $user=$this->user(); DB::table('user_favorites')->insert(['user_id'=>$user->id,'school_id'=>6,'saved_at'=>now()]);
        Schema::create('account_auth_versions',function($table) { $table->unsignedBigInteger('user_id')->primary(); $table->unsignedBigInteger('version'); });
        DB::table('account_auth_versions')->insert(['user_id'=>$user->id,'version'=>4]); Schema::table('users',fn($table)=>$table->dropColumn('auth_version'));
        $migration=require database_path('migrations/2026_10_09_000001_adopt_laravel.php'); $migration->up(); $migration->up();
        $this->assertDatabaseHas('users',['id'=>$user->id,'adress_email'=>$user->adress_email,'mot_de_passe'=>$user->mot_de_passe,'auth_version'=>4]); $this->assertDatabaseHas('user_favorites',['user_id'=>$user->id,'school_id'=>6]);
    }
}
