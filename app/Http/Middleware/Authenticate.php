<?php


// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;



// class Authenticate extends Middleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param \Illuminate\Http\Request $request
//      * @param \Closure $next
//      * @param string ...$guards
//      * @return mixed
//      */
//     public function handle(Request $request, Closure $next, ...$guards)
//     {
//         // Calls the parent method to handle the request
//         return $this->authenticate($request, $guards)
//                     ? $next($request)
//                     : $this->unauthenticated($request, $guards);
//     }

//     /**
//      * Handle an unauthenticated user.
//      *
//      * @param \Illuminate\Http\Request $request
//      * @param array $guards
//      * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
//      */
//     protected function unauthenticated(Request $request, array $guards)
//     {
//         // Custom logic for unauthenticated users
//         if ($request->expectsJson()) {
//             return response()->json(['message' => 'You must log in first.'], 401);
//         }

//         return redirect()->guest(route('login'));
//     }
// } 


namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Check if the request expects a JSON response (for API requests)
        if (!$request->expectsJson()) {
            // For non-JSON requests, you can redirect to a login page (like in web apps)
            return route('login');
        }

        // For API requests, return null to avoid redirecting and allow throwing an unauthenticated error
        return null;
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // Handle unauthenticated request and return a custom message for API
            return response()->json(['message' => 'You are not authenticated'], 401);
        }

        return $next($request);
    }
       
    protected function unauthenticated($request, array $guards)
    {
        // Return a JSON response if the user is not authenticated
        if ($request->expectsJson()) {
            return response()->json(['message' => 'You are not authenticated.'], 401);
        }

        parent::unauthenticated($request, $guards);  // Use the default behavior for non-JSON requests
    }
}
