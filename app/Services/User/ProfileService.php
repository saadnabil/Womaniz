<?php
namespace App\Services\User;
use App\Http\Traits\ApiResponseTrait;
use App\Models\AccountDeleteHistory;
use Illuminate\Support\Facades\Hash;

class ProfileService{
    use ApiResponseTrait;

    public function deleteAccount($data){
        $user = auth()->user();
        // Check if the old password matches the user's current password
        if (!Hash::check($data['password'], $user->password)) {
            return $this->sendResponse(['error' => __('messages.Invalid password')], 'fail' , 422);
        }

        /**store delete history */
        unset($data['password']);
        $data['user_id'] = auth()->user()->id;
        AccountDeleteHistory::create($data);
        $user->delete();
        return;
    }



}

