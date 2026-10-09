<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__.'/../routes/web.php', commands: __DIR__.'/../routes/console.php', health:'/up')
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trimStrings(except: ['mot_de_passe','confirm_password','confirmation']);
        $middleware->web(append: [App\Http\Middleware\SessionVersion::class, App\Http\Middleware\PrivateResponse::class]);
        $middleware->redirectGuestsTo('/login.php');
        $middleware->redirectUsersTo('/Dashboard.php');
        if (getenv('VERCEL')) $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(fn(Request $request) => $request->is('favorites.php','auth-status.php') || $request->expectsJson());
    })->create();
if (getenv('VERCEL')) {
    $app->useStoragePath(sys_get_temp_dir().'/babaali-laravel');
    foreach (['framework/views','framework/cache/data','framework/sessions','logs'] as $directory) {
        $path = $app->storagePath($directory);
        if (!is_dir($path)) { mkdir($path, 0700, true); }
    }
}
return $app;
