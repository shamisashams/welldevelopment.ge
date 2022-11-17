<?php
/**
 *  app/Providers/AppServiceProvider.php
 *
 * Date-Time: 07.06.21
 * Time: 15:32
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Providers;

use App\Breadcrumbs\Breadcrumbs;
use App\Models\Language;
use App\Observers\LanguageObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Language::observe(LanguageObserver::class);

        Request::macro('breadcrumbs',function () {
            return new Breadcrumbs($this);
        });
    }
}
