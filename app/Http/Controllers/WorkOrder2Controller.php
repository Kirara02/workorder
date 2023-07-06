<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WorkOrder2Controller extends Controller
{
    public function index(Request $request)
    {
        $title = 'Work Order 2';

        if($request->ajax()){
            $data = WorkOrderDetail::with(['workorder','workorder.employee','workorder.company','workorder.department','unit'])
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
        $title = "Edit Data Work Order 2";
        $type = Unit::select('type')->groupBy('type')->get();
        $unit = Unit::select('unit')->groupBy('unit')->get();
        $egi = Unit::select('egi')->groupBy('egi')->get();

        $data = WorkOrderDetail::with(['workorder','workorder.employee','workorder.company','workorder.department'])->findOrFail($id);

        return view('pages.workorder2.detail', compact('title','data','type','unit','egi'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $unit = Unit::where('type',$request->type)->where('unit', $request->unit)->where('egi',$request->egi)->first();
            $image = $request->file('image');
            $imageUrl = $image->storeAs('workorder', Str::random(12). '.' . $image->extension());

            WorkOrderDetail::findOrFail($id)->update([
                'image' => $imageUrl,
                'unit_id' => $unit->id
            ]);
            DB::commit();

            return redirect()->route('workorder2');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function print($id)
    {

    }
}
