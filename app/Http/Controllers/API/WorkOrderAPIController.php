<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkOrderAPIController extends Controller
{
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $jsonData = $request->json()->all();
            $woNumber = Helper::generateWONumber();

            $data = WorkOrder::create([
                'wo_number' => $woNumber,
                'order_date' => $jsonData['order_date'],
                'employee_id' => $jsonData['employee_id'],
                'department_id' => $jsonData['department_id'],
                'company_id' => $jsonData['company_id'],
                'start_date' => $jsonData['start_date'],
                'end_date' => $jsonData['end_date'],
                'hours_use' => $jsonData['hours_use'],
                'request_description' => $jsonData['request_description'],
                'status' => '1',
            ]);
            $detail = '';
            foreach($jsonData['items'] as $item){
                $detail = WorkOrderDetail::create([
                    'item' => $item['item'],
                    'qty' => $item['qty'],
                    'workorder_id' => $data->id,
                ]);
            }
            $data['items'] = $detail::where('workorder_id', $data->id)->get();
            DB::commit();
            return ResponseFormatter::success($data,'Data created successfully',201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseFormatter::error('Something went wrong in '.$th->getMessage(),400);
        }
    }

    public function all()
    {
        try {
            $data = WorkOrder::with(['details'])->get();

            return ResponseFormatter::success($data, 'Data sukses diambil');
        } catch (\Throwable $th) {
            return ResponseFormatter::error('Something went wrong in '.$th->getMessage(),400);
        }
    }

    public function show($id)
    {
        try {
            $data = WorkOrder::with(['details'])->find($id);

            if($data != null){
                return ResponseFormatter::success($data, 'Data sukses diambil');
            }

            return ResponseFormatter::error(null,'Data dengan ID '.$id.' tidak ditemukan',404);
        } catch (\Throwable $th) {
            return ResponseFormatter::error('Something went wrong in '.$th->getMessage(),400);
        }
    }
}
