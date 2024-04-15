<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminValidation;
use App\Http\Resources\Dashboard\AdminResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $admins = Admin::latest()->simplepaginate();
        return $this->sendResponse(resource_collection(AdminResource::collection($admins)));
    }

    public function store(AdminValidation $request){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('admins', $data['image']);
        }
        $data['password'] = Hash::make($data['password']);
        Admin::create($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function update(AdminValidation $request, Admin $admin){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::update_file('admins', $data['image'], $admin->image );
        }
        $data['password'] = Hash::make($data['password']);
        $admin->update($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function destroy(Request $request, Admin $admin){
        $admin->delete();
        return $this->sendResponse([], 'success' , 200);
    }

}
