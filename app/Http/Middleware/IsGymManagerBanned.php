<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\GymManager;

class IsGymManagerBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
     
        if($userRole == 'gym_manager'){
            $gym_manager_Id=Auth::id();
            $isbanned = GymManager::where('id',$gym_manager_Id)->value('isban');

            if($isbanned){ 
                $message = 'Your account has been Banned. Please contact administrator.';

                return redirect()->route('bannedGymManager')
                    ->with('status',$message)
                    ->withErrors(['email' => 'Your account has been Banned. Please contact administrator.']);
            }else{
                return $next($request);
            }
        }else{
            return $next($request);
        }  
    }

}
