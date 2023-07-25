<table cellpadding="5" width="800px">
    <tr>
        <td colspan="2" width="100px"><b>No. Work Order </b>:</td>
        <td width="100px" colspan="2">{{ $data->wo_number }}</td>
        <td colspan="2" width="100px"><b>Nama Pemohon</b>:</td>
        <td width="100px" colspan="3">{{ $data->employee->name }}</td>

    </tr>
    <tr>
        <td colspan="2" width="100px"><b>Tanggal Order</b>:</td>
        <td width="100px" colspan="2">{{ $data->order_date }}</td>
        <td colspan="2" width="100px"><b>Perusahaan </b>:</td>
        <td width="100px" colspan="3">{{ $data->company->name }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="2" width="100px"><b>NRP Pemohon</b>:</td>
        <td width="100px" colspan="3">{{ $data->employee->nrp }}</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="2" width="100px"><b>Departement</b>:</td>
        <td width="100px" colspan="3">{{ $data->department->name }}</td>
    </tr>
    <tr>
        <td colspan="9"></td>
    </tr>
</table>

<table width="800px">
    <thead>
        <tr>
            <th width="30px" rowspan="2" style="vertical-align: middle; text-align: center">No</th>
            <th width="120px" rowspan="2" style="vertical-align: middle; text-align: center">Deskripsi Permintaan</th>
            <th width="300px" colspan="3" style="text-align: center; tex">Unit yang di perlukan</th>
            <th width="50px" rowspan="2" style="vertical-align: middle; text-align: center">Jumlah</th>
            <th width="150px" colspan="2" style="text-align: center">Tanggal</th>
            <th width="100px" rowspan="2" style="vertical-align: middle; text-align: center">Estimasi Jam <br>Penggunaan</th>
        </tr>
        <tr>
            <th style="text-align: center" width="100px">Jenis Unit</th>
            <th style="text-align: center" width="100px">Kode Unit</th>
            <th style="text-align: center" width="100px">Egi</th>
            <th style="text-align: center" width="75px">Mulai</th>
            <th style="text-align: center" width="75px">Selesai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->details as $item)
            <tr>
                <td style="vertical-align: middle; text-align: center">{{ $loop->iteration }}</td>
                <td style="vertical-align: middle; text-align: center">{{ $data->request_description ?? '-' }}</td>
                <td style="text-align: center">{{ $item->unit->type ?? '-' }}</td>
                <td style="text-align: center">{{ $item->unit->unit ?? '-' }}</td>
                <td style="text-align: center">{{ $item->unit->egi ?? '-' }}</td>
                <td style="vertical-align: middle; text-align: center">1</td>
                <td style="text-align: center">{{ Carbon\Carbon::parse($item->start_date)->format('d/m/Y') ?? '-'}}</td>
                <td style="text-align: center">{{ Carbon\Carbon::parse($item->final_date)->format('d/m/Y') ??'-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{ $item->hours_use == null ? '-' : $item->hours_use.' Jam' }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
