<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Attribute;
use App\Models\Setting;
use App\Repositories\Eloquent\AttributeRepository;
use App\Repositories\SettingRepositoryInterface;
use App\Rules\Code;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;

class AttributeController extends Controller
{
    /**
     * @var SettingRepositoryInterface
     */
    private $attributeRepository;


    /**
     * @param SettingRepositoryInterface $settingRepository
     */
    public function __construct(
        AttributeRepository  $attributeRepository
    )
    {
        $this->attributeRepository = $attributeRepository;
    }


    /**
     * @param SettingRequest $request
     * @return Application|Factory|View
     */
    public function index(SettingRequest $request)
    {
        /*return view('admin.pages.setting.index', [
            'settings' => $this->settingRepository->getData($request, ['translations'])
        ]);*/

        return view('admin.nowa.views.attribute.index', [
            'attributes' => $this->attributeRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {

        $attribute = $this->attributeRepository->model;
        //dd($categories);

        $url = locale_route('attribute.store', [], false);
        $method = 'POST';

        return view('admin.nowa.views.attribute.form', [
            'url' => $url,
            'method' => $method,
            'attribute' => $attribute
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'code'       => ['required', 'unique:attributes,code', new Code()],
            'type'       => 'required',
        ]);

        $data = $request->all();

        //$data['is_user_defined'] = 1;

        $this->attributeRepository->create($data);




        return redirect(locale_route('attribute.index'))->with('success', __('admin.create_successfully'));

    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function show(string $locale, Setting $setting)
    {
        return view('admin.pages.setting.show', [
            'setting' => $setting,
        ]);
    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function edit(string $locale, Attribute $attribute)
    {
        $url = locale_route('attribute.update', $attribute->id, false);
        $method = 'PUT';

        /*return view('admin.pages.setting.form', [
            'setting' => $setting,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.attribute.form', [
            'attribute' => $attribute,
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
    public function update(Request $request, string $locale, Attribute $attribute)
    {
        $request->validate([
            'code'       => ['required', 'unique:attributes,code,' .$attribute->id, new Code()],
            'type'       => 'required'
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $this->attributeRepository->update($attribute->id,$saveData);


        return redirect(locale_route('attribute.index', $attribute->id))->with('success', __('admin.update_successfully'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, Attribute $attribute)
    {
        if (!$this->attributeRepository->delete($attribute->id)) {
            return redirect(locale_route('attribute.index', $attribute->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('attribute.index'))->with('success', __('admin.delete_message'));
    }


    public function setActive(Request $request){
        //dd($request->all());
        Setting::where('id',$request->get('id'))->update(['active' => $request->get('active')]);
    }
}
