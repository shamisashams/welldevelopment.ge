@extends('admin.nowa.views.layouts.app')

@section('styles')



@endsection

@section('content')



    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('admin.attributes')</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@lang('admin.attributes')</h4>
                    </div>

                    <a href="{{locale_route('attribute.create')}}" class="btn ripple btn-primary" type="button">@lang('admin.create')</a>
                    {{--<p class="tx-12 tx-gray-500 mb-2">Example of Nowa Simple Table. <a href="">Learn more</a></p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form class="mr-0 p-0">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                <tr>
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.attribute_code')</th>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <th>
                                        <input class="form-control" type="number" name="id" onchange="this.form.submit()"
                                               value="{{Request::get('id')}}"
                                               class="validate {{$errors->has('id') ? '' : 'valid'}}">
                                    </th>

                                    <th>
                                        <input class="form-control" type="text" name="code" onchange="this.form.submit()"
                                               value="{{Request::get('code')}}"
                                               class="validate {{$errors->has('code') ? '' : 'valid'}}">
                                    </th>

                                    <th>
                                        <input class="form-control" type="text" name="name" onchange="this.form.submit()"
                                               value="{{Request::get('name')}}"
                                               class="validate {{$errors->has('value') ? '' : 'valid'}}">
                                    </th>
                                    <th></th>
                                </tr>

                                @if($attributes)
                                    @foreach($attributes as $attribute)
                                        <tr>
                                            <td>{{$attribute->id}}</td>

                                            <td>{{$attribute->code}}</td>

                                            <td>
                                                <div class="panel panel-primary tabs-style-2">
                                                    <div class=" tab-menu-heading">
                                                        <div class="tabs-menu1">
                                                            <!-- Tabs -->
                                                            <ul class="nav panel-tabs main-nav-line">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li><a href="#cat-{{$locale}}-{{$attribute->id}}" class="nav-link {{$loop->first?"active":""}}" data-bs-toggle="tab">{{$locale}}</a></li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body tabs-menu-body main-content-body-right border">
                                                        <div class="tab-content">

                                                            @foreach(config('translatable.locales') as $locale)
                                                                <div class="tab-pane {{$loop->first?"active":""}}" id="cat-{{$locale}}-{{$attribute->id}}">
                                                                    {{$attribute->translate($locale)->name ?? ''}}
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                            <td>


                                                <a href="{{locale_route('attribute.edit',$attribute->id)}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">@lang('admin.edit_button')</i>
                                                </a>

                                                <a href="{{locale_route('attribute.destroy',$attribute->id)}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">@lang('admin.delete_button')</i>
                                                </a>


                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        {{ $attributes->appends(request()->input())->links('admin.vendor.pagination.material') }}
    </div>
    <!-- /row -->

@endsection

@section('scripts')

<script>
    $('[data-setting]').click(function (e){
        let $this = $(this);
       let id = $(this).data('setting');
       let active = 0;
       if($(this).is(':checked')) active = 1;
       //alert(id);
        $.ajax({
            url: '{{locale_route('setting.active')}}',
            data: { id:id, active: active, _token: '{{csrf_token()}}' },
            type: 'get',
            beforeSend: function (){
                $this.prop('disabled',true);
            },
            success: function (data){
                $this.prop('disabled',false);
            },
            error: function (){
                $this.prop('disabled',true);
                alert('error');
            }
        });
    });
</script>

@endsection
