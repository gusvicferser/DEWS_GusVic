<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NotFoundHttpException $exc, Request $request){
            if($request->is('api/*')) {
                return response()->json(['message' => 'Recurso no disponible'], 404);
            }
        });
         $exceptions->render(function (ValidationException $exc, Request $request){
            if($request->is('api/*')) {
                return response()->json(['message' => 'Datos no válidos, revise su estructura'], 400);
            }
        });
        $exceptions->render(function (Exception $exc, Request $request){
            if($request->is('api/*')) {
                return response()->json(['message' => 'Error: '. $exc->message()], 500);
            }
        });
    })->create();
