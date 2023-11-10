@if ($user->w9Upload && count($user->w9Upload) > 0 )
   <a href="{{ route('county-provider-w9.w9_download', ['filename' => $user->w9Upload->first()?->original_name]) }}" class="btn btn-primary bnt-active-light-primary btn-sm">Download</a>
@endif
