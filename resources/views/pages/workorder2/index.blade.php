@extends('layouts.master', ['title' => $title])
@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">{{ $title }}
</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>No WO</th>
                    <th>Tanggal Order</th>
                    <th>Perusahaan Pemohon</th>
                    <th>Departemen</th>
                    <th>Nama Pemohon</th>
                    <th>Deskripsi Permintaan</th>
                    <th>Unit</th>
                    <th>Jumlah</th>
                    <th>Jenis Unit</th>
                    <th>Kode Unit</th>
                    <th>EGI</th>
                    <th>Tanggal Selesai</th>
                    <th>Jam Penggunaan</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>
<script>


  $(document).ready(function(){
    var table = $('#dataTable').DataTable({
      ajax: {
          url: "{{route('workorder2')}}",
          type: "GET",
          data: function(d) {
              // d._user = $('#user').val(),
              // d._start_date = $('#start_date').val(),
              // d._end_date = $('#end_date').val()

          }
      },
      processing: true,
      serverSide: true,
      columnDefs: [{
              "defaultContent": "-",
              "targets": "_all"
          },

      ],
      order: [
          [0, 'DESC']
      ],
      columns: [
          {
              data: 'workorder.wo_number',
              name: 'workorder.wo_number'
          },
          {
              data: 'workorder.order_date',
              name: 'workorder.order_date'
          },
          {
              data: 'workorder.company.name',
              name: 'workorder.company.name'
          },
          {
              data: 'workorder.department.name',
              name: 'workorder.department.name'
          },
          {
              data: 'workorder.employee.name',
              name: 'workorder.employee.name'
          },
          {
              data: 'workorder.request_description',
              name: 'workorder.request_description'
          },
          {
              data: 'item',
              name: 'item'
          },
          {
              data: 'qty',
              name: 'qty'
          },
          {
              data: 'unit.type',
              name: 'unit.type'
          },
          {
              data: 'unit.unit',
              name: 'unit.unit'
          },
          {
              data: 'unit.egi',
              name: 'unit.egi'
          },
          {
              data: 'workorder.end_date',
              name: 'workorder.end_date'
          },
          {
              data: 'workorder.hours_use',
              name: 'workorder.hours_use'
          },
          {
              data: 'action',
              name: 'action'
          },
      ],
  });


  })
</script>
@endsection
