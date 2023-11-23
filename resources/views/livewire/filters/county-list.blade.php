<div class="d-flex justify-content-center" style="width: 150px">
    <select id="county-filter" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option">
        <option value="default">All County</option>
        @if (isset($counties) && count($counties) > 0)
            @foreach ($counties as $county)
                <option value="{{$county->county_fips}}">{{$county->county}}</option>
            @endforeach
        @endif
    </select>
</div>
