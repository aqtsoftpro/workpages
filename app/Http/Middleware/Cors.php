<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $response = $next($request);
        // $IlluminateResponse = 'Illuminate\Http\Response';
        // $SymfonyResponse = 'Symfony\Component\HttpFoundation\Response';
        // $headers = [
        //     'Access-Control-Allow-Origin' => '*',
        //     'Access-Control-Allow-Methods' => 'GET, PUT, POST, DELETE, PATCH',
        //     'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization, Access-Control-Request-Headers',
        //     'Access-Control-Allow-Credentials' => 'true',
        // ];
    
        // if ($response instanceof $IlluminateResponse) {
        //     foreach ($headers as $key => $value) {
        //         $response->header($key, $value);
        //     }
    
        //     return $response;
        // } elseif ($response instanceof $SymfonyResponse) {
        //     foreach ($headers as $key => $value) {
        //         $response->headers->set($key, $value);
        //     }
    
        //     return $response;
        // }
    
        // return $next($request)
        //     ->header('Access-Control-Allow-Origin', '*')
        //     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE')
        //     ->header('Access-Control-Allow-Credentials', 'true')
        //     ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization')
        //     ->header('Accept', $request->header('Accept'))
        //     ->header('Accept', 'application/json');

            // $response = $next($request);
            // $headers = [
            //     'Access-Control-Allow-Origin' => '*',
            //     'Access-Control-Allow-Methods' => 'GET, PUT, POST, DELETE, PATCH',
            //     'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization, Access-Control-Request-Headers',
            //     'Access-Control-Allow-Credentials' => 'true',
            // ];
        
            // if ($response instanceof \Illuminate\Http\Response) {
            //     foreach ($headers as $key => $value) {
            //         $response->header($key, $value);
            //     }
            // } elseif ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            //     foreach ($headers as $key => $value) {
            //         $response->headers->set($key, $value);
            //     }
            // }
            // return $response;

            $response = $next($request);
    
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    
            return $response;        
        
    }
}
