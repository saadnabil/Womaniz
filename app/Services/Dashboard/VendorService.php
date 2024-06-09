<?php
namespace App\Services\Dashboard;

use App\Helpers\FileHelper;
use App\Models\Vendor;
use App\Models\VendorWorkCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class VendorService{
    public function listWithSearch($search = null, $status = null , $categories = null){
        $vendors = Vendor::with('categories')->where('country_id', auth()->user()->country_id)->latest();
        if($search){
            $vendors = $vendors->where(function($q) use ($search){
                $q->where('name', 'like', '%'.$search.'%')
                ->orwhere('email', 'like', '%'.$search.'%')
                ->orwhere('phone', 'like', '%'.$search.'%')
                ->orwhere('status', 'like', '%'.$search.'%')
                ->orwhere('contact_name', 'like', '%'.$search.'%')
                ->orwhere('hq_address', 'like', '%'.$search.'%')
                ->orwhere('shipping_address', 'like', '%'.$search.'%')
                ->orwhere('commission', 'like', '%'.$search.'%')
                ->orwhere('transfer_method', 'like', '%'.$search.'%')
                ->orwhere('bank_account_name', 'like', '%'.$search.'%')
                ->orwhere('account_number', 'like', '%'.$search.'%')
                ->orwhere('swift_number', 'like', '%'.$search.'%')
                ->orwhere('iban_number', 'like', '%'.$search.'%');
            });
        }
        if($status != null){
            $vendors = $vendors->where('status' ,$status);
        }
        if($categories){
            $vendors =  $vendors->WhereHas('categories', function($query) use ($categories){
                $query->whereIn('category_id',$categories);
            });
        }
        $vendors = $vendors->simplePaginate();
        return $vendors;
    }

    public function createVendor($data){
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
        return;
    }

    public function deleteVendors($data){
        $images = Vendor::whereIn('id',$data['ids'])->pluck('image')->toarray();
        Vendor::whereIn('id',$data['ids'])->delete();
        FileHelper::delete_files($images);
        return;
    }

    public function updateVendor($data, $vendor){
         /* reset categories */
            VendorWorkCategory::where(['vendor_id' => $vendor->id])->delete();
         /* reset categories */
         $workCategories = $data['categories'];
         unset($data['categories']);
         if(isset($data['image'])){
             $data['image'] = FileHelper::update_file('vendors', $data['image'], $vendor->image);
         }
         if(isset($data['password'])){
             $data['password'] = Hash::make($data['password']);
         }
         $data ['bank_account_name'] = isset($data['bank_account_name']) ?$data['bank_account_name'] : null;
         $data ['account_number'] = isset($data['account_number']) ? $data['account_number'] : null;
         $data ['swift_number'] = isset($data['swift_number']) ? $data['swift_number'] : null;
         $data ['iban_number'] = isset($data['iban_number']) ? $data['iban_number']  : null;
         $vendor->update($data);
         foreach($workCategories as $category){
             VendorWorkCategory::create([
                 'category_id' => $category,
                 'vendor_id' => $vendor->id
             ]);
         }
         return;
    }
}
