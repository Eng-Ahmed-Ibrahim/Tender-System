	<!--begin::Wrapper-->
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <!--begin::Sidebar-->
        <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle" style="background-color: #0a4d62;">
            <!--begin::Logo-->
            <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                <!--begin::Logo image-->
                <a href="">

                    @php

                    $configuration =\App\Models\Configuration::first();
                    @endphp
                    <img alt="Logo" src="{{ asset('storage/' .$configuration->logo) }}" class="h-50px app-sidebar-logo-default" />
                </a>

                <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                    <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Sidebar toggle-->
            </div>
            <!--end::Logo-->
            <!--begin::sidebar menu-->
            <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                <!--begin::Menu wrapper-->
                <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                    <!--begin::Scroll wrapper-->
                    <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                               
                            </div>
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">Dashboards</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                        
                 
                    
                                                 
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-element-7 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">View </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                        
                                   

                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>

                
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-element-7 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Subscription</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route ('customers.subscriptions')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">View </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                        
                                   

                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>

                         
                               
                                <!--begin:Menu sub-->
                         
                            <!--end:Menu item-->
                        </div>
                        <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                               
                            </div>
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7"> Ads</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                        
                 
                    
                                                 
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-element-7 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Normal Ads</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('ads.customer.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">add normal </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                        
                                   

                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                                 
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-element-7 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Commercial Ads</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('commercial.customer.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">add Comercial </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('commercial.customer.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> Comercial </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                        
                                   

                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-element-7 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">My Ads</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('normal.customer.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> Normal </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                        
                                   

                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                        
                         
                               
                                <!--begin:Menu sub-->
                         
                            <!--end:Menu item-->
                        </div>                    </div>
                    <!--end::Scroll wrapper-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::sidebar menu-->