<x-default-layout>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.alert.css') }}">
    <div class="card p-15">
        <h1>Welcome to the CDA Supplemental Payment Dashboard</h1>
        <div class="mt-5">
            <div class="wrap-alert d-flex align-items-center">
                {!! getIcon('notification-bing','me-4') !!}
                <div class="content" style="width: 100%;">
                    <div class="title mb-2">This is an alert</div>
                    <div class="sub-title">The alert component can be used to highlight certain parts of your page for higher content visibility</div>
                </div>
                {!! getIcon('cross','fs-1 btn-alert') !!}
            </div>
            <br>
            <div class="wrap-alert success d-flex align-items-center">
                {!! getIcon('notification-bing','me-4') !!}
                <div class="content" style="width: 100%;">
                    <div class="title mb-2">This is an alert</div>
                    <div class="sub-title">The alert component can be used to highlight certain parts of your page for higher content visibility</div>
                </div>
                {!! getIcon('cross','fs-1 btn-alert') !!}
            </div>
            <br>
            <div class="wrap-alert error d-flex align-items-center">
                {!! getIcon('notification-bing','me-4') !!}
                <div class="content" style="width: 100%;">
                    <div class="title mb-2">This is an alert</div>
                    <div class="sub-title">The alert component can be used to highlight certain parts of your page for higher content visibility</div>
                </div>
                {!! getIcon('cross','fs-1 btn-alert') !!}
            </div>
            <br>
            <div class="wrap-alert info d-flex align-items-center">
                {!! getIcon('notification-bing','me-4') !!}
                <div class="content" style="width: 100%;">
                    <div class="title mb-2">This is an alert</div>
                    <div class="sub-title">The alert component can be used to highlight certain parts of your page for higher content visibility</div>
                </div>
                {!! getIcon('cross','fs-1 btn-alert') !!}
            </div>
        </div>
    </div>
    
</x-default-layout>
