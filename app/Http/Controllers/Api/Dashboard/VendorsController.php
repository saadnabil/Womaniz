<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChangeStatusValidation;
use App\Http\Requests\Dashboard\DeleteValidation;
use App\Http\Requests\Dashboard\VendorAddBrandValidation;
use App\Http\Requests\Dashboard\VendorFormValidation;
use App\Http\Resources\Dashboard\VendorResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Vendor;
use App\Models\vendorWorkBrand;
use App\Models\VendorWorkCategory;
use App\Services\Dashboard\VendorService;
use Illuminate\Support\Facades\Hash;

class VendorsController extends Controller
{
    use ApiResponseTrait;
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
        $this->middleware('permission:vendor-list', ['only' => ['index']]);
        $this->middleware('permission:vendor-create', ['only' => ['store']]);
        $this->middleware('permission:vendor-edit', ['only' => ['update']]);
        $this->middleware('permission:vendor-show', ['only' => ['show']]);
        $this->middleware('permission:vendor-delete', ['only' => ['delete']]);
        $this->middleware('permission:vendor-export', ['only' => ['fulldataexport']]);
        $this->middleware('permission:vendor-change-status', ['only' => ['switchstatus']]);
    }

    public function index(){
        $search = request()->has('search') ? request('search') : null;
        $status = request()->has('status') ? request('status') : null;
        $categories = request()->has('categories') ? request('categories') : null;
        $vendors = $this->vendorService->listWithSearch($search, $status , $categories);
        return $this->sendResponse(resource_collection(VendorResource::collection($vendors)));
    }

    public function store(VendorFormValidation $request){
        $data = $request->validated();
        $this->vendorService->createVendor($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function update(VendorFormValidation $request, Vendor $vendor){
        $data = $request->validated();
        $this->vendorService->updateVendor($data, $vendor);
        return $this->sendResponse([], 'success' , 200);
    }

    public function delete(DeleteValidation $request){
        $data = $request->validated();
        $this->vendorService->deleteVendors($data);
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

    public function switchstatus(ChangeStatusValidation $request, Vendor $vendor){
        $data = $request->validated();
        $vendor->update([
            'status' =>  $data['status'],
        ]);
        return $this->sendResponse([]);
    }

    public function addbrand(VendorAddBrandValidation $request){
        $data = $request->validated();
        vendorWorkBrand::firstOrCreate($data);
        return $this->sendResponse([]);
    }

}




