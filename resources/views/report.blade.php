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
        <h1>Custom Report</h1>
        <hr>
        <div>
            <h4>Informasi Perusahaan</h4>
            <h2>{{ $data['company']['name'] }}</h2>
            <p><strong>NPWP </strong> {{ $data['company']['npwp'] }}</p>
            <p><strong>Pefindo ID </strong> {{ $data['company']['pefindo_id'] }}</p>
            <p><strong>Alamat </strong> {{ $data['company']['address'] }}</p>
        </div>
        <div>
            <h4>Data Histories</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="4">Pengkinian Data Debitur</th>
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
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="4">Pengkinian Data Identitas</th>
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
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="4">Pengkinian Alamat</th>
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
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="4">Pengkinian Kontak Yang Bisa Dihubungi</th>
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
        <div>
            <h4>Pefindo Score (PS)</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="4">Info Pefindo Score</th>
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
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2">Keterangan Terkait Resiko</th>
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
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="13">Riwayat Skor</th>
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
        <div>
            <h4>Fasilitas</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Daftar Fasilitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th>Daftar Garansi Atau Penjaminan Yang Diberikan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
