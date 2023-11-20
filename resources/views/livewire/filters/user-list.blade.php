<div class="d-flex justify-content-center row " style="width: 180px">
    <select id="user-filter" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option">
        <option value="default">User</option>
        @if (isset($users_filter) && count($users_filter) > 0)
            @foreach ($users_filter as $user)
                <option value="{{$user->first_name}}">{{$user->first_name}} {{$user->last_name}}</option>
            @endforeach
        @endif
    </select>
</div>