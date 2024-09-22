@extends('admin.index')
@section('content')
<div class="card card-xl-stretch mb-5 mb-xl-12">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">{{__('Countries')}}</span>
        </h3>
    
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">

        <div class="tab-content">
            <!--begin::Tap pane-->

            <div class="tab-pane fade show active" id="kt_table_widget_4_tab_1">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle gs-0 gy-3">
                        <!--begin::Table head-->
                        <thead>
                            <tr>
                                <th class="p-0 w-50px"></th>
                                <th class="p-0 min-w-150px"></th>
                                <th class="p-0 min-w-140px"></th>
                                <th class="p-0 min-w-120px"></th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>

                            @foreach($models as $country)
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/flags/{{strtolower($country->name)}}.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{__($country->name)}}</a>
                                    <span class="text-muted fw-semibold d-block fs-7">{{$country->code}}</span>
                                </td>
                             
                            </tr>
                          @endforeach

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    {{$models->links()}}

                </div>
                <!--end::Table-->
            </div>
            <!--end::Tap pane-->
            <!--begin::Tap pane-->
            <div class="tab-pane fade" id="kt_table_widget_4_tab_2">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle gs-0 gy-3">
                        <!--begin::Table head-->
                        <thead>
                            <tr>
                                <th class="p-0 w-50px"></th>
                                <th class="p-0 min-w-150px"></th>
                                <th class="p-0 min-w-140px"></th>
                                <th class="p-0 min-w-120px"></th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/043-boy-18.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Kevin Leonard</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Art Director</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/014-girl-7.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Natali Trump</a>
                                    <span class="text-muted fw-semibold d-block fs-7">UI/UX Designer</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/018-girl-9.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Jessie Clarcson</a>
                                    <span class="text-muted fw-semibold d-block fs-7">HTML, CSS Coding</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/001-boy.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Brad Simmons</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Movie Creator</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Tap pane-->
            <!--begin::Tap pane-->
            <div class="tab-pane fade" id="kt_table_widget_4_tab_3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle gs-0 gy-3">
                        <!--begin::Table head-->
                        <thead>
                            <tr>
                                <th class="p-0 w-50px"></th>
                                <th class="p-0 min-w-150px"></th>
                                <th class="p-0 min-w-140px"></th>
                                <th class="p-0 min-w-120px"></th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/018-girl-9.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Jessie Clarcson</a>
                                    <span class="text-muted fw-semibold d-block fs-7">HTML, CSS Coding</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/047-girl-25.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Lebron Wayde</a>
                                    <span class="text-muted fw-semibold d-block fs-7">ReactJS Developer</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px">
                                        <img src="assets/media/svg/avatars/014-girl-7.svg" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Natali Trump</a>
                                    <span class="text-muted fw-semibold d-block fs-7">UI/UX Designer</span>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold d-block fs-7">Rating</span>
                                    <div class="rating">
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <div class="rating-label checked">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-icon btn-light-twitter btn-sm me-3">
                                        <i class="ki-duotone ki-twitter fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light-facebook btn-sm">
                                        <i class="ki-duotone ki-facebook fs-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Tap pane-->
        </div>
    </div>
    <!--end::Body-->
</div>


@endsection