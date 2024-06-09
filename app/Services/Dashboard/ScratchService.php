<?php
namespace App\Services\Dashboard;

use App\Helpers\FileHelper;
use App\Models\Admin;
use App\Models\ScratchGame;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorWorkCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ScratchService{

    public function scratchInformation(): ScratchGame{
        $user = auth()->user();
        $scratch = ScratchGame::where([
                                  'country_id' => $user->country_id,
                                  'date' => Carbon::today(),
                                ])->first();
        return $scratch;
    }
    public function updateDiscountValue($data){
        $user = auth()->user();
        $user = $user->load('country');
        $scratch_discount = json_decode(setting('scratch_discount'),true);
        $scratch_discount[$user->country->country] =  $data['scratch_discount'];
        $scratch_discount = json_encode($scratch_discount);
        setting(['scratch_discount' => $scratch_discount]);
        setting()->save();
        return;
    }

}
