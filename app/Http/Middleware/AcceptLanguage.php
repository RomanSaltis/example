<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AcceptLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $availableLocales = config('app.available_locales');
        $acceptLanguage = strtolower(strval($request->header('Accept-Language')));
        print_r($availableLocales);
        echo "\n  ";
        print_r($acceptLanguage);
        echo "\n  ";
            foreach (explode(',', $acceptLanguage) as $language){
                print_r($language);
                echo "\n  ";
                $convertedLanguage=substr($language, 0, 2);
                if (in_array($convertedLanguage, $availableLocales)){
                    echo ' Accept Lang is :  ';
                    echo "\n ";
                    echo $convertedLanguage;
                    App::setLocale($convertedLanguage);
                    break;
                }
            }
        echo "\n ";
        echo ' Current LOCALE  -  '. App::currentLocale();
        echo "\n ";

        return $next($request);
    }
}

