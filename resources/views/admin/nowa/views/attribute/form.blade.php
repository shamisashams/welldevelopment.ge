
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
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{$attribute->created_at ? __('admin.attribute-update') : __('admin.attribute-create')}}</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->
    <input name="old-images[]" id="old_images" hidden disabled value="{{$attribute->files}}">
    <!-- row -->
    {!! Form::model($attribute,['url' => $url, 'method' => $method,'files' => true]) !!}
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.attribute')</h6>
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('admin.attribute_code')</label>
                        <input {{$attribute->created_at ? 'disabled' : ''}} class="form-control" type="text" name="code" value="{{$attribute->code}}">
                        @if($attribute->created_at)
                            <input type="hidden" name="code" value="{{$attribute->code}}">
                        @endif
                        @error('code')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <p class="mg-b-10">@lang('admin.title')</p>
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        @foreach(config('translatable.locales') as $locale)
                                            <?php
                                            $active = '';
                                            if($loop->first) $active = 'active';
                                            ?>

                                            <li><a href="#lang-{{$locale}}" class="nav-link {{$active}}" data-bs-toggle="tab">{{$locale}}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                    @foreach(config('translatable.locales') as $locale)

                                        <?php
                                        $active = '';
                                        if($loop->first) $active = 'active';
                                        ?>
                                        <div class="tab-pane {{$active}}" id="lang-{{$locale}}">
                                            <div class="form-group">
                                                <input type="text" name="{{$locale.'[name]'}}" class="form-control" placeholder="@lang('admin.title')" value="{{$attribute->translate($locale)->name ?? ''}}">
                                            </div>
                                            @error($locale.'.title')
                                            <small class="text-danger">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('admin.position')</label>
                        <input class="form-control" type="number" name="position" value="{{$attribute->position}}">
                    </div>

                    <?php

                    $types = ['select','boolean']

                    ?>

                    <div class="form-group">
                        <label class="form-label">@lang('admin.input_type')</label>
                        <select {{$attribute->created_at ? 'disabled' : ''}} name="type" class="form-control">
                            @foreach($types as $type)
                            <option value="{{$type}}"{{$attribute->type == $type ? ' selected':''}}>{{ucfirst($type)}}</option>
                            @endforeach
                        </select>
                        @if($attribute->created_at)
                            <input type="hidden" name="type" value="{{$attribute->type}}">
                        @endif
                        @error('type')
                        <small class="text-danger">
                            <div class="error">
                                {{$message}}
                            </div>
                        </small>
                        @enderror
                    </div>

                    <div class="row" id="option_row"{!!$attribute->type == 'boolean' ? ' style="display:none"' : ' style="display:block"'!!}>
                        <div class="col-12">
                            <div class="main-content-label mg-b-5">
                                @lang('admin.options')
                            </div>
                            <div class="form-group">
                                <table id="options">
                                    <tr>
                                        @foreach(config('translatable.locales') as $locale)


                                            <th>
                                                @lang('admin.label') - {{$locale}}
                                            </th>
                                        @endforeach
                                    </tr>

                                    <?php
                                    $i = 1;
                                    ?>
                                    @foreach($attribute->options as $item)
                                        <tr>
                                            <input type="hidden" name="options[{{$item->id}}][isNew]" value="false">
                                            <input type="hidden" name="options[{{$item->id}}][isDelete]" value="false">
                                            @foreach(config('translatable.locales') as $locale)


                                                <td>
                                                    <input class="form-control" type="text" name="options[{{$item->id}}][{{$locale}}][label]" value="{{$item->translate($locale)->label}}">
                                                </td>

                                            @endforeach
                                            <td>
                                                <a href="javascript:void(0);" class="del-option"><i class="fa fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </table>


                            </div>
                            <button type="button" id="add_option_btn">add option</button>
                        </div>

                    </div>

                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            {!! Form::submit($attribute->created_at ? __('admin.update') : __('admin.create'),['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>



    <!-- row closed -->
    {!! Form::close() !!}

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

        let locales = @json(config('translatable.locales'));


        let ind = 1;

        $('#add_option_btn').click(function (){
            let tr = $('<tr></tr>');
            tr.append('<input type="hidden" name="options[option_'+ ind +'][isNew]" value="true">');
            tr.append('<input type="hidden" name="options[option_'+ ind +'][isDelete]" value="false">');
            Object.keys(locales).map((name, index) => {

              

                tr.append('<td> <input class="form-control" type="text" name="options[option_'+ ind +']['+ locales[name] +'][label]" value=""> </td>');

            })

            tr.append('<td><a href="javascript:void(0);" class="del-option"><i class="fa fa-trash-alt"></i></a></td>');

            $('#options').append(tr);

            ind++

        });

        $(document).on('click','.del-option',function (e){

            let input = $(this).parents('tr').find('input[type=hidden]');
         
            if(input[0].value === 'true'){
                $(this).parents('tr').remove();
            } else {
                $(this).parents('tr').hide();
                input[1].value = 'true';
            }
        });

        $('select[name=type]').change(function (e){
            let value = $(this).val();
          
            if(value == 'select'){
                $('#option_row').show();
            } else {
                $('#option_row').hide();
            }
        });
    </script>

@endsection
