<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WorkOrder2Controller extends Controller
{
    public function index(Request $request)
    {
        $title = 'Work Order 2';

        if($request->ajax()){
            $data = WorkOrderDetail::with(['workorder','workorder.employee','workorder.company','workorder.department'])
            ->whereHas('workorder', function ($query) {
                $query->where('status', 2);
            })
            ->get();

            return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn =  '<a href="' . route('workorder2.edit', $row->id) . '" class="btn btn-sm btn-outline-warning me-1"><i class="fa fa-pen"></i></a>'.
                        '<a href="' . route('workorder2.print', $row->id) . '" class="btn btn-sm btn-outline-warning me-1"><i class="fa fa-print"></i></a>'.
                        '<form id="form-delete" action="'.route('workorder2.destroy', $row->id).'" method="post" class="d-inline">
                        '.method_field('DELETE').'
                        '.csrf_field().'
                        <button type="button" class="btn btn-sm btn-outline-warning btn-delete"><i class="fas fa-trash"></i></button>
                        </form>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('pages.workorder2.index', compact('title'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            WorkOrder::findOrFail($id)->delete();
            DB::commit();

            return redirect()->route('workorder2')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $title = "Edit Data WOrk Order 2";
        $data = WorkOrderDetail::with(['workorder','workorder.employee','workorder.company','workorder.department'])->findOrFail($id);

        return view('pages.workorder2.detail', compact('title','data'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            WorkOrderDetail::findOrFail($id)->update([
                'unit_type' => $request->unit_type,
                'unit_code' => $request->unit_code,
                'egi' => $request->egi,
            ]);
            DB::commit();

            return redirect()->route('workorder2')->with('success', 'Data berhasil diedit');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function print($id)
    {

    }
}
