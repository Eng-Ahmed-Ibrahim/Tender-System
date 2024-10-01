<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
    <!--begin::Menu wrapper-->
    <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
        <!--begin::Menu-->
        <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
            <!--begin:Menu item-->
                <!--begin:Menu link-->
              
                <!--end:Menu link-->
                <!--begin:Menu sub-->
         
            <!--end:Menu item-->

            <!--end:Menu item-->
            <!--begin:Menu item-->
        
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">

            <div class="select">

                <form action="{{ route('currency.store') }}" method="post">
                    @csrf
                    <select class="form-select" name="currency_code" onchange="this.form.submit()">
                        <option value="USD" {{ 'USD' == session('currency_code') ? 'selected' : '' }}>{{ __('USD') }}</option>
<option value="EUR" {{ 'EUR' == session('currency_code') ? 'selected' : '' }}>{{ __('EUR') }}</option>
<option value="SAR" {{ 'SAR' == session('currency_code') ? 'selected' : '' }}>{{ __('SAR') }}</option>
<option value="QAR" {{ 'QAR' == session('currency_code') ? 'selected' : '' }}>{{ __('QAR') }}</option>
<option value="EGP" {{ 'EGP' == session('currency_code') ? 'selected' : '' }}>{{ __('EGP') }}</option>

                    </select>
                </form>
                


            </div>
            
            </div>


            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">

                <div class="select">
    
                    <form action="{{ route('changeLang') }}" method="get">
                        <select class="form-select" name="lang" onchange="this.form.submit()">
                            <option value="en" {{ 'en' == session('locale') ? 'selected' : '' }}>{{ __('English') }}</option>
                            <option value="ar" {{ 'ar' == session('locale') ? 'selected' : '' }}>{{ __('Arabic') }}</option>
           
                        </select>
                    </form>
                    
                    
    
    
                </div>
                
                </div>
                @php
                    
                $countries = \App\Models\Country::whereIn('name', ['Egypt', 'Saudi Arabia', 'Qatar', 'United States', 'France'])->get();
                @endphp


                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">

                    <div class="select">


                        <!--begin::Menu item-->
                      
                               
                        </div>



                        <form action="{{ route('updateCountrySession') }}" method="post">
                            @csrf
                            <select class="form-select" name="country_id" onchange="this.form.submit()">
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ session('country_id') == $country->id ? 'selected' : '' }}>
                                    <img class="rounded-1" src="{{ asset('assets/media/flags/' . strtolower($country->name) . '.svg') }}" alt="{{ $country->name }}" style="width: 20px; height: auto; vertical-align: middle;" />
                                    {{ __($country->name) }}
                                </option>
                            @endforeach
                            
                            </select>
                        </form>
                        
                        
                        
        
        
                    </div>
                    
                    </div>




 
      
            <!--end:Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
    <!--begin::Navbar-->
    <div class="app-navbar flex-shrink-0">
        <!--begin::Search-->
        <div class="app-navbar-item align-items-stretch ms-1 ms-md-4">
            <!--begin::Search-->
            <div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                <!--begin::Search toggle-->
                <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px">
                        <i class="ki-duotone ki-magnifier fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <!--end::Search toggle-->
                <!--begin::Menu-->
              
                <!--end::Menu-->
            </div>
            <!--end::Search-->
        </div>
        <!--end::Search-->

        <!--end::My apps links-->
        <!--begin::User menu-->
        <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
            <!--begin::Menu wrapper-->
            <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                <img src="{{ auth()->user()->photo ? asset('/upload/admin_images/' . auth()->user()->photo) : asset('assets/avatar.png') }}" class="rounded-3" alt="user" />
            </div>
            <!--begin::User account menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px me-5">
                            <div class="user-photo" style="background-image: url('{{ auth()->user()->photo ? asset('/upload/admin_images/' . auth()->user()->photo) : asset('assets/avatar.png') }}'); width: 50px; height: 50px; background-size: cover; background-position: center;"></div>
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                            <div class="fw-bold d-flex align-items-center fs-5">{{auth()->user()->name}}
                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span></div>
                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{auth()->user()->email}}</a>
                        </div>
                        <!--end::Username-->
                    </div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <a href="{{ route('UserProfile.index') }}" class="menu-link px-5">{{__('My Profile')}}</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                   
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                   
                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                      
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="../../demo1/dist/account/statements.html" class="menu-link d-flex flex-stack px-5">{{__('Statements')}}
                            <span class="ms-2 lh-0" data-bs-toggle="tooltip" title="View your statements">
                                <i class="ki-duotone ki-information-5 fs-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span></a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content px-3">
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                                    <span class="form-check-label text-muted fs-7">{{__('Notifications')}}</span>
                                </label>
                            </div>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu sub-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
               
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                        <span class="menu-title position-relative">{{__('Mode')}}
                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-duotone ki-night-day theme-light-show fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                                <span class="path7"></span>
                                <span class="path8"></span>
                                <span class="path9"></span>
                                <span class="path10"></span>
                            </i>
                            <i class="ki-duotone ki-moon theme-dark-show fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span></span>
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-night-day fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                        <span class="path7"></span>
                                        <span class="path8"></span>
                                        <span class="path9"></span>
                                        <span class="path10"></span>
                                    </i>
                                </span>
                                <span class="menu-title">{{__('Light')}}</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-moon fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">{{__('Dark')}}</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-screen fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">{{__('System')}}</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                  
                
                    


                    <div class="menu-sub menu-sub-dropdown w-175px py-4">

              
          
                
                

                    </div>
                    <!--end::Menu sub-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
               
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="menu-link px-5" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer;">
                            {{__('Sign Out')}}
                        </button>
                    </form>
                </div>
                
                <!--end::Menu item-->
            </div>
            <!--end::User account menu-->
            <!--end::Menu wrapper-->
        </div>
        <!--end::User menu-->
        <!--begin::Header menu toggle-->
        <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
            <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                <i class="ki-duotone ki-element-4 fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Header menu toggle-->
        <!--begin::Aside toggle-->
        <!--end::Header menu toggle-->
    </div>
    <!--end::Navbar-->
</div>