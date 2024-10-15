<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Dashboard')}}</span>
    </div>
    <!--end:Menu content-->
</div>



                     
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-people-fill"></i> <!-- Customers icon -->

        </span>
        <span class="menu-title">{{ __('Dashboard')}}</span>
        <span class="menu-arrow"></span>
    </span>

    <div class="menu-sub menu-sub-accordion">
     

 


        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{route('company.dashboard')}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ __('Dashboard')}}</span>
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
            <i class="bi bi-people-fill"></i> <!-- Customers icon -->

        </span>
        <span class="menu-title">{{ __('Tenders')}}</span>
        <span class="menu-arrow"></span>
    </span>

    <div class="menu-sub menu-sub-accordion">
     

 


        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{ route('tenders.index') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ __('Tenders')}}</span>
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
