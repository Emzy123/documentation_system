<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolFees
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->student) {
            if (!$user->student->hasPaidSchoolFees()) {
                // If accessing the fees page itself, allow it to prevent infinite loop
                if ($request->routeIs('student.fees.*')) {
                    return $next($request);
                }

                return redirect()->route('student.fees.index')
                    ->with('error', 'You must pay your outstanding School Fees before you can upload or request documents.');
            }
        }

        return $next($request);
    }
}
