<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChangeStatusValidation;
use App\Http\Requests\Dashboard\DeleteValidation;
use App\Http\Requests\Dashboard\UserFormValidation;
use App\Http\Resources\Dashboard\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use App\Services\Dashboard\UserService;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    use ApiResponseTrait;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
        $this->middleware('permission:user-export', ['only' => ['fulldataexport']]);
        $this->middleware('permission:user-change-status', ['only' => ['switchstatus']]);
    }




    public function index(){
        $search = request()->has('search') ? request('search') : null;
        $status = request()->has('status') ? request('status') : null;
        $cities = request()->has('cities') ? request('cities') : null;
        $users = $this->userService->listWithSearch($search, $status , $cities);
        return $this->sendResponse(resource_collection(UserResource::collection($users)));
    }

    public function fulldataexport(){
        $admins = User::with('country','city','addresses')->where('country_id', auth()->user()->country_id)->latest()->get();
        return $this->sendResponse(UserResource::collection($admins));
    }

    public function show(User $user){
        $user->load('country','city','addresses');
        return $this->sendResponse(new UserResource($user));
    }

    public function store(UserFormValidation $request){
        $data = $request->validated();
        $this->userService->createUser($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function update(UserFormValidation $request, User $user){
        $data = $request->validated();
        $this->userService->updateUser($data, $user);
        return $this->sendResponse([], 'success' , 200);
    }

    public function delete(DeleteValidation $request){
        $data = $request->validated();
        $this->userService->deleteUser($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function switchstatus(ChangeStatusValidation $request, User $user){
        $data = $request->validated();
        $user->update([
            'status' =>  $data['status'],
        ]);
        return $this->sendResponse([]);
    }

}




