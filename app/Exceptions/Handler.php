<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (InvalidInputException $e, $request){
            return response(['message' => $e->getMessage()], 400);
        });

//        $this->renderable(function (QueryException $e, $request){
//            return response(['message' => "QUERYEXCEPTION:". $e->getMessage()], 401);
//        });

        $this->renderable(function (EmailException $e, $request){
            return response(['message' => "Handler announcement:". $e->getMessage()], 400);
        });

        $this->renderable(function(ModelNotFoundException $e, $request){
            return response(['message'=> "Model not found: ". $e->getMessage()], 400);
        });

      //  \Illuminate\Database\Eloquent

        $this->renderable(function (ValidationNameException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
        $this->renderable(function (ValidationPasswordException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
        $this->renderable(function (ValidationEmailStructureException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
        $this->renderable(function (DeleteProtectException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
        $this->renderable(function (CarPriceException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
        $this->renderable(function (CarUserException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
        $this->renderable(function (ExistsRelationException $e, $request){
            return response(['message'=> "Handler announcement: ". $e->getMessage()], 400);
        });
    }
}
