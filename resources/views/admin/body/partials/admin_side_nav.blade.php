@can('Dashboard.view')
<div class="menu-item pt-5">
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Dashboard')}}</span>
    </div>
</div>
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-speedometer2"></i>
        </span>
        <span class="menu-title">{{ __('Dashboard')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('admin.dashboard')}}">
                <span class="menu-bullet">
                    <i class="bi bi-graph-up-arrow fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{ __('Overview')}}</span>
            </a>
        </div>
        
    </div>
</div>

@endcan

<div class="menu-item pt-5">
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Employees')}}</span>
    </div>
</div>
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-person-badge-fill"></i>
        </span>
        <span class="menu-title">{{ __('Employees')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('AdminUsers.index') }}">
                <span class="menu-bullet">
                    <i class="bi bi-people fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{ __('All Employees')}}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{ route('AdminUsers.create') }}">
                <span class="menu-bullet">
                    <i class="bi bi-person-plus-fill fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{ __('Add Employee')}}</span>
            </a>
        </div>
    </div>
</div>
<!-- Roles and Permissions Section -->
<div class="menu-item pt-5">
    <div class="menu-content">
        <span class="menu-heading fw-bold text-uppercase fs-7">{{__('Roles And Permissions')}}</span>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </span>
        <span class="menu-title">{{__('Access Management')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{route('role.create')}}">
                <span class="menu-bullet">
                    <i class="bi bi-person-gear fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('All Roles')}}</span>
            </a>
        </div>
       
        
    </div>
</div>

@can('company.view')
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-building-fill"></i>
        </span>
        <span class="menu-title">{{__('Company')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('companies.index')}}">
                <span class="menu-bullet">
                    <i class="bi bi-buildings fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('All Companies')}}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{ route('companies.create')}}">
                <span class="menu-bullet">
                    <i class="bi bi-building-add fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('Add Company')}}</span>
            </a>
        </div>
    </div>
</div>
@endcan
@can('tender.view')
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-file-earmark-text-fill"></i>
        </span>
        <span class="menu-title">{{__('Tenders')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('tenders.index')}}">
                <span class="menu-bullet">
                    <i class="bi bi-files fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('All Tenders')}}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{ route('tenders.create')}}">
                <span class="menu-bullet">
                    <i class="bi bi-file-earmark-plus fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('Create Tender')}}</span>
            </a>
        </div>
        
    </div>
</div>

@endcan
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-people-fill"></i>
        </span>
        <span class="menu-title">{{__('users')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('applicants.users')}}">
                <span class="menu-bullet"> 
                    <i class="bi bi-person-lines-fill fs-6 me-2"></i> 
                </span> 
                <span class="menu-title">{{__('All users')}}</span>
            </a>
        </div>
  
    </div>
</div> 

@can('applicant.view')
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-people-fill"></i>
        </span>
        <span class="menu-title">{{__('Applicants')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('Applicants.index')}}">
                <span class="menu-bullet">
                    <i class="bi bi-person-lines-fill fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('All Applicants')}}</span>
            </a>
        </div>

    </div>
</div> 
@endcan 
@can('notifcation.view')
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-bell-fill"></i>
        </span>
        <span class="menu-title">{{__('Notifications')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('notifications.index')}}">
                <span class="menu-bullet">
                    <i class="bi bi-inbox-fill fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('All Notifications')}}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{ route('notifications.create')}}">
                <span class="menu-bullet">
                    <i class="bi bi-send-fill fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('Send Notification')}}</span>
            </a>
        </div>
     
    </div>
</div>
@endcan
@can('configuration')
<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-gear-fill"></i>
        </span>
        <span class="menu-title">{{__('Configuration')}}</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="{{route('configurations.index')}}">
                <span class="menu-bullet">
                    <i class="bi bi-sliders fs-6 me-2"></i>
                </span>
                <span class="menu-title">{{__('General Settings')}}</span>
            </a>
        </div>
     
    </div>
</div>
@endcan