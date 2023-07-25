<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkOrderDetailExport implements FromView
{
    public function __construct($data = [], $title = '')
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function view(): View
    {
        return view('pages.laporan.export', [
            'title' => $this->title,
            'data' => $this->data,
        ]);
    }
}
