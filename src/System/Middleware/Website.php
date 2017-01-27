<?php

namespace Mage2\Framework\System\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Mage2\Install\Models\Website as WebsiteModel;
use App;


class Website
{
    /**
     * @var CategoryRepository
     */
    public function __construct()
    {
        //parent::__construct();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //App::setLocale('hi');
        //if (!Schema::hasTable('migrations')) {
            //return redirect()->route('mage2.install');
        //}


        $website = WebsiteModel::all()->first();

        if(!isset($website->id)) {
            throw new \Exception('There is an error while installtion of app. Please remove database and reinstall again.');
        }
        Session::put('website_id', $website->id);
        Session::put('is_default_website', true);
        Session::put('default_website_id', $website->id);

        return $next($request);

        /**
        $host = str_replace('http://', '', $request->getUriForPath(''));
        $host = str_replace('https://', '', $host);

        $cacheKey = 'default_website_middleware_query';

        if (Cache::has($cacheKey)) {
            $website = Cache::get($cacheKey);
        } else {
            $website = WebsiteModel::all()->first();
            //$website = WebsiteModel::where('host', '=', $host)->get()->first();
            Cache::put($cacheKey, $website, $minute = 100);
        }


        Session::put('website_id', $website->id);

        if ($website->is_default == 1) {
            Session::put('is_default_website', true);
            Session::put('default_website_id', $website->id);
        } else {
            $defaultWebsite = WebsiteModel::where('is_default', '=', 1)->get()->first();

            Session::put('is_default_website', false);
            Session::put('default_website_id', $defaultWebsite->id);
        }


        return $next($request);
         */
    }
}
