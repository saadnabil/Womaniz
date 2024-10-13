<?php
namespace App\Services\Dashboard;

use App\Helpers\FileHelper;
use App\Models\Admin;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorWorkCategory;
use Illuminate\Support\Facades\Hash;

class AdminService{

    public function listWithSearch($search = null, $status = null){
        $admins = Admin::with('country')->where('country_id', auth()->user()->country_id)->latest();
        if($search){
            $admins = $admins->where(function($q) use($search){
                $q->where('name', 'like', '%'.$search.'%')
                ->orwhere('email', 'like', '%'.$search.'%')
                ->orwhere('birthdate', 'like', '%'.$search.'%')
                ->orwhere('address', 'like', '%'.$search.'%')
                ->orwhere('phone', 'like', '%'.$search.'%')
                ->orwhere('status', 'like', '%'.$search.'%');
            });
        }
        if(request()->has('status')){
            $admins = $admins->where('status' ,$status);
        }
        return $admins->paginate();
    }

    public function createAdmin($data){
        if(isset($data['image'])){
            $data['image'] = FileHelper::upload_file('admins', $data['image']);
        }
        $data['password'] = bcrypt($data['password']);
        $data['country_id'] = auth()->user()->country_id;
        $role = $data['role'];
        unset($data['jobs']);
        unset($data['role']);
        $admin = Admin::create($data);
        $admin->assignRole($role);
        return;
    }

    public function deleteAdmin($data){
        $images = Admin::whereIn('id',$data['ids'])->pluck('image')->toarray();
        Admin::whereIn('id',$data['ids'])->delete();
        FileHelper::delete_files($images);
        return;
    }

    public function updateAdmin($data,$admin){
        if(isset($data['image'])){
            $data['image'] = FileHelper::update_file('admins', $data['image'], $admin->image );
        }
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $role = $data['role'];
        unset($data['jobs']);
        unset($data['role']);
        $admin->update($data);
        $admin->roles()->detach();
        $admin->assignRole($role);
        return;
    }
}
