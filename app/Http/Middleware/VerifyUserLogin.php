<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Users;

class VerifyUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->header('Authorization')){
            $model = new Users();
            $user = $model->where('apiToken', $request->header('Authorization'))->first();
            $nowTime = time();
            if($user)
            {
                if( ($nowTime-strtotime($user->updated_at)) >=3600 )
                {
                    $user->apiToken = null;
                    $user->save();
                    return response()->json(['msg'=>'must login1'], 419);
                }
                else
                {
                    return $next($request);
                }
            }
            else
            {
                return response()->json(['msg'=>'must login2'], 419);
            }
        }else{
            return response()->json(['msg'=>'must login3'], 419);
        }
    }
}
