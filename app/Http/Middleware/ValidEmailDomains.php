<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidEmailDomains
{
    protected $email_domains = [
        'efi.org',
        'eccocorpbpo.com',
        'ecco.com.do'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $email = $user?->email;

        abort_if($request->user() && !in_array(str($email)->afterLast('@')->value, $this->email_domains), 403);

        return $next($request);
    }
}
