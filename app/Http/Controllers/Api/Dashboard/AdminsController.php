<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminFormValidation;
use App\Http\Requests\Dashboard\ChangeStatusValidation;
use App\Http\Requests\Dashboard\DeleteValidation;
use App\Http\Resources\Dashboard\AdminResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Admin;
use App\Services\Dashboard\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminsController extends Controller
{
    use ApiResponseTrait;

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(){
        $search = request()->has('search') ? request('search') : null;
        $status = request()->has('status') ? request('status') : null;
        $admins = $this->adminService->listWithSearch($search, $status);
        return $this->sendResponse(resource_collection(AdminResource::collection($admins)));
    }

    public function show(Admin $admin){
        $admin->load('country');
        return $this->sendResponse(new AdminResource($admin));
    }

    public function store(AdminFormValidation $request){
        $data = $request->validated();
        $this->adminService->createAdmin($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function update(AdminFormValidation $request, Admin $admin){
        $data = $request->validated();
        $this->adminService->updateAdmin($data, $admin);
        return $this->sendResponse([], 'success' , 200);
    }

    public function delete(DeleteValidation $request){
        $data = $request->validated();
        $this->adminService->deleteAdmin($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function fulldataexport(){
        $admins = Admin::with('country')->where('country_id', auth()->user()->country_id)->latest()->get();
        return $this->sendResponse(AdminResource::collection($admins));
    }

    public function switchstatus(ChangeStatusValidation $request, Admin $admin){
        $data = $request->validated();
        $admin->update([
            'status' =>  $data['status'],
        ]);
        return $this->sendResponse([]);
    }

}




