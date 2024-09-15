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
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);  // This is the default method that checks authentication

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     // If the request expects JSON, return null and handle it in unauthenticated()
    //     return $request->expectsJson() ? null : route('login');
    // }

    /**
     * Handle an unauthenticated user.
     */
    protected function unauthenticated($request, array $guards)
    {
        // Return a JSON response if the user is not authenticated
        if ($request->expectsJson()) {
            return response()->json(['message' => 'You are not authenticated.'], 401);
        }

        parent::unauthenticated($request, $guards);  // Use the default behavior for non-JSON requests
    }
}
