@if($user->status == 0)
    <span class="text-warning">Approval Needed</span>
@elseif($user->status == 2)
    <span class="text-danger">Declined</span>
@elseif($user->status == 1)
    <span class="text-primary">Approved</span>
@elseif($user->status == 3)
    <span class="text-disabled-status">Disabled</span>
@endif
