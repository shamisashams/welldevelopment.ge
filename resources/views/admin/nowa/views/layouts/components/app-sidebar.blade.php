				<!-- main-sidebar -->
				<div class="sticky">
					<aside class="app-sidebar">
						<div class="main-sidebar-header active">
							<a class="header-logo active" href="{{url('adminpanel')}}">
								<img src="{{asset('admin/assets/img/brand/logo.png')}}" class="main-logo  desktop-logo" alt="logo">
								<img src="{{asset('admin/assets/img/brand/logo-white.png')}}" class="main-logo  desktop-dark" alt="logo">
								<img src="{{asset('admin/assets/img/brand/favicon.png')}}" class="main-logo  mobile-logo" alt="logo">
								<img src="{{asset('admin/assets/img/brand/favicon-white.png')}}" class="main-logo  mobile-dark" alt="logo">
							</a>
						</div>
						<div class="main-sidemenu">
							<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
							<ul class="side-menu">


                                @php
                                    use App\Helpers\Helper;
                                    $configData = Helper::applClasses();
                                @endphp

                                @if(!empty($menuData[0]) && isset($menuData[0]))
                                    @foreach ($menuData[0]->menu as $menu)
                                        @if(isset($menu->navheader))
                                            <li class="navigation-header">
                                                <a class="navigation-header-text">{{ __('admin.'.$menu->navheader) }}</a>
                                                <i class="navigation-header-icon material-icons"></i>
                                            </li>
                                        @else
                                            @php
                                                $custom_classes="";
                                                if(isset($menu->class))
                                                {
                                                $custom_classes = $menu->class;
                                                }
                                            @endphp
                                            <li class="slide" {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
                                                <a class="{{$custom_classes}} {{ (request()->route()->getName() === $menu->url) ? 'active '.$configData['activeMenuColor'] : ''}}side-menu__item"
                                                   @if(!empty($configData['activeMenuColor'])) {{'style=background:none;box-shadow:none;'}} @endif
                                                   href="@if(($menu->url)==='javascript:void(0)'){{$menu->url}} @else{{locale_route($menu->url)}} @endif"
                                                    {{isset($menu->newTab) ? 'target="_blank"':''}}>
                                                    <i class="material-icons"></i>
                                                    <span class="menu-title">{{ $menu->name}}</span>
                                                    @if(isset($menu->tag))
                                                        <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
                                                    @endif
                                                    <i class="angle fe fe-chevron-right"></i>
                                                </a>
                                                @if(isset($menu->submenu))
                                                <ul class="slide-menu">
                                                    <li class="side-menu__label1"><a href="javascript:void(0);">Charts</a></li>
                                                    <li><a class="slide-item" href="{{url('chart-morris')}}">Morris Charts</a></li>
                                                    <li><a class="slide-item" href="{{url('chart-flot')}}">Flot Charts</a></li>
                                                    <li><a class="slide-item" href="{{url('chart-chartjs')}}">ChartJS</a></li>
                                                    <li><a class="slide-item" href="{{url('chart-echart')}}">Echart</a></li>
                                                    <li><a class="slide-item" href="{{url('chart-sparkline')}}">Sparkline</a></li>
                                                    <li><a class="slide-item" href="{{url('chart-peity')}}">Chart-peity</a></li>
                                                </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                @endif


							</ul>
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
						</div>
					</aside>
				</div>
				<!-- main-sidebar -->
