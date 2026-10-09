<?php
namespace App\Http\Controllers;
use App\Models\{User, GoogleAccount};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Http, Log};
use Illuminate\Support\Str;
class GoogleController extends Controller
{
    public function start(Request $request) {
        if (!config('services.google.client_id') || !config('services.google.client_secret') || !config('services.google.redirect_uri')) return redirect(Auth::check()?'/Dashboard.php':'/login.php')->with('oauth_error','La connexion Google nécessite la configuration du client OAuth.');
        $state=Str::random(64); $verifier=Str::random(96);
        $request->session()->put('google_oauth',['state'=>$state,'verifier'=>$verifier,'expires'=>time()+600,'user_id'=>Auth::id(),'remember'=>$request->boolean('remember')]);
        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query(['client_id'=>config('services.google.client_id'),'redirect_uri'=>config('services.google.redirect_uri'),'response_type'=>'code','scope'=>'openid email profile','state'=>$state,'code_challenge'=>rtrim(strtr(base64_encode(hash('sha256',$verifier,true)),'+/','-_'),'='),'code_challenge_method'=>'S256','prompt'=>'select_account']));
    }
    public function callback(Request $request) {
        $flow=$request->session()->pull('google_oauth');
        try {
            if (!$flow || $flow['expires']<time() || !is_string($request->input('state')) || !hash_equals($flow['state'],$request->input('state')) || $request->has('error') || !$request->filled('code') || $flow['user_id']!==Auth::id()) throw new \RuntimeException('Session Google invalide. Recommencez la connexion.');
            $token=Http::asForm()->timeout(20)->post('https://oauth2.googleapis.com/token',['client_id'=>config('services.google.client_id'),'client_secret'=>config('services.google.client_secret'),'redirect_uri'=>config('services.google.redirect_uri'),'grant_type'=>'authorization_code','code'=>$request->input('code'),'code_verifier'=>$flow['verifier']])->throw()->json('access_token');
            if (!is_string($token)||$token==='') throw new \RuntimeException('Réponse Google invalide.');
            $profile=Http::withToken($token)->timeout(20)->get('https://openidconnect.googleapis.com/v1/userinfo')->throw()->json();
            if (($profile['email_verified']??false)!==true || !filter_var($profile['email']??'',FILTER_VALIDATE_EMAIL) || strlen($profile['email'])>254 || !is_string($profile['sub']??null) || $profile['sub']==='' || strlen($profile['sub'])>255) throw new \RuntimeException('Google ne fournit pas une adresse email vérifiée.');
            $email=strtolower($profile['email']);
            $user=DB::transaction(function() use($profile,$email) {
                $account=GoogleAccount::where('google_sub',$profile['sub'])->first();
                if ($account) { if (Auth::check() && $account->user_id!==Auth::id()) throw new \RuntimeException('Ce compte Google est déjà associé à un autre profil.'); return User::findOrFail($account->user_id); }
                $existing=User::where('adress_email',$email)->first();
                if (Auth::check()) { if (strtolower(Auth::user()->adress_email)!==$email) throw new \RuntimeException('Utilisez le compte Google correspondant à votre adresse de connexion.'); $user=Auth::user(); }
                elseif ($existing) throw new \RuntimeException('Connectez-vous avec votre mot de passe, puis associez Google depuis votre profil.');
                else $user=User::create(['full_name'=>mb_substr($profile['name']??'Utilisateur Google',0,255),'adress_email'=>$email,'phonenumber'=>'','mot_de_passe'=>Hash::make(Str::random(64))]);
                GoogleAccount::create(['google_sub'=>$profile['sub'],'user_id'=>$user->id]); return $user;
            });
            Auth::login($user,$flow['remember']); $request->session()->regenerate(); $request->session()->put('auth_version',$user->auth_version); return redirect('/Dashboard.php');
        } catch (\RuntimeException $error) { return redirect(Auth::check()?'/Dashboard.php':'/login.php')->with('oauth_error',$error->getMessage()); }
        catch (\Throwable $error) { Log::warning('Google OAuth exchange failed.'); return redirect('/login.php')->with('oauth_error','La connexion Google est momentanément indisponible.'); }
    }
}
