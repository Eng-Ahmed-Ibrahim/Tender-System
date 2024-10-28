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
            <a class="menu-link" href="">
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


<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Employees')}}</span>
    </div>
    <!--end:Menu content-->
</div>



                     
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-people-fill"></i> <!-- Customers icon -->

        </span>
        <span class="menu-title">{{ __('Employees')}}</span>
        <span class="menu-arrow"></span>
    </span>

    <div class="menu-sub menu-sub-accordion">
     

 


        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{ route('AdminUsers.index') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ __('Employees')}}</span>
            </a>
        </div>


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
        <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Company')}}</span>
    </div>
    <!--end:Menu content-->
</div>
<!--end:Menu item-->
<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link" href="{{ route('companies.index')}}" >
        <span class="menu-icon">
            <i class="ki-duotone ki-rocket fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </span>
        <span class="menu-title">{{__('Company')}}</span>
    </a>
    <!--end:Menu link-->
</div>


<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Tenders')}}</span>
    </div>
    <!--end:Menu content-->
</div>
<!--end:Menu item-->
<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link" href="{{ route('tenders.index')}}" >
        <span class="menu-icon">
            <i class="ki-duotone ki-rocket fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </span>
        <span class="menu-title">{{__('Tenders')}}</span>
    </a>
    <!--end:Menu link-->
</div>



<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Applicants')}}</span>
    </div>
    <!--end:Menu content-->
</div>
<!--end:Menu item-->
<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link" href="{{ route('Applicants.index')}}" >
        <span class="menu-icon">
            <i class="ki-duotone ki-rocket fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </span>
        <span class="menu-title">{{__('Applicants')}}</span>
    </a>
    <!--end:Menu link-->
</div>
<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Notification')}}</span>
    </div>
    <!--end:Menu content-->
</div>
<!--end:Menu item-->
<!--begin:Menu item-->
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link" href="{{ route('notifications.index')}}" >
        <span class="menu-icon">
            <i class="ki-duotone ki-rocket fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </span>
        <span class="menu-title">{{__('all notification')}}</span>
    </a>
    <!--end:Menu link-->
</div>
<div class="menu-item">
    <!--begin:Menu link-->
    <a class="menu-link" href="{{ route('notifications.create')}}" >
        <span class="menu-icon">
            <i class="ki-duotone ki-rocket fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </span>
        <span class="menu-title">{{__('send notifcation')}}</span>
    </a>
    <!--end:Menu link-->
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
    <a class="menu-link" href="{{route('configurations.index')}}" >
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