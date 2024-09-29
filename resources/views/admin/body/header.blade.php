<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('locale') == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <title>
        @php
        $configuration = \App\Models\Configuration::first();
        @endphp
        {{$configuration->owner_name}}
    </title>
    
    <base href="{{ asset('../../../') }}"/>
    <link rel="shortcut icon" href="{{ asset('storage/' . $configuration->logo) }}"/>
    
    @if(Session('locale') == 'ar') 
        <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css">
        <style>html, body { font-family: cairo; }</style>
    @else
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css">
    @endif
    
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    @yield('css')
</head>