<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DeleteValidation;
use App\Http\Requests\Dashboard\VendorFormValidation;
use App\Http\Resources\Dashboard\UserResource;
use App\Http\Resources\Dashboard\VendorResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Vendor;
use App\Models\VendorWorkCategory;
use Illuminate\Support\Facades\Hash;

class VendorsController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $vendors = Vendor::with('categories')->where('country_id', auth()->user()->country_id)->latest()->simplepaginate();
        return $this->sendResponse(resource_collection(VendorResource::collection($vendors)));
    }
    public function store(VendorFormValidation $request){
        $data = $request->validated();
        $workCategories = $data['categories'];
        unset($data['categories']);
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('vendors', $data['image']);
        }
        $data['password'] = Hash::make($data['password']);
        $data['country_id'] = auth()->user()->country_id;
        $vendor = Vendor::create($data);
        foreach($workCategories as $category){
            VendorWorkCategory::create([
                'category_id' => $category,
                'vendor_id' => $vendor->id
            ]);
        }
        return $this->sendResponse([], 'success' , 200);
    }

    public function delete(DeleteValidation $request){
        $data = $request->validated();
        $images = Vendor::whereIn('id',$data['ids'])->pluck('image')->toarray();
        Vendor::whereIn('id',$data['ids'])->delete();
        FileHelper::delete_files($images);
        return $this->sendResponse([], 'success' , 200);
    }

    public function show(Vendor $vendor){
        $vendor->load('categories');
        return $this->sendResponse(new VendorResource($vendor));
    }

    public function fulldataexport(){
        $vendors = Vendor::with('categories')->where('country_id', auth()->user()->country_id)->latest()->get();
        return $this->sendResponse(VendorResource::collection($vendors));
    }

}




