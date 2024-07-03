<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AccountRestoreRequestChangeStatusValidation;
use App\Http\Traits\ApiResponseTrait;
use App\Models\RestoreAccountRequest;


class RestoreRequestController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('permission:spin-game-information', ['only' => ['spinInformation']]);
        $this->middleware('permission:spin-game-information-update', ['only' => ['spinInformationUpdate']]);
    }

    public function changeStatus(AccountRestoreRequestChangeStatusValidation $request , RestoreAccountRequest $restoreAccountRequest){
        $data = $request->validated();
        if($restoreAccountRequest->status == 'pending'){
            $statusMappingArray = [
                0 => 'rejected',
                1 => 'accepted'
            ];
            $restoreAccountRequest->update([
                'status' =>  $statusMappingArray[$data['status']],
                'rejection_reason' => $data['rejection_reason'] ?? null,
            ]);
        }
        return $this->sendResponse([]);
    }

}
