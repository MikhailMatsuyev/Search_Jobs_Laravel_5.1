<?php

namespace App\Exceptions;

use App\Libraries\ErrorHandler;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Libraries\Utils;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {

        $this->data['settings_general'] = Utils::getSettings("general");
        $this->data['settings_seo'] = Utils::getSettings("seo");
        $this->data['settings_custom_css'] = Utils::getSettings("custom_css");
        $this->data['settings_social'] = Utils::getSettings("social");
        $this->data['settings_custom_js'] = Utils::getSettings("custom_js");




        \View::share('settings_general', $this->data['settings_general']);
        \View::share('settings_seo', $this->data['settings_seo']);
        \View::share('settings_custom_css', $this->data['settings_custom_css']);
        \View::share('settings_social', $this->data['settings_social']);
        \View::share('settings_custom_js', $this->data['settings_custom_js']);

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($this->isHttpException($e) && !env('APP_DEBUG')) {
            $errorHandler = new ErrorHandler();
            return $errorHandler->handle($e);
        }



        return parent::render($request, $e);
    }
}
