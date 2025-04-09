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
                    <img alt="Logo" src="{{ auth()->user()->photo ? asset('/upload/admin_images/' . auth()->user()->photo) : asset('assets/avatar.png') }}">                        </div>
                <!--end::Avatar-->
                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">{{auth()->user()->name}}
                  </div>
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