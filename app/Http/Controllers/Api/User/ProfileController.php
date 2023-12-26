<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddLocationValidation;
use App\Http\Requests\Api\User\UpdateProfileValidation;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    use ApiResponseTrait;

    public function index(){
        $user = auth()->user();
        return $this->sendResponse(new UserResource($user));
    }

    public function update(UpdateProfileValidation $request ){
        $data = $request->validated();
        $user = auth()->user();
        $user->update($data);
        return $this->sendResponse([]);
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


    public function addlocation(AddLocationValidation $request){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        Address::create($data);
        return $this->sendResponse([]);
    }

}
