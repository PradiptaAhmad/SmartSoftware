<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateFilamentActiveToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (filament()->auth()->check()) {
            $apiService = new ApiService();
            $isActive = $apiService->get(
                endpoint: '/profile',
                authToken: filament()->auth()->user()->auth_token,
            )->successful();
            if (!$isActive) {
                $loginUrl = filament()
                    ->getCurrentPanel()
                    ->getLoginUrl();
                filament()->auth()->logout();
                session()->flush();
                return redirect($loginUrl)
                    ->with('message', 'Akun Anda tidak aktif. Silakan hubungi admin untuk mengaktifkan akun Anda.')
                    ->with('type', 'danger');
            }
        }
        return $next($request);
    }
}
