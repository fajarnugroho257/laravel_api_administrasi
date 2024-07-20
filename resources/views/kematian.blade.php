<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center><p style="font-size: 25px"><b>Surat Keterangan Meninggal Dunia</b></p></center>
    <p>Yang bertanda tanga dibawah ini Kepala Desa Dukuh Bandungan, Menerangkan bahwa :</p>
    <table width="100%">
        <tr>
            <td width="35%">Nama</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nama_lengkap}}</td>
        </tr>
        <tr>
            <td width="35%">Tempat / Tanggal Lahir</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->tgl_lahir}}</td>
        </tr>
        <tr>
            <td width="35%">Agama</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->agama}}</td>
        </tr>
        <tr>
            <td width="35%">Pekerjaan</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->profesi_nama}}</td>
        </tr>
        <tr>
            <td width="35%">Alamat</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->alamat}}</td>
        </tr>
        <tr>
            <td width="35%">NO KTP / KK</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nik}} / {{$data->no_kk}}</td>
        </tr>
        <tr>
            <td width="35%">Kewarganegaraan</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->kewarganegaraan}}</td>
        </tr>
    </table>
    <p>Orang tersebut diatas benar – benar sudah meninggal dunia, Demikian keterangan ini dibuat untuk digunakan seperlunya </p>
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