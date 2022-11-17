<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\City;
use App\Models\District;
use App\Models\Slider;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\DistrictRepository;
use App\Repositories\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DistrictController extends Controller
{

    private $districtRepository;


    public function __construct(
        DistrictRepository $districtRepository
    )
    {
        $this->districtRepository = $districtRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(SliderRequest $request)
    {
        /*return view('admin.pages.slider.index', [
            'sliders' => $this->slideRepository->getData($request, ['translations'])
        ]);*/

        return view('admin.nowa.views.district.index', [
            'data' => $this->districtRepository->getData($request, ['translations','city'])

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $slider = $this->districtRepository->model;

        $url = locale_route('district.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.district.form', [
            'model' => $slider,
            'url' => $url,
            'method' => $method,
            'cities' => City::with('translation')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\ProductRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \ReflectionException
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            config('translatable.fallback_locale') . '.title' => 'required|string|max:255',
            'city_id' => 'required'
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $slider = $this->districtRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $slider = $this->districtRepository->saveFiles($slider->id, $request);
        }

        return redirect(locale_route('district.index', $slider->id))->with('success', __('admin.create_successfully'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, District $district)
    {
        $url = locale_route('district.update', $district->id, false);
        $method = 'PUT';

        /*return view('admin.pages.slider.form', [
            'slider' => $slider,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.district.form', [
            'model' => $district,
            'url' => $url,
            'method' => $method,
            'cities' => City::with('translation')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\CategoryRequest $request
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, string $locale, District $district)
    {
        //dd($request->all());
        $request->validate([
            config('translatable.fallback_locale') . '.title' => 'required|string|max:255',
            'city_id' => 'required'
        ]);
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->districtRepository->update($district->id, $saveData);

        $this->districtRepository->saveFiles($district->id, $request);


        return redirect(locale_route('district.index', $district->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, District $district)
    {
        if (!$this->districtRepository->delete($district->id)) {
            return redirect(locale_route('district.index', $district->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('district.index'))->with('success', __('admin.delete_message'));
    }
}
