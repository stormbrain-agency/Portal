<?php

namespace App\Http\Livewire\W9Provide;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\W9Upload;
use App\Models\User;
use App\Models\W9DownloadHistory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class ViewW9Provide extends Component
{
    use WithFileUploads;

    public $w9_id;
    public $file_name;
    public $comment;
    public $user_id;
    public $user_name;
    public $user_download_role;
    public $user_email;
    public $download_history = [];
    public $county_full;
    public $created_at;

    protected $listeners = [
        'view_w9' => 'viewW9Provide',
    ];


    public function render()
    {
        return view('livewire.w9-provide.view-w9-provide');
    }

    public function viewW9Provide($id){
        $w9_upload = W9Upload::find($id);
        if (isset($w9_upload)) {
            $this->w9_id = $w9_upload->id;
            $this->month_year = $w9_upload->month_year;
            $this->comment = $w9_upload->comments;
            $this->user_name = $w9_upload->user->first_name . ' ' . $w9_upload->user->last_name;
            $this->user_id = $w9_upload->user->id;
            $this->user_email = $w9_upload->user->email;
            $this->county_full = $w9_upload->county?->county;
            $this->file_name = $w9_upload->original_name;
            $this->created_at = $w9_upload->created_at;

            $this->download_history = W9DownloadHistory::where("w9_id", $id)->orderBy('id', 'desc')->get();
        }
    }
}
