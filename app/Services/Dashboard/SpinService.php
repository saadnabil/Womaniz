<?php
namespace App\Services\Dashboard;
use App\Helpers\FileHelper;
use App\Models\Admin;
use App\Models\ScratchGame;
use App\Models\SpinGame;
use Illuminate\Support\Facades\Hash;

class SpinService{

    public function spinInformation(): SpinGame{
        return SpinGame::where('country_id', auth()->user()->country_id )->first();
    }

    public function updateSpinInformation($data){
        $spingame = SpinGame::where('country_id', auth()->user()->country_id )->first();

        /**if spin game is not found create a new one*/
        if(!$spingame){
            $data['country_id'] = auth()->user()->country_id;
            SpinGame::create($data);
            return;
        }
        $spingame->update($data);
        return;
    }

}
