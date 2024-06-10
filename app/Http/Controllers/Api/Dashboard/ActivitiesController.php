<?php
namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\AdminResource;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Dashboard\AdminService;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
class ActivitiesController extends Controller
{
    use ApiResponseTrait;

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;

        // $this->middleware('permission:admin-list', ['only' => ['index']]);
        // $this->middleware('permission:admin-create', ['only' => ['store']]);
        // $this->middleware('permission:admin-edit', ['only' => ['update']]);
        // $this->middleware('permission:admin-show', ['only' => ['show']]);
        // $this->middleware('permission:admin-delete', ['only' => ['delete']]);
        // $this->middleware('permission:admin-export', ['only' => ['fulldataexport']]);
        // $this->middleware('permission:admin-change-status', ['only' => ['switchstatus']]);
    }


    public function index(Request $request){
        $data = Activity::whereNotNull('causer_id');
        if ($request->has('adminsIds')) {
            $data->where('causer_id', $request->input('adminsIds'));
        }
        if ($request->has('from_date') || $request->has('to_date')) {
            $from_date = $request->input('from_date') ? $request->input('from_date') . ' 00:00:00' : '0000-00-00 00:00:00';
            $to_date = $request->input('to_date') ? $request->input('to_date') . ' 23:59:59' : date('Y-m-d H:i:s');
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderByDesc('id')->with(['causer', 'subject']);
        return response()->json($data);

        // return $this->sendResponse(resource_collection(AdminResource::collection($admins)));
    }



}




