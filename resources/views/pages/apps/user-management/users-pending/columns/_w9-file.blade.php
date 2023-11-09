{{-- @if($user->status == 0)
    <span class="explore-label-pro">Pending</span>
@elseif($user->status == 1 && $user->email_verified_at == "")
    <span>Unverified email</span>
@endif --}}

@if ($user->w9Upload && count($user->w9Upload) > 0 )
   <a href="{{ route('county-provider-w9.w9_download', ['filename' => $user->w9Upload->first()?->original_name]) }}" class="btn btn-primary bnt-active-light-primary btn-sm">Download</a>

@endif
