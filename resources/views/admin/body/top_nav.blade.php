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
             

                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">

                    <div class="select">


                        <!--begin::Menu item-->
                      
                               
                        </div>



                        
                        
        
        
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
              
                <!--end::Search toggle-->
                <!--begin::Menu-->
              
                <!--end::Menu-->
            </div>
            <!--end::Search-->
        </div>
        <!--end::Search-->
  @include('admin.body.partials.notifcation')
        <!--end::My apps links-->
        
        <!--begin::User menu-->
 @include('admin.body.partials.user_nav')

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