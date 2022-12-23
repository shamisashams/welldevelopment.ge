<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{$meta_title}}</title>
    <meta name="description"
          content="{{ $meta_description }}">
    <meta name="keywords" content="{{ $meta_keyword }}">
    <meta property="og:title" content="{{ $og_title }}">
    <meta property="og:description" content="{{ $og_description }}">

        <meta property="og:image" content={{$image}}>

    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:type" content="page">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet"/>
{{--    @if(app()->getLocale()=="ge")--}}
{{--        <link href="{{ mix('/css/AppGeo.css') }}" rel="stylesheet"/>--}}
{{--    @elseif(app()->getLocale()=="en")--}}
{{--        <link href="{{ mix('/css/AppEng.css') }}" rel="stylesheet"/>--}}
{{--    @endif--}}
    {{--    @dd($page["props"]["page"]["meta_title"])--}}
    @routes
    <!-- JQUERY JS -->
    <script src="{{asset('admin/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script>
        function __(key, sharedData, replace = {}) {
            let data = key.split('.');
            //console.log(sharedData);
            let translation = sharedData[data[1]] || key;

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            //console.log(translation);
            return translation;

        }

        String.prototype.newLineToBr = function () {
            return this.replace(/(?:\r\n|\r|\n)/g, '<br>');
        };

        /*Array.prototype.remove = function() {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };*/
        const breadcrumb = function (path) {
            let rows = '';
            path.map(function (el, i) {
                if (i < path.length - 1) {
                    rows += el.title;
                    rows += ' / ';
                } else {
                    rows += el.title;
                }
            });
            return rows;
        };

        //localStorage.removeItem('welldevelopment_favorite');
    </script>
</head>
<body>
<!-- Messenger Chat Plugin Code -->
{{--<div id="fb-root"></div>--}}

<!-- Your Chat Plugin code -->
{{--<div id="fb-customer-chat" class="fb-customerchat"></div>--}}

<script>
    /*var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "100160159275529");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function () {
        FB.init({
            xfbml: true,
            version: 'v12.0'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));*/
</script>
@inertia
</body>

</html>
