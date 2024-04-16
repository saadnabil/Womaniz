<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DeleteValidation;
use App\Http\Requests\Dashboard\UserFormValidation;
use App\Http\Resources\Dashboard\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $users = User::with('country','city','addresses')->latest()->simplepaginate();
        return $this->sendResponse(resource_collection(UserResource::collection($users)));
    }

    public function search(){
        $users = User::with('country','city','addresses')->where('country_id', auth()->user()->country_id)->latest();
        if(request('search')){
            $users = $users->where(function($q){
                $q->where('name', 'like', '%'.request('search').'%')
                ->orwhere('email', 'like', '%'.request('search').'%')
                ->orwhere('birthdate', 'like', '%'.request('search').'%')
                ->orwhere('phone', 'like', '%'.request('search').'%')
                ->orwhere('status', 'like', '%'.request('search').'%')
                ->orWhereHas('addresses', function($query){
                    $query->where('description','like',  '%'.request('search').'%');
                });
            });
        }
        if(request()->has('status')){
            $users = $users->where('status' ,request('status'));
        }
        if(request()->has('cities')){
            $users = $users->whereIn('city_id' ,request('cities'));
        }
        $users = $users->simplePaginate();
        return $this->sendResponse(resource_collection(UserResource::collection($users)));
    }

    public function show(User $user){
        $user->load('country','city','addresses');
        return $this->sendResponse(new UserResource($user));
    }

    public function store(UserFormValidation $request){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('users', $data['image']);
        }
        $data['password'] = Hash::make($data['password']);
        $data['country_id'] = auth()->user()->country_id;
        User::create($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function update(UserFormValidation $request, User $user){
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = FileHelper::update_file('users', $data['image'], $user->image );
        }
        $data['password'] = Hash::make($data['password']);
        $data['country_id'] = auth()->user()->country_id;
        $user->update($data);
        return $this->sendResponse([], 'success' , 200);
    }

    public function delete(DeleteValidation $request){
        $data = $request->validated();
        $images = User::whereIn('id',$data['ids'])->pluck('image')->toarray();
        User::whereIn('id',$data['ids'])->delete();
        FileHelper::delete_files($images);
        return $this->sendResponse([], 'success' , 200);
    }



    public function switchstatus(User $user){
        $user->update([
            'status' => $user->status == 0 ? 1 : 0,
        ]);
        $data = [
            'status' => $user->status,
        ];
        return $this->sendResponse($data);
    }
}




