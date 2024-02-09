<?php

namespace App\Http;

use App\Http\Middleware\PreEnrolleesEnsuredEmailIsVerified;
use App\Http\Middleware\VerifyCredentials;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\UserLastActivity::class,

        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'enrollees_auth' => \App\Http\Middleware\EnrolleeAuth::class,
        'employees_auth' => \App\Http\Middleware\EmployeeAuth::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'verified_enrollees_email' => \App\Http\Middleware\PreEnrolleesEnsuredEmailIsVerified::class,
        'check_module' => \App\Http\Middleware\handleUserPriv::class,
        'single_session' => \App\Http\Middleware\handleApplicants::class,
        'update_profile' => \App\Http\Middleware\updateProfile::class,
        'asis_auth' => \App\Http\Middleware\ASIS_auth::class,

        'is_email_verified' => \App\Http\Middleware\IsVerefiedEmail::class,
        'is_admin' => \App\Http\Middleware\handleRegistration::class,
        'eval' => \App\Http\Middleware\EvaluationChecker::class,


        'transactions_guard' => \App\Http\Middleware\transactionsGuard::class,

        'account_status_guard' => \App\Http\Middleware\accountStatusGuard::class,
    ];
}
