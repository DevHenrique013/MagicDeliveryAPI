<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJSON
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $request->headers->set('Accept','application/json');

        if(in_array($request->method(),['POST','PUT','PATCH'], true)){

            $contentType = (string) $request->header('Content-Type','');

            if(!str_contains($contentType, 'application/json')){
                
                return response()->json([
                    'message' => 'Content-type must be application/json'
                ], 415);
            }
        }

        $response = $next($request);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
