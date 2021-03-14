<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEFINDO API TEST</title>
    <link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
</head>
<body>
    <div class="container">
        <form action="{{ route('smartSearchCompany') }}" method="POST">
            @csrf
            <div class="my-2">
                <label class="form-label" for="npwp">NPWP</label>
                <input type="text" class="form-control" name="npwp" value="{!! isset($input) ? $input['npwp'] : '' !!}">
            </div>
            <div class="my-2">
                <label class="form-label" for="company_name">Nama Perusahaan</label>
                <input type="text" class="form-control" name="company_name" value="{!! isset($input) ? $input['company_name'] : '' !!}">
            </div>
            <div class="my-2">
                <label class="form-label" for="inquiry_reason">Tujuan Penggunaan</label>
                <select name="inquiry_reason" class="form-control">
                    <option {!! isset($input) ? $input['inquiry_reason'] == 'ProvidingFacilities' ? 'selected' : '' : '' !!} value="ProvidingFacilities">Proses Penyediaan Fasilitas</option>
                    <option {!! isset($input) ? $input['inquiry_reason'] == 'MonitoringDebtorOrCustomer' ? 'selected' : '' : '' !!} value="MonitoringDebtorOrCustomer">Pemantauan Debitur atau Nasabah</option>
                    <option {!! isset($input) ? $input['inquiry_reason'] == 'OperationalRiskManagement' ? 'selected' : '' : '' !!} value="OperationalRiskManagement">Manajemen Risiko Operasional</option>
                    <option {!! isset($input) ? $input['inquiry_reason'] == 'FulfilRegulationRequirements' ? 'selected' : '' : '' !!} value="FulfilRegulationRequirements">Memenuhi Peraturan Perundang-undangan</option>
                    <option {!! isset($input) ? $input['inquiry_reason'] == 'AnotherReason' ? 'selected' : '' : '' !!} value="AnotherReason">Sebab Lainnya</option>
                </select>
            </div>
            <div class="my-2">
                <label class="form-label" for="inquiry_reason_text">Detail Tujuan Penggunaan</label>
                <input type="text" class="form-control" name="inquiry_reason_text" value="aaaaaaaaa">
            </div>
            <div class="my-3">
                <button class="btn btn-primary w-100" type="submit">Cari</button>
            </div>
        </form>

        @if (isset($search_data))
            <h1>Hasil Pencarian</h1>
            <div>
                <p>Status: <span class="badge {{ $search_data['status'] ? 'bg-success' : 'bg-danger' }}">{{$search_data['message']}}</span></p>
                <p>Total data: {{ count($search_data['data']) }}</p>
            </div>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Laporan</th>
                            <th>Pefindo Id</th>
                            <th>NPWP</th>
                            <th>Perusahaan</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($search_data['data'] as $data)
                        <tr>
                            <td>
                                <a href="#" class="btn btn-sm btn-success">lihat</a>
                            </td>
                            <td>{{ $data->PefindoId }}</td>
                            <td>{{ $data->NPWP }}</td>
                            <td>{{ $data->CompanyName }}</td>
                            <td>{{ $data->Address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>
