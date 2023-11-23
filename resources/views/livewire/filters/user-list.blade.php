<div style="width: 150px">
    <select id="user-filter" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option">
        <option value="0">All User</option>
        @if (isset($users_filter) && count($users_filter) > 0)
            @foreach ($users_filter as $user)
                <option value="{{$user->email}}">{{$user->first_name}} {{$user->last_name}}</option>
            @endforeach
        @endif
    </select>
</div>