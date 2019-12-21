<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\Login_log;
use App\User;
class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $Data = json_decode(stripslashes(htmlspecialchars_decode(urldecode($request->reqObject))));
        $Task     = $Data->task;
        $TaskData = $Data->taskData;

        if($Task != 'Login') {
            if (isset($TaskData->user_id) && $TaskData->user_id != '' && isset($TaskData->session_token) && $TaskData->session_token != '') {

                $user_check = User::where('id', $TaskData->user_id)->get();
                if (!$user_check->isEmpty()) {

                    $check = Login_log::where('user_id', $TaskData->user_id)->where('session_token', $TaskData->session_token)->get();
                    if (!$check->isEmpty()) {
                        return $next($request);
                    } else {
                        return response()->json([
                            'message'   => 'Unauthorized,First login to Access This.',
                            'success'   => 0
                        ]);
                    }

                } else {
                    return response()->json([
                        'message'   => "Please Register First.",
                        'success'   => 0
                    ]);
                }
            } else {
                return response()->json([
                    'message'   => "Please send proper data.",
                    'success'   => 0
                ]);
            }

        } else {
            return $next($request);
        }
    }
}
