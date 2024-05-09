<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class PaidUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        
        if($user){
            $roleName = Roles::find($user->role->id); // Assuming 'name' is the attribute in the Role model that stores the role name
            if (!($roleName &&$roleName->role == "paid_user")) {
                return redirect()->back();
            }
        return $next($request);
        }else{
            return redirect()->back();
        } 
    }
}
