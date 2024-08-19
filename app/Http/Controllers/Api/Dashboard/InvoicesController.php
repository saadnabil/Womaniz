<?php

namespace App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleFormValidation;
use App\Http\Resources\Dashboard\RoleResource;
use App\Http\Traits\ApiResponseTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicesController extends Controller
{
    use ApiResponseTrait;
    // public function __construct()
    // {
    //     $this->middleware('permission:role-list', ['only' => ['index']]);
    //     $this->middleware('permission:role-create', ['only' => ['store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    public function sendInvoice(){

        // Load the view and pass the data
        $invoice = '';
        $pdf = Pdf::loadView('templates.invoiceTemplate', compact('invoice'));

        // Optionally, you can set paper size, orientation, etc.
        // $pdf->setPaper('A4', 'landscape');

        // Return the generated PDF as a download or inline
        return $pdf->download('invoice.pdf');
        // return $pdf->stream('invoice.pdf');
    }


}
