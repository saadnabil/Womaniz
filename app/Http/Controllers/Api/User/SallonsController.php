<?php
namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
class SallonsController extends Controller
{
    use ApiResponseTrait;
    public function branches($salon){
        $salon->load('branches');
        return response()
    }
}
