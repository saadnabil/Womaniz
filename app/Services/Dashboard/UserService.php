<?php
namespace App\Services\Dashboard;

use App\Helpers\FileHelper;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorWorkCategory;
use Illuminate\Support\Facades\Hash;

class UserService{

    public function listWithSearch($search = null, $status = null , $cities = null){
        $users = User::with('country','city','addresses','orders')->where('country_id', auth()->user()->country_id)->latest();
        if($search){
            $users = $users->where(function($q) use($search){
                $q->where('name', 'like', '%'.$search.'%')
                ->orwhere('email', 'like', '%'.$search.'%')
                ->orwhere('birthdate', 'like', '%'.$search.'%')
                ->orwhere('phone', 'like', '%'.$search.'%')
                ->orwhere('status', 'like', '%'.$search.'%')
                ->orWhereHas('addresses', function($query) use($search){
                    $query->where('description','like',  '%'.$search.'%');
                });
            });
        }
        if($status != null){
            $users = $users->where('status' ,request('status'));
        }
        if($cities){
            $users = $users->whereIn('city_id' ,request('cities'));
        }
        return $users->simplePaginate();
    }

    public function createUser($data){
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('users', $data['image']);
        }
        $data['password'] = Hash::make($data['password']);
        $data['country_id'] = auth()->user()->country_id;
        User::create($data);
    }

    public function deleteUser($data){
        $images = User::whereIn('id',$data['ids'])->pluck('image')->toarray();
        User::whereIn('id',$data['ids'])->delete();
        FileHelper::delete_files($images);
        return;
    }

    public function updateUser($data,$user){
        if(isset($data['image'])){
            $data['image'] = FileHelper::update_file('users', $data['image'], $user->image );
        }
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $data['country_id'] = auth()->user()->country_id;
        $user->update($data);
         return;
    }
}
