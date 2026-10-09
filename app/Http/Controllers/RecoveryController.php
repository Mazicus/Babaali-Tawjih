<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Password, Log};
use Illuminate\Support\Str;
class RecoveryController extends Controller
{
    public function form(Request $request) { return view('recovery',['resetMode'=>false,'tokenValid'=>false,'error'=>$request->session()->get('errors')?->first()??'','success'=>$request->session()->get('success','')]); }
    public function send(Request $request) {
        $data=$request->validate(['email'=>'required|email|max:254']);
        if (!config('services.resend.key') || !config('mail.from.address')) return back()->withErrors(['email'=>'La récupération par email est momentanément indisponible.']);
        try { Password::sendResetLink(['adress_email'=>strtolower($data['email'])]); } catch (\Throwable $error) { Log::warning('Password recovery email delivery failed.'); }
        return back()->with('success','Si cette adresse correspond à un compte, vous recevrez un lien valable 30 minutes.');
    }
    public function resetForm(Request $request) {
        if ($request->filled('token') && $request->filled('email')) {
            $request->session()->put('reset_credentials',$request->only('token','email')); return redirect('/reset-password.php');
        }
        $credentials=$request->session()->get('reset_credentials',[]);
        $user=isset($credentials['email'])?\App\Models\User::where('adress_email',$credentials['email'])->first():null;
        $valid=$user && Password::tokenExists($user,$credentials['token']??'');
        return view('recovery',['resetMode'=>true,'tokenValid'=>$valid,'success'=>'','error'=>$request->session()->get('errors')?->first()??($valid?'':'Ce lien est invalide ou a expiré.')]);
    }
    public function reset(Request $request) {
        $data=$request->validate(['password'=>'required|string|min:8|max:72|same:confirmation']);
        $credentials=$request->session()->get('reset_credentials',[]);
        $status=Password::reset(['adress_email'=>$credentials['email']??'','token'=>$credentials['token']??'','password'=>$data['password'],'password_confirmation'=>$request->input('confirmation')],function($user,$password) {
            $user->forceFill(['mot_de_passe'=>Hash::make($password),'remember_token'=>Str::random(60),'auth_version'=>$user->auth_version+1])->save();
        });
        if ($status!==Password::PASSWORD_RESET) return back()->withErrors(['password'=>'Ce lien est invalide ou a expiré.']);
        $request->session()->forget('reset_credentials'); return redirect('/login.php')->with('success','Votre mot de passe est enregistré. Connectez-vous à nouveau.');
    }
}
