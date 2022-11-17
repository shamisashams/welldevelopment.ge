@extends('admin.nowa.views.layouts.app')

@section('styles')

    <!--- Internal Select2 css-->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="{{asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    <!---Internal Fancy uploader css-->
    <link href="{{asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />

    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/telephoneinput/telephoneinput.css')}}">

    <link rel="stylesheet" href="{{asset('uploader/image-uploader.css')}}">

@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{ __('admin.order-view') }}</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    {{--<div class="d-lg-flex">
                        <h6 class="main-content-label mb-1"><span class="d-flex mb-4"><a href="{{url('index')}}"><img src="{{asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a></span></h6>
                        <div class="ms-auto">
                            <p class="mb-1"><span class="font-weight-bold">Invoice No : #000321</span></p>
                        </div>
                    </div>--}}
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <p class="h3">Order id #{{$order->id}}</p>
                            <address>
                                {{$order->first_name}}, {{$order->last_name}}<br>
                                Tel.: {{$order->phone}}<br>
                                {{$order->email}}<br>
                                {{$order->city}}<br>
                                {{$order->address}}<br>
                                {{$order->info}}<br>
                                <b>Payment Method ></b> {{$order->payment_method ? 'Bank' : 'Cash'}}<br>
                                <b>Courier Service ></b> {{$order->courier_service === 0 ? 'Tbilisi' : 'Region'}}
                            </address>
                        </div>
                        {{--<div class="col-lg-6 text-end">
                            <p class="h3">Invoice To:</p>
                            <address>
                                Street Address<br>
                                State, City<br>
                                Region, Postal Code<br>
                                ypurdomain@example.com
                            </address>
                            <div class="">
                                <p class="mb-1"><span class="font-weight-bold">Invoice Date :</span></p>
                                <address>
                                    01st November 2020
                                </address>
                            </div>
                        </div>--}}
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice table-bordered">
                            <thead>
                            <tr>
                                <th class="wd-20p">Product</th>

                                <th class="tx-center">QNTY</th>
                                <th class="tx-right">Unit</th>
                                <th class="tx-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{$item->name}}</td>

                                <td class="tx-center">{{$item->qty_ordered}}</td>
                                <td class="tx-right">{{$item->price}}₾</td>
                                <td class="tx-right">{{$item->total}}₾</td>
                            </tr>
                            @endforeach

                            <tr>
                                <td class="valign-middle" colspan="2" rowspan="4">
                                    <div class="invoice-notes">
                                        <label class="main-content-label tx-13">Notes</label>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                    </div><!-- invoice-notes -->
                                </td>
                                <td class="tx-right">Sub-Total</td>
                                <td class="tx-right" colspan="2">{{$order->grand_total}}₾</td>
                            </tr>
                            <tr>
                                <td class="tx-right">Tax</td>
                                <td class="tx-right" colspan="2">0%</td>
                            </tr>
                            <tr>
                                <td class="tx-right">Discount</td>
                                <td class="tx-right" colspan="2">0%</td>
                            </tr>
                            <tr>
                                <td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
                                <td class="tx-right" colspan="2">
                                    <h4 class="tx-bold">{{$order->grand_total}}₾</h4>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{--<button type="button" class="btn ripple btn-primary mb-1"><i class="fe fe-credit-card me-1"></i> Pay Invoice</button>
                    <button type="button" class="btn ripple btn-secondary mb-1"><i class="fe fe-send me-1"></i> Send Invoice</button>--}}
                    <button type="button" class="btn ripple btn-info mb-1" onclick="javascript:window.print();"><i class="fe fe-printer me-1"></i> Print Invoice</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('scripts')

    <!--Internal  Datepicker js -->
    <script src="{{asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>

    <!-- Internal Select2 js-->
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <!--Internal Fileuploads js-->
    <script src="{{asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

    <!--Internal Fancy uploader js-->
    <script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

    <!--Internal  Form-elements js-->
    <script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <!-- Internal TelephoneInput js-->
    <script src="{{asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
    <script src="{{asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

    <script src="{{asset('uploader/image-uploader.js')}}"></script>

    <!--Internal  Chart.bundle js -->
    <script src="{{asset('assets/plugins/chartjs/Chart.bundle.min.js')}}"></script>


    <script>
        let oldImages = $('#old_images').val();
        if (oldImages) {
            oldImages = JSON.parse(oldImages);
        }
        let imagedata = [];
        let getUrl = window.location;
        let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
        if (oldImages && oldImages.length > 0) {
            oldImages.forEach((el, key) => {
                let directory = '';
                if (el.fileable_type === 'App\\Models\\Project') {
                    directory = 'project';
                }
                imagedata.push({
                    id: el.id,
                    src: `${baseUrl}${el.path}/${el.title}`
                })
            })
            $('.input-images').imageUploader({
                preloaded: imagedata,
                imagesInputName: 'images',
                preloadedInputName: 'old_images'
            });
        } else {
            $('.input-images').imageUploader();
        }
    </script>

@endsection
