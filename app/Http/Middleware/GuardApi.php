<?php

namespace App\Http\Middleware;

use App\ApiLog;
use App\Client;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class GuardApi
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
        $log = $this->logRequest($request);

        if (!$this->isValidToken($request->header('token'), $request->ip())) {
            $response = ['status' => 'failed', 'msg' => 'Token not valid'];
            $this->logResponse($log->id, $response);
            return response()->json($response, 413);
        }

        return $next($request);
    }

    private function isValidToken($request_token, $ip_remote)
    {
        $client = Client::where('token', $request_token)->first();

        if (!$client) {
            return false;
        } else {
            if ($client->ip_remote != $ip_remote) {
                return false;
            } else {
                return true;
            }
        }
    }

    private function logRequest($request)
    {
        $loging = new ApiLog();
        $loging->ip = $request->ip(); // $request->ip() || getenv('REMOTE_ADDR')
        // $loging->user_agent = $request->userAgent();
        $loging->user_agent = $request->server('HTTP_USER_AGENT');
        $loging->end_point = $request->path();
        $loging->method = $request->method();
        $loging->data = json_encode($request->all());
        // $loging->data_format = $request->header('Accept');
        $loging->data_format = $request->header('Content-Type');
        // $loging->token = $request->header('Authorization');
        $loging->token = $request->header('token');
        $loging->save();

        return $loging;
    }

    private function logResponse($logId, $response)
    {
        $loging = ApiLog::find($logId);
        $loging->response = json_encode($response);
        $loging->save();
    }
}
