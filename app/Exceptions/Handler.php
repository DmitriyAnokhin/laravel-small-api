<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    const LOG_CHANNEL = 'except_report';

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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

    }


    public function report(Throwable $e)
    {
        if ($e instanceof ValidationException) {
            $validate = json_encode($e->errors());
        }

        $message = "\n================================================"
            . "\nUrl: " . request()->url()
            . "\nRequest: " . json_encode(request()->all())
            . "\nError: " . $e->getMessage()
            . "\nValidation: " . ($validate ?? null);

        // отладка
        if (config('app.debug')) {
            $message .= "\nTrace: " . json_encode($e->getTrace());
        }

        Log::channel(self::LOG_CHANNEL)->error($message);

        parent::report($e);
    }


    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {

            // Ошибка
            $response['data'] = [];
            $response['error'] = $e->getMessage();
            $response['code'] = 400;

            if ($e instanceof QueryException) {
                $response['code'] = 422;
            } else {
                $code = $e->getCode();
                if ($code) $response['code'] = $code;
            }

            // отладка
            if (config('app.debug')) {
                $response['trace'] = $e->getTrace();
            }

            return response()->json($response, $response['code']);
        }
    }

}
