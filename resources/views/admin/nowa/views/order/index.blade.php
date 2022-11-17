@extends('admin.nowa.views.layouts.app')

@section('styles')



@endsection

@section('content')



    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('admin.orders')</span>
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
                        <h4 class="card-title mg-b-0">@lang('admin.orders')</h4>
                    </div>


                    {{--<p class="tx-12 tx-gray-500 mb-2">Example of Nowa Simple Table. <a href="">Learn more</a></p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form class="mr-0 p-0">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                <tr>
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.status')</th>
                                    <th>@lang('admin.grand_total')</th>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.email')</th>
                                    <th>@lang('admin.phone')</th>
                                    <th>@lang('admin.created_at')</th>
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
                                        <select class="form-control" name="status" onchange="this.form.submit()">
                                            <option value="" {{Request::get('status') === '' ? 'selected' :''}}>@lang('admin.any')</option>
                                            <option value="pending" {{Request::get('status') === 'pending' ? 'selected' :''}}>@lang('admin.pending')</option>
                                            <option value="complete" {{Request::get('status') === 'complete' ? 'selected' :''}}>@lang('admin.complete')</option>
                                        </select>
                                    </th>
                                    <th>
                                        <input class="form-control" type="number" step="0.01" name="price" onchange="this.form.submit()"
                                               value="{{Request::get('price')}}"
                                               class="validate {{$errors->has('price') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="name" onchange="this.form.submit()"
                                               value="{{Request::get('name')}}"
                                               class="validate {{$errors->has('name') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="email" onchange="this.form.submit()"
                                               value="{{Request::get('email')}}"
                                               class="validate {{$errors->has('email') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="phone" onchange="this.form.submit()"
                                               value="{{Request::get('phone')}}"
                                               class="validate {{$errors->has('phone') ? '' : 'valid'}}">
                                    </th>
                                    <th>

                                    </th>
                                </tr>

                                @if($orders)
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>

                                                <?php
                                                    switch ($order->status){
                                                        case 'success':
                                                            $color = 'green';
                                                            break;
                                                        case 'error':
                                                            $color = 'red';
                                                            break;
                                                        case 'pending':
                                                            $color = 'yellow';
                                                            break;
                                                    }
                                                ?>
                                            <td><span style="color: {{$color}};font-weight: bold">{{$order->status}}</span></td>
                                            <td>{{$order->grand_total}}₾</td>
                                            <td>{{$order->first_name .', '.$order->last_name}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->phone}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>


                                                <a href="{{locale_route('order.show',$order->id)}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">ნახვა</i>
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

        {{ $orders->appends(request()->input())->links('admin.vendor.pagination.material') }}
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
