<div class="d-flex justify-content-center row " style="width: 180px">
    <select id="county-filter" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option">
        <option value="default">County</option>
        @if (isset($counties) && count($counties) > 0)
            @foreach ($counties as $county)
                <option value="{{$county->county_fips}}">{{$county->county}}</option>
            @endforeach
        @endif
    </select>
</div>
