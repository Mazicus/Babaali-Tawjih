<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Hash, DB, Password, Http};
use App\Models\User;
class AccountTest extends TestCase
{
    use RefreshDatabase;
    private function user(string $email='member@example.com'): User { return User::create(['full_name'=>'Test Member','adress_email'=>$email,'phonenumber'=>'0700000000','mot_de_passe'=>password_hash('password123',PASSWORD_BCRYPT),'auth_version'=>0]); }
    private function member(User $user): static { return $this->actingAs($user)->withSession(['auth_version'=>$user->auth_version]); }
    public function test_public_pages_and_guest_access(): void {
        foreach(['/','/index.html','/login.php','/inscription.php','/forgot-password.php','/reset-password.php'] as $path) $this->get($path)->assertOk();
        $this->get('/Dashboard.php')->assertRedirect('/login.php'); $this->get('/avatar.php')->assertRedirect('/login.php');
        $this->getJson('/favorites.php')->assertJson(['authenticated'=>false,'ids'=>[]]);
        $this->get('/unknown.php')->assertNotFound();
    }
    public function test_legacy_password_login_and_logout(): void {
        $user=$this->user(); $this->post('/login.php',['email'=>$user->adress_email,'password'=>'password123'])->assertRedirect('/Dashboard.php');
        $this->assertAuthenticatedAs($user); $this->get('/Dashboard.php')->assertOk()->assertSee('Test Member');
        $this->post('/logout.php')->assertRedirect('/index.html'); $this->assertGuest();
    }
    public function test_registration_uses_legacy_columns_and_hashes(): void {
        $this->post('/inscription.php',['full_name'=>'New Member','adress_email'=>'NEW@example.com','phonenumber'=>'0700000000','mot_de_passe'=>'password123','confirm_password'=>'password123'])->assertRedirect('/login.php');
        $user=User::where('adress_email','new@example.com')->firstOrFail(); $this->assertTrue(Hash::check('password123',$user->mot_de_passe));
    }
    public function test_favorites_are_persistent_and_account_scoped(): void {
        $one=$this->user(); $two=$this->user('second@example.com'); $id=(new \App\Services\SchoolCatalog)->schools()[0]['id'];
        $this->member($one)->postJson('/favorites.php',['school_id'=>$id,'action'=>'save'])->assertOk()->assertJson(['ids'=>[$id]]);
        $this->postJson('/favorites.php',['school_id'=>$id,'action'=>'save'])->assertOk(); $this->assertDatabaseCount('user_favorites',1);
        $this->member($two)->getJson('/favorites.php')->assertJson(['ids'=>[]]);
        $this->postJson('/favorites.php',['school_id'=>$id,'action'=>'remove'])->assertOk(); $this->assertDatabaseCount('user_favorites',1);
        $this->member($one)->postJson('/favorites.php',['school_id'=>$id,'action'=>'remove'])->assertOk()->assertJson(['ids'=>[]]);
        $this->postJson('/favorites.php',['school_id'=>999999,'action'=>'save'])->assertStatus(422);
    }
    public function test_profile_and_private_avatar(): void {
        $one=$this->user(); $two=$this->user('second@example.com');
        $png=base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aD1sAAAAASUVORK5CYII=');
        $file=\Illuminate\Http\UploadedFile::fake()->createWithContent('avatar.png',$png);
        $this->member($one)->post('/profile.php',['full_name'=>'Changed Name','phonenumber'=>'0700000001','avatar'=>$file])->assertRedirect('/Dashboard.php#profile');
        $this->assertSame('Changed Name',$one->fresh()->full_name); $this->get('/avatar.php')->assertOk()->assertHeader('Content-Type','image/png');
        $this->member($two)->get('/avatar.php')->assertNotFound();
        $this->member($one)->post('/profile.php',['full_name'=>'Changed Name','remove_avatar'=>1])->assertRedirect(); $this->assertDatabaseCount('user_avatars',0);
    }
    public function test_reset_password_invalidates_sessions_and_keeps_favorites(): void {
        $user=$this->user(); $token=Password::createToken($user);
        $this->withSession(['reset_credentials'=>['email'=>$user->adress_email,'token'=>$token]])->post('/reset-password.php',['password'=>'newpassword123','confirmation'=>'newpassword123'])->assertRedirect('/login.php');
        $this->assertTrue(Hash::check('newpassword123',$user->fresh()->mot_de_passe)); $this->assertSame(1,$user->fresh()->auth_version);
        $this->actingAs($user->fresh())->withSession(['auth_version'=>0])->get('/Dashboard.php')->assertRedirect('/login.php');
        $this->assertFalse(Password::tokenExists($user->fresh(),$token));
    }
    public function test_google_pkce_callback_and_existing_account_protection(): void {
        config(['services.google.client_id'=>'client','services.google.client_secret'=>'secret','services.google.redirect_uri'=>'http://localhost/google-callback.php']);
        Http::fake(['oauth2.googleapis.com/*'=>Http::response(['access_token'=>'testtoken']),'openidconnect.googleapis.com/*'=>Http::response(['sub'=>'google-123','email'=>'google@example.com','email_verified'=>true,'name'=>'Google Member'])]);
        $response=$this->get('/google-oauth.php'); $response->assertRedirect(); $this->assertStringContainsString('code_challenge_method=S256',$response->headers->get('Location'));
        $flow=session('google_oauth'); $this->get('/google-callback.php?state='.$flow['state'].'&code=test')->assertRedirect('/Dashboard.php'); $this->assertAuthenticated(); $this->assertDatabaseHas('google_accounts',['google_sub'=>'google-123']);
        $this->get('/Dashboard.php')->assertOk();
        $this->post('/logout.php'); $this->get('/google-callback.php?state='.$flow['state'].'&code=test')->assertRedirect('/login.php'); $this->assertGuest();
    }
    public function test_contact_is_saved_and_validation_blocks_invalid_input(): void {
        $this->post('/contact.php',['full_name'=>'Visitor','adresse_email'=>'visitor@example.com','message_TEXT'=>'Please help me choose a school.'])->assertRedirect('/index.html#contact'); $this->assertDatabaseCount('contact',1);
        $this->post('/contact.php',['full_name'=>'X'])->assertSessionHasErrors();
    }
}
