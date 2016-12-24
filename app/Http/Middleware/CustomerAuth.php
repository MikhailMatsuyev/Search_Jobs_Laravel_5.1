<?php

namespace App\Http\Middleware;

use App\Libraries\Utils;
use Closure;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = Auth();

        if ($auth->check()) {
            //Is logged in

            if (Utils::isAdmin($auth->user()->id)) {
                return redirect()->to('/admin');
            }
        } else {
            \Session::flash('error_msg', 'Please login below');
            return redirect()->to('/login');
        }

        return $next($request);
    }
}
