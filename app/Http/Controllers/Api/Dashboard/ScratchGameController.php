<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateScratchDiscountValue;
use App\Http\Resources\Dashboard\ScratchGameResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\ScratchGame;
use App\Services\Dashboard\ScratchService;
use Carbon\Carbon;

class ScratchGameController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('permission:scratch-game-information', ['only' => ['scratchInformation']]);
        $this->middleware('permission:scratch-game-information-update', ['only' => ['updateDiscountValue']]);
    }

    public function scratchInformation(ScratchService $scratchService){
        $scratchInformation = $scratchService->scratchInformation();
        return $this->sendResponse(new ScratchGameResource($scratchInformation));
    }

    public function updateDiscountValue(UpdateScratchDiscountValue $request, ScratchService $scratchService){
        $data = $request->validated();
        $scratchService->updateDiscountValue($data);
        return $this->sendResponse([]);
    }

}
