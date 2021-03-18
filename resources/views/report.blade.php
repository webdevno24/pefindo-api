<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEFINDO API TEST</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        table {
            caption-side: bottom;
            border-collapse: collapse;
        }
        th {
            text-align: left;
        }
        th,td {
            border: 1px solid #dee2e6;
        }
        .table {
            --bs-table-bg: transparent;
            --bs-table-striped-color: #212529;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
            --bs-table-active-color: #212529;
            --bs-table-active-bg: rgba(0, 0, 0, 0.1);
            --bs-table-hover-color: #212529;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;
        }

        .table> :not(caption)>*>* {
            padding: 0.5rem 0.5rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }

        .table>tbody {
            vertical-align: inherit;
        }

        .table>thead {
            vertical-align: bottom;
        }

        .table> :not(:last-child)> :last-child>* {
            /* border-bottom-color: currentColor; */
        }

        .caption-top {
            caption-side: top;
        }

        .table-sm> :not(caption)>*>* {
            padding: 0.25rem 0.25rem;
        }

        .table-bordered> :not(caption)>* {
            border-width: 1px;
            border-color: rgb(235, 235, 235);
        }

        .table-bordered> :not(caption)>*>* {
            border-width: 1px;
            border-color: rgb(235, 235, 235);
        }

        .table-borderless> :not(caption)>*>* {
            border-bottom-width: 0;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: var(--bs-table-striped-bg);
            color: var(--bs-table-striped-color);
        }

        .table-active {
            --bs-table-accent-bg: var(--bs-table-active-bg);
            color: var(--bs-table-active-color);
        }

        .table-hover>tbody>tr:hover {
            --bs-table-accent-bg: var(--bs-table-hover-bg);
            color: var(--bs-table-hover-color);
        }

        .table-primary {
            --bs-table-bg: #cfe2ff;
            --bs-table-striped-bg: #c5d7f2;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #bacbe6;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #bfd1ec;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #bacbe6;
        }

        .table-secondary {
            --bs-table-bg: #e2e3e5;
            --bs-table-striped-bg: #d7d8da;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #cbccce;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #d1d2d4;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #cbccce;
        }

        .table-success {
            --bs-table-bg: #d1e7dd;
            --bs-table-striped-bg: #c7dbd2;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #bcd0c7;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #c1d6cc;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #bcd0c7;
        }

        .table-info {
            --bs-table-bg: #cff4fc;
            --bs-table-striped-bg: #c5e8ef;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #badce3;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #bfe2e9;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #badce3;
        }

        .table-warning {
            --bs-table-bg: #fff3cd;
            --bs-table-striped-bg: #f2e7c3;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #e6dbb9;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #ece1be;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #e6dbb9;
        }

        .table-danger {
            --bs-table-bg: #f8d7da;
            --bs-table-striped-bg: #eccccf;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #dfc2c4;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #e5c7ca;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #dfc2c4;
        }

        .table-light {
            --bs-table-bg: #f8f9fa;
            --bs-table-striped-bg: #ecedee;
            --bs-table-striped-color: #000;
            --bs-table-active-bg: #dfe0e1;
            --bs-table-active-color: #000;
            --bs-table-hover-bg: #e5e6e7;
            --bs-table-hover-color: #000;
            color: #000;
            border-color: #dfe0e1;
        }

        .table-dark {
            --bs-table-bg: #212529;
            --bs-table-striped-bg: #2c3034;
            --bs-table-striped-color: #fff;
            --bs-table-active-bg: #373b3e;
            --bs-table-active-color: #fff;
            --bs-table-hover-bg: #323539;
            --bs-table-hover-color: #fff;
            color: #fff;
            border-color: #373b3e;
        }

        .bg-primary {
            background-color: #0d6efd !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .bg-success {
            background-color: #198754 !important;
        }

        .bg-info {
            background-color: #0dcaf0 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .bg-dark {
            background-color: #212529 !important;
        }

        .bg-body {
            background-color: #fff !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        .bg-transparent {
            background-color: transparent !important;
        }

        .bg-gradient {
            background-image: var(--bs-gradient) !important;
        }

        .text-white {
            color: white;
        }

        .m-0 {
            margin: 0 !important;
        }

        .m-1 {
            margin: 0.25rem !important;
        }

        .m-2 {
            margin: 0.5rem !important;
        }

        .m-3 {
            margin: 1rem !important;
        }

        .m-4 {
            margin: 1.5rem !important;
        }

        .m-5 {
            margin: 3rem !important;
        }

        .m-auto {
            margin: auto !important;
        }

        .mx-0 {
            margin-right: 0 !important;
            margin-left: 0 !important;
        }

        .mx-1 {
            margin-right: 0.25rem !important;
            margin-left: 0.25rem !important;
        }

        .mx-2 {
            margin-right: 0.5rem !important;
            margin-left: 0.5rem !important;
        }

        .mx-3 {
            margin-right: 1rem !important;
            margin-left: 1rem !important;
        }

        .mx-4 {
            margin-right: 1.5rem !important;
            margin-left: 1.5rem !important;
        }

        .mx-5 {
            margin-right: 3rem !important;
            margin-left: 3rem !important;
        }

        .mx-auto {
            margin-right: auto !important;
            margin-left: auto !important;
        }

        .my-0 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .my-1 {
            margin-top: 0.25rem !important;
            margin-bottom: 0.25rem !important;
        }

        .my-2 {
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .my-3 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .my-5 {
            margin-top: 3rem !important;
            margin-bottom: 3rem !important;
        }

        .my-auto {
            margin-top: auto !important;
            margin-bottom: auto !important;
        }

        .mt-0 {
            margin-top: 0 !important;
        }

        .mt-1 {
            margin-top: 0.25rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mt-auto {
            margin-top: auto !important;
        }

        .me-0 {
            margin-right: 0 !important;
        }

        .me-1 {
            margin-right: 0.25rem !important;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .me-3 {
            margin-right: 1rem !important;
        }

        .me-4 {
            margin-right: 1.5rem !important;
        }

        .me-5 {
            margin-right: 3rem !important;
        }

        .me-auto {
            margin-right: auto !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mb-1 {
            margin-bottom: 0.25rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .mb-auto {
            margin-bottom: auto !important;
        }

        .ms-0 {
            margin-left: 0 !important;
        }

        .ms-1 {
            margin-left: 0.25rem !important;
        }

        .ms-2 {
            margin-left: 0.5rem !important;
        }

        .ms-3 {
            margin-left: 1rem !important;
        }

        .ms-4 {
            margin-left: 1.5rem !important;
        }

        .ms-5 {
            margin-left: 3rem !important;
        }

        .ms-auto {
            margin-left: auto !important;
        }

        .card {
            /* position: relative; */
            /* display: flex; */
            /* flex-direction: column; */
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card>hr {
            margin-right: 0;
            margin-left: 0;
        }

        .card>.list-group {
            border-top: inherit;
            border-bottom: inherit;
        }

        .card>.list-group:first-child {
            border-top-width: 0;
            border-top-left-radius: calc(0.25rem - 1px);
            border-top-right-radius: calc(0.25rem - 1px);
        }

        .card>.list-group:last-child {
            border-bottom-width: 0;
            border-bottom-right-radius: calc(0.25rem - 1px);
            border-bottom-left-radius: calc(0.25rem - 1px);
        }

        .card>.card-header+.list-group,
        .card>.list-group+.card-footer {
            border-top: 0;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .card-title {
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            margin-top: -0.25rem;
            margin-bottom: 0;
        }

        .card-text:last-child {
            margin-bottom: 0;
        }

        .card-link:hover {
            text-decoration: none;
        }

        .card-link+.card-link {
            margin-left: 1rem
                /* rtl:ignore */
            ;
        }

        .card-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .card-footer {
            padding: 0.5rem 1rem;
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-footer:last-child {
            border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
        }

        .card-header-tabs {
            margin-right: -0.5rem;
            margin-bottom: -0.5rem;
            margin-left: -0.5rem;
            border-bottom: 0;
        }

        .card-header-pills {
            margin-right: -0.5rem;
            margin-left: -0.5rem;
        }

        .card-img-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 1rem;
            border-radius: calc(0.25rem - 1px);
        }

        .card-img,
        .card-img-top,
        .card-img-bottom {
            width: 100%;
        }

        .card-img,
        .card-img-top {
            border-top-left-radius: calc(0.25rem - 1px);
            border-top-right-radius: calc(0.25rem - 1px);
        }

        .card-img,
        .card-img-bottom {
            border-bottom-right-radius: calc(0.25rem - 1px);
            border-bottom-left-radius: calc(0.25rem - 1px);
        }

        .card-group>.card {
            margin-bottom: 0.75rem;
        }

        @media (min-width: 576px) {
            .card-group {
                display: flex;
                flex-flow: row wrap;
            }

            .card-group>.card {
                flex: 1 0 0%;
                margin-bottom: 0;
            }

            .card-group>.card+.card {
                margin-left: 0;
                border-left: 0;
            }

            .card-group>.card:not(:last-child) {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .card-group>.card:not(:last-child) .card-img-top,
            .card-group>.card:not(:last-child) .card-header {
                border-top-right-radius: 0;
            }

            .card-group>.card:not(:last-child) .card-img-bottom,
            .card-group>.card:not(:last-child) .card-footer {
                border-bottom-right-radius: 0;
            }

            .card-group>.card:not(:first-child) {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            .card-group>.card:not(:first-child) .card-img-top,
            .card-group>.card:not(:first-child) .card-header {
                border-top-left-radius: 0;
            }

            .card-group>.card:not(:first-child) .card-img-bottom,
            .card-group>.card:not(:first-child) .card-footer {
                border-bottom-left-radius: 0;
            }
        }

        h6, .h6, h5, .h5, h4, .h4, h3, .h3, h2, .h2, h1, .h1 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-weight: bolder;
            line-height: 1.2;
        }

    </style>
</head>

<body>
    <div class="container">
        @if (!$status)
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @else
            <div class="card mb-3 page-break">
                <div class="card-header bg-info text-white">
                    <h3>Informasi Perusahaan</h3>
                </div>
                <div class="card-body">
                    <h2>{{ $data['company']['name'] }}</h2>
                    <p><strong>NPWP </strong> {{ $data['company']['npwp'] }}</p>
                    <p><strong>Pefindo ID </strong> {{ $data['company']['pefindo_id'] }}</p>
                    <p><strong>Alamat </strong> {{ $data['company']['address'] }}</p>
                </div>
            </div>
            <div class="card mb-3 page-break">
                <div class="card-header bg-info text-white">
                    <h3>Data Histories</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="4">Pengkinian Data Debitur</th>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <th>Perubahan</th>
                                <th>Berlaku Sejak</th>
                                <th>Berlaku Sampai Dengan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table tab-le-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="4">Pengkinian Data Identitas</th>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <th>Perubahan</th>
                                <th>Berlaku Sejak</th>
                                <th>Berlaku Sampai Dengan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="4">Pengkinian Alamat</th>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <th>Perubahan</th>
                                <th>Berlaku Sejak</th>
                                <th>Berlaku Sampai Dengan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="4">Pengkinian Kontak Yang Bisa Dihubungi</th>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <th>Perubahan</th>
                                <th>Berlaku Sejak</th>
                                <th>Berlaku Sampai Dengan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-3 page-break">
                <div class="card-header bg-info text-white">
                    <h3>Pefindo Score (PS)</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="4">Info Pefindo Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Score PS</th>
                                <td>{{ $data['pefindo_score']['score'] }}</td>
                                <th>Kategori resiko</th>
                                <td>{{ $data['pefindo_score']['grade'] }}</td>
                            </tr>
                            <tr>
                                <th>Kemungkinan gagal bayar (%)</th>
                                <td>{{ $data['pefindo_score']['failpay_prob'] }}</td>
                                <th>Keterangan</th>
                                <td>{{ $data['pefindo_score']['grade_desc'] }}</td>
                            </tr>
                            <tr>
                                <th>Trend</th>
                                <td>{{ $data['pefindo_score']['trend'] }}</td>
                                <th></th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="2">Keterangan Terkait Resiko</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['desc_about_risk'] as $about_risk)
                                <tr>
                                    <td>{{ $about_risk['code'] }}</td>
                                    <td>{{ $about_risk['description'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="13">Riwayat Skor</th>
                            </tr>
                            <tr>
                                <th>Bulan-Tahun</th>
                                @foreach ($data['pefindo_score_histories'] as $score_history)
                                    <th>{{ $score_history['date']->format('Y-F') }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pefindo Score</td>
                                @foreach ($data['pefindo_score_histories'] as $score_history)
                                    <td>{{ $score_history['score'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Kemungkinan Gagal Bayar (%)</td>
                                @foreach ($data['pefindo_score_histories'] as $score_history)
                                    <td>{{ $score_history['failpay_prob'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Pefindo Grade</td>
                                @foreach ($data['pefindo_score_histories'] as $score_history)
                                    <td>{{ $score_history['grade'] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h3>Fasilitas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="bg-info text-white" colspan="8">Daftar Fasilitas</th>
                            </tr>
                            <tr>
                                <th>Jenis Lembaga</th>
                                <th>Jenis Fasilitas</th>
                                <th>Tanggal Pembukaan</th>
                                <th>Status</th>
                                <th>Plafon</th>
                                <th>Baki Debet</th>
                                <th>Nilai Tunggakan</th>
                                <th>Usia Tunggakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['facilities'] as $facility)
                                <tr>
                                    <td>{{ $facility['sector'] }}</td>
                                    <td>{{ $facility['type'] }}</td>
                                    <td>{{ $facility['opening_date'] }}</td>
                                    <td>{{ $facility['status'] }}</td>
                                    <td>{{ $facility['plafon'] }}</td>
                                    <td>{{ $facility['baki_debet'] }}</td>
                                    <td>{{ $facility['past_due_amount'] }}</td>
                                    <td>{{ $facility['past_due_days'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Daftar Garansi Atau Penjaminan Yang Diberikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>tidak ada data</td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
            </div>
        @endif
    </div>
</body>

</html>
