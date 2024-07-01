<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AccountRestoreRequestChangeStatusValidation;
use App\Http\Requests\Dashboard\UpdateScratchDiscountValue;
use App\Http\Requests\Dashboard\UpdateSpinInformation;
use App\Http\Resources\Dashboard\ScratchGameResource;
use App\Http\Resources\Dashboard\SpinGameResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\RestoreAccountRequest;
use App\Models\ScratchGame;
use App\Models\SpinGame;
use App\Services\Dashboard\ScratchService;
use App\Services\Dashboard\SpinService;
use Carbon\Carbon;

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
                0 => 'rejected' ,
                1 => 'accepted'
            ];
            $restoreAccountRequest->update([
                'status' =>  $statusMappingArray[$data['status']],
            ]);
        }
        return $this->sendResponse([]);
    }

}
