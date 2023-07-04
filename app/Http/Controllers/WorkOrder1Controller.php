<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WorkOrder1Controller extends Controller
{
    public function index(Request $request)
    {
        $title = 'Work Order 1';

        if($request->ajax()){
            $query = WorkOrder::with(['employee','department','company','details'])->limit(1000);

            if ($request->status) {
                $query->where('status', $request->input('status'));
            }

            $data = $query->get();

            return DataTables::of($data)
            ->addColumn('units', function($row){
                return $row->details()->pluck('item')->implode(', ') ?? '-';
            })
            ->addColumn('amount', function($row){
                return $row->details()->sum('qty') ?? '0';
            })
            ->addColumn('status_project', function($row){
                $currentDate = Carbon::now();
                $endDate = Carbon::parse($row->end_date);

                if ($currentDate > $endDate) {
                    return '<span class="badge rounded-pill bg-danger">CLOSED</span>';
                } else {
                    return '<span class="badge rounded-pill bg-info">OPEN</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('workorder1.show', $row->id) . '" class="btn btn-sm btn-outline-warning me-1"><i class="fa fa-expand"></i></a>'.
                          '<form id="form-delete" action="'.route('workorder1.destroy', $row->id).'" method="post" class="d-inline">
                          '.method_field('DELETE').'
                          '.csrf_field().'
                          <button type="button" class="btn btn-sm btn-outline-warning btn-delete"><i class="fas fa-trash"></i></button>
                          </form>';

                return $btn;
            })
            ->editColumn('status', function($row){
                $statusMap = [
                    1 => '<span class="badge rounded-pill bg-warning">Pending</span>',
                    2 => '<span class="badge rounded-pill bg-success">Disetujui</span>',
                    3 => '<span class="badge rounded-pill bg-danger">Ditolak</span>',
                ];

                return $statusMap[$row->status] ?? '';
            })
            ->rawColumns(['action','status','status_project','units','amount'])
            ->make();
        }

        return view('pages.workorder1.index', compact('title'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            WorkOrder::findOrFail($id)->delete();
            DB::commit();

            return redirect()->route('workorder1')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $title = 'Data Work Order 1';
        $data = WorkOrder::with(['employee','department','company','details'])->findOrFail($id);

        return view('pages.workorder1.detail', compact('title','data'));
    }

    public function accept($id)
    {
        try {
            DB::beginTransaction();
            WorkOrder::findOrFail($id)->update([
                'status' => 2,
            ]);
            DB::commit();

            return redirect()->route('workorder1')->with('success','Data berhasil disetujui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
    public function reject(Request $request, $id)
    {
        $request->validate([
            'description' => 'required'
        ]);
        try {
            DB::beginTransaction();
            WorkOrder::findOrFail($id)->update([
                'status' => 3,
                'description' => $request->description
            ]);
            DB::commit();

            return redirect()->route('workorder1')->with('success','Data berhasil ditolak');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
