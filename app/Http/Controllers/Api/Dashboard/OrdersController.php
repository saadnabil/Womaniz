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
use App\Models\Order;
use App\Services\Dashboard\AdminService;
class OrdersController extends Controller
{
    use ApiResponseTrait;

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;

        $this->middleware('permission:admin-list', ['only' => ['index']]);
        $this->middleware('permission:admin-create', ['only' => ['store']]);
        $this->middleware('permission:admin-edit', ['only' => ['update']]);
        $this->middleware('permission:admin-show', ['only' => ['show']]);
        $this->middleware('permission:admin-delete', ['only' => ['delete']]);
        $this->middleware('permission:admin-export', ['only' => ['fulldataexport']]);
        $this->middleware('permission:admin-change-status', ['only' => ['switchstatus']]);
    }


    public function index(){
        $orders = Order::latest()->get();
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




