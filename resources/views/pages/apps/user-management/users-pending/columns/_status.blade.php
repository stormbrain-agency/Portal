@if($user->status == 0)
    <span class="explore-label-pro">Pending</span>
@elseif($user->status == 2)
    <span>Denied</span>
@elseif($user->status == 1 && $user->email_verified_at == "")
    <span>Unverified email</span>
@endif
