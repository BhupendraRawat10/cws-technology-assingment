<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
            $roleName = Roles::find($user->role->id); 
            if (!($roleName &&$roleName->role == "guest")) {
                return redirect()->back();
            }
        return $next($request);
        }else{
            return redirect()->back();
        } 
        
    }
}
