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
                  <p class="mb-0">{{ $data->workorder->wo_number }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Tanggal Order</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ Carbon\Carbon::parse($data->workorder->order_date)->format('d-m-Y') }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Perusahaan Pemohon</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->company->name }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Departemen</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->department->name }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Nama Pemohon</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->employee->name }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">NRP Pemohon</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->employee->nrp }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Alamat</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->company->address }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Jenis Unit</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->unit_type ?? '-' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Kode Unit</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->unit_code ?? '-' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">EGI</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->egi ?? '-' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Unit yang diperlukan</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->item ?? '-' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Jumlah</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->qty ?? '0' }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Tanggal Mulai</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->start_date }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Tanggal Akhir</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->end_date }}</p>
                </td>
              </tr>
              <tr>
                <td><small class="text-light fw-semibold">Jam Penggunaan</small></td>
                <td class="py-1">
                  <p class="mb-0">{{ $data->workorder->hours_use.' Jam' }}</p>
                </td>
              </tr>
              <tr>
                <td class="py-2">
                    <div class="row">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" class="col-6 btn btn-danger btn-block">Edit</button>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

   <!-- Card Modal -->
   <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">Data Work Order</h3>
            <p class="text-muted">Edit Data Work Order Lainnya</p>
          </div>
          <form action="{{ route('workorder2.update', $data->id) }}" method="POST"  class="row g-3">
            @csrf
            @method('PUT')
            <div class="col-12">
                <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                    <label class="form-label" for="creditCardMask">Jenis Unit</label>
                    <div class="input-group input-group-merge">
                      <input type="text" id="unit_type" class="form-control" name="unit_type" placeholder="Jenis Unit" value="{{ $data->unit_type ?? old('unit_type') }}" />
                    </div>
                    @error('unit_type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                    <label class="form-label" for="creditCardMask">Kode Unit</label>
                    <div class="input-group input-group-merge">
                      <input type="text" id="unit_code" class="form-control" name="unit_code" placeholder="Kode Unit" value="{{ $data->unit_code ?? old('unit_code') }}" />
                    </div>
                    @error('unit_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                    <label class="form-label" for="creditCardMask">EGI</label>
                    <div class="input-group input-group-merge">
                      <input type="text" id="egi" class="form-control" name="egi" placeholder="EGI" value="{{ $data->egi ?? old('egi') }}" />
                    </div>
                    @error('egi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                    <label class="form-label" for="creditCardMask">Upload Gambar (Max: 4 gambar)</label>
                    <div class="input-group input-group-merge">
                      <input type="file" id="images" class="form-control" name="images[]"/>
                    </div>
                    @error('images[]')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan</button>
              <button
                type="reset"unit_code
                unit_code
                class="btn btn-label-secondary btn-reset"
                data-bs-dismiss="modal"
                aria-label="Close"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Card Modal -->
@endsection
