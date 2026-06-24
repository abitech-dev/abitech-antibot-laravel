<?php

declare(strict_types=1);

namespace Abitech\AntiBot;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Abitech\AntiBot\Middleware\VerifyAntiBotMiddleware;

class AntiBotServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios del paquete.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/antibot.php', 'antibot');

        $this->app->singleton('antibot', function ($app) {
            return new AntiBotManager($app);
        });
    }

    /**
     * Inicializar servicios del paquete.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/antibot.php' => config_path('antibot.php'),
            ], 'antibot-config');

            $this->publishes([
                __DIR__.'/../lang' => $this->app->langPath('vendor/antibot'),
            ], 'antibot-translations');
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('antibot', VerifyAntiBotMiddleware::class);

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'antibot');
    }
}
