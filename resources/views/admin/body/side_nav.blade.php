	<!--begin::Wrapper-->
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <!--begin::Sidebar-->
        <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
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
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Customers')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                        
                 
                    
                                                 
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="bi bi-people-fill"></i> <!-- Customers icon -->

                                    </span>
                                    <span class="menu-title">{{ __('Customers')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    @if(auth()->user()->can('create.customers'))

                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('customers.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ __('Create customer')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                                    @endif

                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('customers.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ __('All customers')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                             
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                         
                        
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Categories')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                        
                 
                    
                                                 
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-list-alt"></i> <!-- Categories icon -->

                                    </span>
                                    <span class="menu-title">{{ __('Categories')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('categories.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ __('Main categories')}} </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
              
                                   

                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>

                    
                                                 
                      


 

                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('ADS')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                        
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-bullhorn"></i> 
                                    </span>
                                    <span class="menu-title">{{ __('Normal ADs')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                          
                        
                                  
                                    <!--end:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('normalads.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">  {{ __('Normal Ads')}} </span>
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
                                        <i class="fas fa-bullhorn"></i> <!-- Commercial Ads icon -->

                                    </span>
                                    <span class="menu-title">{{ __('Commercial')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                            

                        
                               
                                    <!--end:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('commercialads.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ __('Commercial')}} </span>
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
                                        <i class="fas fa-window-restore"></i> <!-- Popup Ads icon -->

                                    </span>
                                    <span class="menu-title">{{ __('Popups')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                            

                        
                                    <!--end:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('popup.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ __('popup')}}</span>
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
                                        <i class="fas fa-ad"></i> 
                                    </span>
                                    <span class="menu-title">{{ __('Banners')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                            
                                <div class="menu-sub menu-sub-accordion">
                                 
                                  
                        
                          
      <!--end:Menu item-->
      <div class="menu-item">
        <!--begin:Menu link-->
        <a class="menu-link" href="{{ route('banners.index')}}">
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
            <span class="menu-title"> {{ __('Banners')}} </span>
        </a>
        <!--end:Menu link-->
    </div>


                          
                           
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Modules')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                        
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-car"></i>
                                    </span>
                                    <span class="menu-title">{{__('Cars')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                            
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->



                               
                             
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('car-features.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('show Features')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('car-brands.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('show brands')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('car.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> {{__('cars Normal')}}</span>
                                        </a>
                                    </div>    
                                  
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('car.commercial')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> {{__('cars Commercial')}}</span>
                                        </a>
                                    </div>    
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-bicycle"></i> <!-- Bike icon -->

                                    </span>
                                    <span class="menu-title">{{__('Bikes')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                            
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->




                                    
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('bike-features.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('show Features')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                             
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('bike.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> {{__('bikes Normal')}} </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                                  
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('bike.commercial')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> {{__('bikes Commercial')}} </span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>

                             
                                                      </div>
                                <!--end:Menu sub-->
                            </div>

                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-house"></i> <!-- This adds a solid house icon -->

                                    </span>
                                    <span class="menu-title">{{__('Houses')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                            
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->



                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('house-features.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('features managments')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                   
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('house.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Normal house')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('House.commercial')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Commercial house')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                 
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>

                            
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-tv"></i> <!-- Electronics -->
                                    </span>
                                    <span class="menu-title">{{__('Electronics')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                               
                    

                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('mobile-normalAds.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Mobiles Normals')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                                                                               
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('Mobiles.commercial')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Mobiles Commercials')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                            </div>
                                <!--end:Menu sub-->
                            </div>
                            
                            
                            
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-briefcase"></i>                                     </span>
                                    <span class="menu-title">{{__('Careers')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                
                                   

                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('career.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Career')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                               
                                             
                                                </div>
                                <!--end:Menu sub-->
                            </div>
                            
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Countries')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                       
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <span class="menu-title">{{__('Countries')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                            
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('countries.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Add Country')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('countries.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('All country')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>

                               
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Repesntative')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                       
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <span class="menu-title">{{__('Repesntative')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                            
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('representative.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Add representative')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{ route('representative.index')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('All representative')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>


                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Roles And Permissions')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                       
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <span class="menu-title">{{__('Roles')}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                            
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{route('role.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title"> {{__('Roles')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                   

                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href=" {{ route('AdminUsers.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Users')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link" href="{{route('permissions.create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{__('Permissions')}}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Configuration')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{route('configurations.index')}}" target="_blank">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-rocket fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">{{__('configurations')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>



                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Reports')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->dsdsd
                                <a class="menu-link" href="" target="_blank">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-rocket fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">{{__('reports')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <div class="menu-item pt-5">
                                <!--begin:Menu content-->
                                <div class="menu-content">
                                    <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Subscriptions')}}</span>
                                </div>
                                <!--end:Menu content-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{route('subscriptions.index')}}" target="_blank">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-rocket fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">{{__('Subscriptions')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{route('subscriptions.create')}}" target="_blank">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-rocket fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">{{__('Create plan')}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                         
                            <!--end:Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Scroll wrapper-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::sidebar menu-->