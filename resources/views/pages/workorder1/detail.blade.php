@extends('layouts.master')
@section('content')
<h4 class="fw-bold py-3 mb-34">
    <span class="text-muted fw-light">{{ $title }}  /</span> Feature / {{ $title }}
</h4>
<div class="row">
    <!-- Inline text elements -->
    <div class="col">
      <div class="card mb-4">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-body">
          <table id="wo-detail" class="table table-borderless">
            <tbody>
              <tr>
                <td width="250px"><small class="text-light fw-semibold">No Work Order</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->wo_number }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Tanggal Order</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ Carbon\Carbon::parse($data->order_date)->format('d-m-Y') }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Perusahaan Pemohon</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->company->name }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Departemen</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->department->name }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Nama Pemohon</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->employee->name }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">NRP Pemohon</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->employee->nrp }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Alamat</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->company->address }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-danger fw-bold">Deskripsi Permintaan</small></td>
                <td class="py-1">
                  <p class="mb-0 text-danger fw-bold">{{ $data->request_description }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Unit yang diperlukan</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->details()->pluck('item')->implode(', ') ?? '-' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Jumlah</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->details()->sum('qty') ?? '0' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Tanggal Mulai</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->start_date }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Tanggal Akhir</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->end_date }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Jam Penggunaan</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->hours_use.' Jam' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">status</small></td>
                <td class="py-1">
                    @if ($data->status == 2)
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($data->status == 3)
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <div class="row col-5 ">
                            <div class="col-5">
                                <form action="{{ route('workorder1.accept', $data->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-info btn-block btn-accept">Terima</button>
                                </form>
                            </div>
                            <div class="col-5">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#rejectModal" class="btn btn-danger btn-block">Tolak</button>
                            </div>
                        </div>
                    @endif
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Deskripsi (Alasan Ditolak)</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->description ?? '-' }}</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    $(document).ready(function(){
        $("#wo-detail").on('click', '.btn-accept', function(e) {
            e.preventDefault();
                Swal.fire({
                    title: 'Edit data?',
                    text: "Setujui data bersifat permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Terima!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().submit()
                    }
                })
            });
    })
  </script>
@endsection
