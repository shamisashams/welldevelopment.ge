<?php
/**
 *  routes/web.php
 *
 * Date-Time: 03.06.21
 * Time: 15:41
 * @author Insite LLC <hello@insite.international>
 */

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutUsController;
use Illuminate\Support\Facades\Route;

Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->withoutMiddleware('web')->name('upload');

Route::any('bog/callback/status', [\App\BogPay\BogCallbackController::class, 'status'])->withoutMiddleware('web')->name('bogCallbackStatus');
Route::any('bog/callback/refund',[\App\BogPay\BogCallbackController::class, 'refund'])->withoutMiddleware('web')->name('bogCallbackRefund');

Route::redirect('', config('translatable.fallback_locale'));
Route::prefix('{locale?}')
    ->middleware(['setlocale'])
    ->group(function () {
        Route::prefix('adminpanel')->group(function () {
            Route::get('login', [LoginController::class, 'loginView'])->name('loginView');
            Route::post('login', [LoginController::class, 'login'])->name('login');


            Route::middleware('auth')->group(function () {
                Route::get('logout', [LoginController::class, 'logout'])->name('logout');

                Route::redirect('', 'adminpanel/category');

                // Language
                Route::resource('language', LanguageController::class);
                Route::get('language/{language}/destroy', [LanguageController::class, 'destroy'])->name('language.destroy');

                // Translation
                Route::resource('translation', TranslationController::class);

                // Category
                Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);
                Route::get('category/{category}/destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('category.destroy');
//
                // Product
                Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
                Route::get('product/{product}/destroy', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
//                // Gallery
                Route::resource('gallery', GalleryController::class);
                Route::get('gallery/{gallery}/destroy', [GalleryController::class, 'destroy'])->name('gallery.destroy');



                // Slider
                Route::resource('slider', SliderController::class);
                Route::get('slider/{slider}/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');

                // Page
                Route::resource('page', PageController::class);
                Route::get('page/{page}/destroy', [PageController::class, 'destroy'])->name('page.destroy');


                Route::get('setting/active',[SettingController::class,'setActive'])->name('setting.active');
                // Setting
                Route::resource('setting', SettingController::class);
                Route::get('setting/{setting}/destroy', [SettingController::class, 'destroy'])->name('setting.destroy');


                Route::resource('order', \App\Http\Controllers\Admin\OrderController::class);
                //Route::get('order/{order}/destroy', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('order.destroy');

                // Password
                Route::get('password', [\App\Http\Controllers\Admin\PasswordController::class, 'index'])->name('password.index');
                Route::post('password', [\App\Http\Controllers\Admin\PasswordController::class, 'update'])->name('password.update');

                Route::resource('attribute', \App\Http\Controllers\Admin\AttributeController::class);
                Route::get('attribute/{attribute}/destroy', [\App\Http\Controllers\Admin\AttributeController::class, 'destroy'])->name('attribute.destroy');


                Route::resource('project', \App\Http\Controllers\Admin\ProjectController::class);
                Route::get('project/{project}/project', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('project.destroy');

                Route::resource('apartment', \App\Http\Controllers\Admin\ApartmentController::class);
                Route::get('apartment/{apartment}/apartment', [\App\Http\Controllers\Admin\ApartmentController::class, 'destroy'])->name('apartment.destroy');

                Route::resource('blog', \App\Http\Controllers\Admin\BlogController::class);
                Route::get('blog/{blog}/destroy', [\App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('blog.destroy');

                Route::resource('city', \App\Http\Controllers\Admin\CityController::class);
                Route::get('city/{city}/destroy', [\App\Http\Controllers\Admin\CityController::class, 'destroy'])->name('city.destroy');

                Route::resource('district', \App\Http\Controllers\Admin\DistrictController::class);
                Route::get('district/{district}/destroy', [\App\Http\Controllers\Admin\DistrictController::class, 'destroy'])->name('district.destroy');

                Route::resource('detail', \App\Http\Controllers\Admin\DetailController::class);
                Route::get('detail/{detail}/destroy', [\App\Http\Controllers\Admin\DetailController::class, 'destroy'])->name('detail.destroy');

            });
        });

        Route::get('projects', [\App\Http\Controllers\Client\ProjectController::class, 'index'])->name('client.project.index');
        Route::get('project/{project}', [\App\Http\Controllers\Client\ProjectController::class, 'show'])->name('client.project.show');

        Route::get('apartment', [\App\Http\Controllers\Client\ApartmentController::class, 'index'])->name('client.apartment.index');
        Route::get('apartment/{apartment}', [\App\Http\Controllers\Client\ApartmentController::class, 'show'])->name('client.apartment.show');

        Route::get('favorites',[\App\Http\Controllers\Client\FavoriteController::class,'index'])->name('client.favorite.index');

        Route::get('favorites-list',[\App\Http\Controllers\Client\FavoriteController::class,'getFavorites'])->name('client.favorite.get');

        Route::middleware(['active'])->group(function () {

            // Home Page
            Route::get('', [HomeController::class, 'index'])->name('client.home.index');

            Route::get('blog', [\App\Http\Controllers\Client\BlogController::class, 'index'])->name('client.blog.index');
            Route::get('blog/{blog}', [\App\Http\Controllers\Client\BlogController::class, 'show'])->name('client.blog.show');

            // Contact Page
            Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');
            Route::post('/contact-us', [ContactController::class, 'mail'])->name('client.contact.mail');

            Route::post('/call-request', [ContactController::class, 'callRequest'])->name('client.call_request');

            // About Page
            Route::get('about', [AboutUsController::class, 'index'])->name('client.about.index');

            // Product Page
            Route::get('products', [\App\Http\Controllers\Client\ProductController::class, 'index'])->name('client.product.index');
           Route::get('product/{product}', [\App\Http\Controllers\Client\ProductController::class, 'show'])->name('client.product.show');

           Route::get('category/{category}',[\App\Http\Controllers\Client\CategoryController::class,'show'])->name('client.category.show');
            Route::get('popular',[\App\Http\Controllers\Client\CategoryController::class,'popular'])->name('client.category.popular');
            Route::get('special',[\App\Http\Controllers\Client\CategoryController::class,'special'])->name('client.category.special');
            Route::get('new',[\App\Http\Controllers\Client\CategoryController::class,'new'])->name('client.category.new');

            //checkout
            Route::get('cart',[\App\Http\Controllers\Client\CartController::class,'index'])->name('client.cart.index');
            Route::get('checkout',[\App\Http\Controllers\Client\OrderController::class,'index'])->name('client.checkout.index');
            Route::post('checkout',[\App\Http\Controllers\Client\OrderController::class,'order'])->name('client.checkout.order');
            Route::get('order/success',[\App\Http\Controllers\Client\OrderController::class,'statusSuccess'])->name('order.success');
            Route::get('order/failure',[\App\Http\Controllers\Client\OrderController::class,'statusFail'])->name('order.failure');

            Route::get('search', [\App\Http\Controllers\Client\SearchController::class, 'index'])->name('search.index');

            Route::any('payments/bog/status',[\App\Http\Controllers\Client\OrderController::class, 'bogResponse'])->name('bogResponse');

            /*Route::get('test/{method}',function ($locale,$method,\App\Http\Controllers\TestController $testController){

                return $testController->{$method}();
            });

            Route::post('test/filter',[\App\Http\Controllers\TestController::class,'filter']);*/
        });
    });


