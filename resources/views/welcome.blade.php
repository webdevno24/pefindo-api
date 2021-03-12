<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEFINDO API TEST</title>
    <style>
        body *{
            display: block;
        }
        .my-2 {
            margin: 2rem auto;
        }
    </style>
</head>
<body>
    {{--
        # SmartSeachCompany
        - Company Name
        - NPWP
        - Inquiry Reason (Tujuan Penggunaan)
        - Inquiry Reason Text ( Keterangan Tujuan Penggunaan )
    --}}
    <form action="{{ route('smartSeachCompany') }}" method="POST">
        @csrf
        <div class="my-2">
            <label for="npwp">NPWP</label>
            <input type="text" name="npwp">
        </div>
        <div class="my-2">
            <label for="company_name">Nama Perusahaan</label>
            <input type="text" name="company_name">
        </div>
        <div class="my-2">
            <label for="inquiry_reason">Tujuan Penggunaan</label>
            <input type="text" name="inquiry_reason">
        </div>
        <div class="my-2">
            <label for="inquiry_reason_text">Detail Tujuan Penggunaan</label>
            <input type="text" name="inquiry_reason_text">
        </div>
        <div class="my-2">
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>
