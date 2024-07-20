<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center><p style="font-size: 25px"><b>Surat Keterangan Kelahiran</b></p></center>
    <p>Yang bertanda tangan dibawah ini menerangkan bahwa pada  :</p>
    <table width="100%">
        <tr>
            <td width="35%">Hari</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nama_hari}}</td>
        </tr>
        <tr>
            <td width="35%">Tanggal</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->tgl_lahir}}</td>
        </tr>
        <tr>
            <td width="35%">Di</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->alamat_kelahiran}}</td>
        </tr>
        <br>
        <p>Telah lahir seorang anak <b>@if($data->jk =='L')Laki - Laki @else Perempuan @endif</b></p>
        <br>
        <tr>
            <td width="35%">Bernama</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nama_anak}}</td>
        </tr>
        <tr>
            <td width="35%">Dari seorang Ibu bernama</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nama_ibu}}</td>
        </tr>
        <tr>
            <td width="35%">Alamat</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->alamat}}</td>
        </tr>
        <tr>
            <td width="35%">Istri dari</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nama_ayah}}</td>
        </tr>
        <tr>
            <td width="35%">Anak ke </td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->anak_ke}}</td>
        </tr>
    </table>
    <p>Surat keterangan ini dibuat atas dasar yang sebenarnya.</p>
    <div style="position: relative; text-align: center;">
        <div style="position: absolute; right: 60px;">
            <p>Dukuh, {{$data->tgl_now}}</p>
            <p>Kelapa Desa Dukuh</p> 
            <br>
            <br>
            <br>
            <p>---------------------</p>
        </div>
    </div>
</body>
</html>