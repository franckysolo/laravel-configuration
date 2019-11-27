<?php

namespace Indy\LaravelConfiguration\Http\Middleware;

use Closure;
use Indy\LaravelConfiguration\Configuration;

/**
 * @author franckysolo
 *
 * @see App\Http\Kernel::$routeMiddleware
 *  Add the middleware to the list
 *
 * @uses
 *  if you want to get cache in specific route
 *  add the middleware to the group
 *  <pre>
 *    $this->group(['middleware' => ['settings']], function () {});
 *  </pre>
 *  The you can get dynamic configuration via
 *  <pre>
 *   $value = config('keyname')
 *  </pre>
 */
class Settings
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
        $config = cache()->get(Configuration::CACHE_KEY);

        if (empty($config) === true) {
            $config = Configuration::settings();
            cache()->forever(Configuration::CACHE_KEY, $config);
        }

        if (empty($config) === false) {
            config($config);
        }

        return $next($request);
    }
}
