<?php

namespace App\Providers;


use App\Events\VerificationEvent;
use Illuminate\Support\Facades\Event;
use App\Listeners\VerificationListener;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use App\Services\ResponseServices\ResponseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data = null, $message = 'عملیات با موفقیت انجام شد', $status = 200) {
            return ResponseService::successResponse($data, $message, $status = 200);
        });

        Response::macro('error', function ($message, $status = 400) {
            return ResponseService::errorResponse($message, $status);
        });

        Response::macro('excelResponse', function ($writer) {
            return ResponseService::excelResponse($writer);
        });

        Response::macro('pdfResponse', function ($meta, $fileName) {
            return ResponseService::pdfResponse($meta, $fileName);
        });



        Event::listen(VerificationEvent::class, VerificationListener::class);


    }
}
