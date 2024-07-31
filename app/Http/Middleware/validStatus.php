<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class validStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    private $availableStatuses = ['available', 'pending', 'sold'];

    public function handle(Request $request, Closure $next): Response
    {
        $status = $request->route('status');
        if(!in_array($status, $this->availableStatuses)) return response()->json(['error' => 'Status should be value available, pending or sold.']);

        $request->merge(['type' => 'status']);
        return $next($request);
    }
}
