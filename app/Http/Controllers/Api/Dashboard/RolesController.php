<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleFormValidation;
use App\Http\Resources\Dashboard\RoleResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class RolesController extends Controller
{
    use ApiResponseTrait;
    public function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-add', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->latest();
        if(request()->has('search')){
            $roles = $roles->where(function($q){
                $q->where('name', 'like', '%'.request('search').'%')
                ->orwhereHas('permissions', function($q){
                    $q->where('name',  'like', '%'.request('search').'%');
                });
            });
        }
        $roles =  $roles->simplepaginate();
        return $this->sendResponse(resource_collection(RoleResource::collection($roles)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleFormValidation $request)
    {
        $data = $request -> validated();
        $role = Role::Create(['name' => $data ['name'], 'guard_name' => 'admin' ]);
        $role->syncPermissions($data['permissions']);
        return $this->sendResponse([]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleFormValidation $request, Role $role)
    {
       $data = $request -> validated();
       $data['permissions'] =  $data['permissions'] ?? [];
       $role -> update(['name' => $data ['name']]);
       $role->syncPermissions($data['permissions']);
       return $this->sendResponse([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role -> delete();
        return $this->sendResponse([]);
    }

}
