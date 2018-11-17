<?php namespace App\Http\Middleware;

use Closure;

class AdminUser
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
        if (!$request->session()->has('adminUser')) {
            if ($request->ajax()) {
                return ['loginStatus' => 0, 'msg' => '登录超时，请重新登录', 'url' => url('admin/login')];
            }
            return redirect('admin/login');
        }
        return $next($request);
    }

}
