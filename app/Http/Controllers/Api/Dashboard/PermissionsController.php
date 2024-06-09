<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\PermissionResource;
use App\Http\Resources\Dashboard\SinglePermissionResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class PermissionsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::orderBy('grouping')->get()->groupBy('grouping');
        return $this->sendResponse(PermissionResource::collection($permissions));
    }

}
