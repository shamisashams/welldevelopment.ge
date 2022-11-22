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

                                        <li class="slide">
                                            <a class="side-menu__item"
                                               href="@if(($menu->url)==='javascript:void(0)'){{$menu->url}}@else{{locale_route($menu->url)}}@endif"
                                                {!! $menu->url==='javascript:void(0)' ? 'data-bs-toggle="slide"' : '' !!}>

                                                <span class="side-menu__label">{{ $menu->name }}</span>

                                                <i class="angle fe fe-chevron-right"></i>
                                            </a>

                                            @if(isset($menu->submenu))
                                                <ul class="slide-menu">
                                                    <li class="side-menu__label1"><a href="javascript:void(0);">{{ $menu->name }}</a></li>
                                                    @foreach($menu->submenu as $_menu)
                                                        <li><a class="slide-item" href="{{locale_route($_menu->url)}}">{{ $_menu->name}}</a></li>
                                                    @endforeach

                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif


							</ul>
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
						</div>
					</aside>
				</div>
				<!-- main-sidebar -->
