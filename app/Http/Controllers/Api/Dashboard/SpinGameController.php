<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateScratchDiscountValue;
use App\Http\Requests\Dashboard\UpdateSpinInformation;
use App\Http\Resources\Dashboard\ScratchGameResource;
use App\Http\Resources\Dashboard\SpinGameResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\ScratchGame;
use App\Models\SpinGame;
use App\Services\Dashboard\ScratchService;
use App\Services\Dashboard\SpinService;
use Carbon\Carbon;

class SpinGameController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('permission:spin-game-information', ['only' => ['spinInformation']]);
        $this->middleware('permission:spin-game-information-update', ['only' => ['spinInformationUpdate']]);
    }

    public function spinInformation(SpinService $spinService){
        $spingame = $spinService->spinInformation();
        return $this->sendResponse(new SpinGameResource($spingame));
    }

    public function spinInformationUpdate(UpdateSpinInformation $request, SpinService $spinService){
        $data = $request->validated();
        $spinService->updateSpinInformation($data);
        return $this->sendResponse([]);
    }
}
