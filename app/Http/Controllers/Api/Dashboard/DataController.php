<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Dashboard\AdminResource;
use App\Http\Resources\Dashboard\VendorCategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $data['countries'] = Country::get();
        $data['adminJobs'] = [
            [
                'id' => 1,
                'title' =>  'Accounts’ management',
            ],
            [
                'id' => 2,
                'title' =>  'Products’ (Clothes, Cosmetics) management',
            ],
            [
                'id' => 3,
                'title' =>  'Jewellery’s management',
            ],
            [
                'id' => 4,
                'title' =>  'Salons’ management',
            ],
            [
                'id' => 5,
                'title' =>  'Orders and Discounts’ management',
            ],
        ];
        $categories = Category::where([
            'parent_id' => null,
            'type' => 'app_category'
        ])->get();
        $data['maincategories'] = VendorCategoryResource::collection($categories);
        return $this->sendResponse($data);
    }

    public function cities(){
        $country = auth()->user()->country->load('cities');
        return $this->sendResponse($country->cities);
    }

    public function policy(){
        $lang = app()->getLocale();
        $policy = json_decode(setting('policy') , true);
        return $this->sendResponse([
            'policy' => $policy[$lang],
        ]);
    }

    public function security(){
        $lang = app()->getLocale();
        $policy = json_decode(setting('security') , true);
        return $this->sendResponse([
            'security' => $policy[$lang],
        ]);
    }
}
