<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    use ApiResponseTrait;
    public function index(){
        $banners = [];
        $foryou = [];
        $hcBanner = [];
        $brands = [];
        $forYouBanner = [];
        $cosmeticsBanner = [];
        $beautySallonServices = [];
        $celebrityBanner = [];
        $data = [];
        return $this->sendResponse($data);
    }
}
