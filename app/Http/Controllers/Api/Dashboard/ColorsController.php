<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\ColorResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Color;
use Illuminate\Http\Request;
class ColorsController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request){
        $colors = Color::latest()->get();
        return $this->sendResponse(ColorResource::collection($colors));
    }
}
