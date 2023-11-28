<x-default-layout>
    <div class="page-profile">
        <div class="card">
           <div class="wrap-top d-flex justify-content-between align-items-center">
                <a class="d-flex align-items-center" href="{{ url('/profile/details') }}">
                    {!! getIcon('arrow-left', 'fs-1') !!}
                    <span class="text">Profile Details</span>    
                </a>
                <a class="btn_edit-profile m-0" href="{{ url('/profile/details') }}">Edit Profile</a>
            </div>
            <div class="wrap-content">
                <table class="table table-borderless m-0">
                    <tbody>
                        <tr>
                            <th scope="row">Full Name</th>
                            <td>{{$user->first_name . ' '  . $user->last_name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Username</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Contact Phone</th>
                            <td>{{ $user->mobile_phone }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            @if( $user->status )
                                <td class="status">Active</td>
                            @else
                                <td class="status off">Inactive</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-default-layout>