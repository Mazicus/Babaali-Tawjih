<?php
namespace App\Http\Controllers;
use App\Models\{User, Avatar, Favorite, Contact};
use App\Services\SchoolCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash};
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function form(Request $request, string $view = 'login') {
        return view($view, ['error_message'=>$request->session()->get('oauth_error', $request->session()->get('errors')?->first() ?? ''), 'success_message'=>$request->session()->get('success',''), 'email'=>old($view==='login'?'email':'adress_email',''), 'full_name'=>old('full_name',''), 'phone'=>old('phonenumber','')]);
    }
    public function login(Request $request) {
        $data=$request->validate(['email'=>'required|email|max:254','password'=>'required|string|max:72']);
        if (!Auth::attempt(['adress_email'=>strtolower($data['email']),'password'=>$data['password']],$request->boolean('remember_me'))) {
            throw ValidationException::withMessages(['email'=>'Email ou mot de passe incorrect.']);
        }
        $request->session()->regenerate(); $request->session()->put('auth_version',Auth::user()->auth_version);
        return redirect('/Dashboard.php');
    }
    public function register(Request $request) {
        $request->merge(['adress_email'=>strtolower((string)$request->input('adress_email'))]);
        $data=$request->validate(['full_name'=>'required|string|min:2|max:255','adress_email'=>'required|email|max:254|unique:users,adress_email','phonenumber'=>['required','string','max:32','regex:/^[\d\s+()\-]{7,32}$/'],'mot_de_passe'=>'required|string|min:8|max:72|same:confirm_password']);
        $data['mot_de_passe']=Hash::make($data['mot_de_passe']); User::create($data);
        return redirect('/login.php')->with('success','Votre compte est créé. Vous pouvez vous connecter.');
    }
    public function logout(Request $request) {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect('/index.html');
    }
    public function status(Request $request) { return response()->json(['authenticated'=>Auth::check(),'name'=>$request->user()?->full_name]); }
    public function dashboard(Request $request, SchoolCatalog $catalog) {
        $user=$request->user(); $favorites=$catalog->saved($user->favorites()->pluck('school_id')->all());
        $parts=preg_split('/\s+/u',trim($user->full_name)); $initials=mb_strtoupper(mb_substr($parts[0],0,1).(count($parts)>1?mb_substr(end($parts),0,1):''));
        return view('dashboard', ['user'=>$user,'favorites'=>$favorites,'sectors'=>$catalog->sectors(),'favoritesAvailable'=>true,'photosAvailable'=>true,'avatarVersion'=>$user->avatar?->updated_at,'csrf'=>csrf_token(),'initials'=>$initials,'profileInput'=>['name'=>old('full_name',$user->full_name),'phone'=>old('phonenumber',$user->phonenumber)],'errorMessages'=>array_filter([$request->session()->get('errors')?->first(),$request->session()->get('oauth_error')]),'successes'=>array_filter([$request->session()->get('success')]),'cities'=>count(array_unique(array_column($favorites,'location'))),'googleConfigured'=>filled(config('services.google.client_id'))&&filled(config('services.google.client_secret'))]);
    }
    public function favorites(Request $request, SchoolCatalog $catalog) {
        if ($request->isMethod('post')) {
            abort_unless($request->user(),401);
            $data=$request->validate(['school_id'=>'required|integer|min:1','action'=>'required|in:save,remove']);
            $id=(int)$data['school_id']; abort_if($data['action']==='save'&&!$catalog->contains($id),422,'École inconnue.');
            if ($data['action']==='save') { DB::table('user_favorites')->upsert(['user_id'=>$request->user()->id,'school_id'=>$id,'saved_at'=>now()],['user_id','school_id'],['saved_at']); }
            else { $request->user()->favorites()->where('school_id',$id)->delete(); }
            if ($request->is('Dashboard.php')) return redirect('/Dashboard.php#favorites')->with('success','Votre sélection est mise à jour.');
        }
        return response()->json(['authenticated'=>Auth::check(),'ids'=>$request->user()?->favorites()->orderBy('school_id')->pluck('school_id')->all()??[],'csrf'=>csrf_token()]);
    }
    public function profile(Request $request) {
        $data=$request->validate(['full_name'=>'required|string|min:2|max:255','phonenumber'=>['nullable','string','max:32','regex:/^[\d\s+()\-]{7,32}$/'],'avatar'=>['nullable','file','mimes:jpg,jpeg,png,webp','max:1024','dimensions:max_width=4096,max_height=4096']]);
        DB::transaction(function () use($request,$data) {
            $request->user()->update(['full_name'=>$data['full_name'],'phonenumber'=>$data['phonenumber']??'']);
            if ($request->boolean('remove_avatar')) $request->user()->avatar()->delete();
            if ($request->hasFile('avatar')) { $file=$request->file('avatar'); Avatar::updateOrCreate(['user_id'=>$request->user()->id],['mime_type'=>$file->getMimeType(),'image_data'=>file_get_contents($file->getRealPath()),'updated_at'=>now()]); }
        });
        return redirect('/Dashboard.php#profile')->with('success','Votre profil est enregistré.');
    }
    public function avatar(Request $request) { $avatar=$request->user()->avatar; abort_unless($avatar,404); return response($avatar->image_data)->header('Content-Type',$avatar->mime_type); }
    public function contact(Request $request) {
        $data=$request->validate(['full_name'=>'required|string|min:2|max:255','adresse_email'=>'required|email|max:254','message_TEXT'=>'required|string|max:10000']); Contact::create($data);
        return redirect('/index.html#contact')->with('success','Votre message a été envoyé.');
    }
}
