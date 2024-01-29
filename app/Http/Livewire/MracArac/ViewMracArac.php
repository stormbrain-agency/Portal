<?php

namespace App\Http\Livewire\MracArac;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\MracArac;
use App\Models\User;
use App\Models\MracAracFiles;
use App\Models\MracAracDownloadHistory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class ViewMracArac extends Component
{
    use WithFileUploads; 

    public $mrac_arac_id;
    public $year;
    public $comment;
    public $month_year;
    public $user_id;
    public $user_name;
    public $user_download_role;
    public $user_email;
    public $mrac_arac_files = [];
    public $download_history = [];
    public $county_full;
    public $created_at;

    protected $listeners = [
        'view_mrac_arac' => 'viewMracArac',
        'triggerDownloadAllFiles' => 'downloadAllFiles',
        'triggerDownloadAllFilesBtn' => 'downloadAllFilesBtn',
    ];
    

    public function render()
    {
        return view('livewire.mrac-arac.view-mrac-arac');
    }

    public function viewMracArac($id){
        $mrac_arac = MracArac::find($id);

        if (isset($mrac_arac)) {
            $this->mrac_arac_id = $mrac_arac->id;
            $this->month_year = $mrac_arac->month_year;
            $this->comment = $mrac_arac->comments;
            $this->user_name = $mrac_arac->user->first_name . ' ' . $mrac_arac->user->last_name;
            $this->user_id = $mrac_arac->user->id;
            $this->user_email = $mrac_arac->user->email;
            $this->county_full = $mrac_arac->county?->county;
            $this->created_at = $mrac_arac->created_at;
    
            $this->mrac_arac_files = MracAracFiles::where("mrac_arac_id", $id)->get();
            $this->download_history = MracAracDownloadHistory::where("mrac_arac_id", $id)->orderBy('id', 'desc')->get();
        }
    }

    public function downloadAllFiles()
    {
        $user_id = Auth::id();

        if ($user_id) {
            
            $mrac_arac_files = MracAracFiles::where("mrac_arac_id", $this->mrac_arac_id)->get();
            if ($mrac_arac_files->isNotEmpty()) {
                
                $downloadUrls = [];

                foreach ($mrac_arac_files as $mrac_arac_file) {
                    $filename = $mrac_arac_file->file_path;
                    $file = storage_path('app/uploads/mrac_arac/' . $filename);

                    if (file_exists($file)) {
                        $downloadUrls [] = route('county-mrac-arac.download', ['filename' => $filename]);
                    }else {
                        $this->emit('error', __('Could not find ' .$filename. ' file to download.'));
                    }
                }

                if (!empty($downloadUrls)) {
                    MracAracDownloadHistory::create([
                        'mrac_arac_id' => $this->mrac_arac_id,
                        'user_id' => $user_id,
                    ]);
                    $this->emit('downloadAllFiles', $downloadUrls);
        
                }
            } else {
                $this->emit('error', __('No files to download.'));

            }
        } else {
            $this->emit('error', __('User not logged in.'));

        }
    }

    public function downloadAllFilesBtn($id)
    {
        $user_id = Auth::id();

        if ($user_id) {
            
            $mrac_arac_files = MracAracFiles::where("mrac_arac_id", $id)->get();
            if ($mrac_arac_files->isNotEmpty()) {
                
                $downloadUrls = [];

                foreach ($mrac_arac_files as $mrac_arac_file) {
                    $filename = $mrac_arac_file->file_path;
                    $file = storage_path('app/uploads/mrac_arac/' . $filename);

                    if (file_exists($file)) {
                        $downloadUrls [] = route('county-mrac-arac.download', ['filename' => $filename]);
                    }else {
                        $this->emit('error', __('Could not find ' .$filename. ' file to download.'));
                    }
                }

                if (!empty($downloadUrls)) {
                    MracAracDownloadHistory::create([
                        'mrac_arac_id' => $id,
                        'user_id' => $user_id,
                    ]);
                    $this->emit('downloadAllFiles', $downloadUrls);
        
                }
            } else {
                $this->emit('error', __('No files to download.'));

            }
        } else {
            $this->emit('error', __('User not logged in.'));

        }
    }

}
