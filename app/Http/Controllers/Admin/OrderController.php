<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;

class OrderController extends Controller
{

    private $orderRepository;



    public function __construct(
        OrderRepository $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * @param SettingRequest $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        /*return view('admin.pages.setting.index', [
            'settings' => $this->settingRepository->getData($request, ['translations'])
        ]);*/

        return view('admin.nowa.views.order.index', [
            'orders' => $this->orderRepository->getData($request,['items'])
        ]);
    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function show(string $locale, Order $order)
    {
        return view('admin.nowa.views.order.show', [
            'order' => $order,
        ]);
    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function edit(string $locale, Setting $setting)
    {
        $url = locale_route('setting.update', $setting->id, false);
        $method = 'PUT';

        /*return view('admin.pages.setting.form', [
            'setting' => $setting,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.setting.form', [
            'setting' => $setting,
            'url' => $url,
            'method' => $method,
        ]);
    }


    /**
     * @param SettingRequest $request
     * @param string $locale
     * @param Setting $setting
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request,string $locale, Setting $setting)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $this->orderRepository->update($setting->id,$saveData);


        return redirect(locale_route('setting.index', $setting->id))->with('success', __('admin.update_successfully'));
    }


    public function setActive(Request $request){
        //dd($request->all());
        Setting::where('id',$request->get('id'))->update(['active' => $request->get('active')]);
    }
}
