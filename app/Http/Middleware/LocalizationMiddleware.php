<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Setting;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Gunakan session user, jika kosong maka gunakan pengaturan global 'id' sebagai fallback
        $locale = session('language', Setting::get('language', 'id'));
        App::setLocale($locale);
        
        return $next($request);
    }
}
