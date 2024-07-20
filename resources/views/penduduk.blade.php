<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center><p style="font-size: 25px"><b>Surat Keterangan Domisili</b></p></center>
    <p>Yang Bertandatangan di bawah ini Kepala Desa Dukuh Bandungan, dengan ini menerangkan bahwa :</p>
    <table width="100%">
        <tr>
            <td width="35%">Nama Lengkap</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nama_lengkap}}</td>
        </tr>
        <tr>
            <td width="35%">Tempat / Tanggal Lahir</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->tempat_lahir}} / {{$data->tgl_lahir}}</td>
        </tr>
        <tr>
            <td width="35%">Jenis Kelamin</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->jk}}</td>
        </tr>
        <tr>
            <td width="35%">Agama</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->agama}}</td>
        </tr>
        <tr>
            <td width="35%">Profesi</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->profesi_nama}}</td>
        </tr>
        <tr>
            <td width="35%">Alamat</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->alamat}}</td>
        </tr>
        <tr>
            <td width="35%">Nomor Kartu Keluarga</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->no_kk}}</td>
        </tr>
        <tr>
            <td width="35%">No KTP / NIK</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->nik}}</td>
        </tr>
        <tr>
            <td width="35%">Kewarganegaraan</td>
            <td width="5%" align="center">:</td>
            <td width="60%">{{$data->kewarganegaraan}}</td>
        </tr>
    </table>
    <p>Nama tersebut diatas adalah penduduk Desa Dukuh Bandungan dan berdomisilli di alamat tersebut.</p>
    <p>Demikian surat keterangan ini kami buat atas dasar yang sebenarnya dan untuuk dipergunakan sebagaimana mestinya.</p>
    <div style="position: relative; text-align: center;">
        <div style="position: absolute; right: 60px;">
            <p>Dukuh,</p>
            <p>Kelapa Desa Dukuh</p> 
            <br>
            <br>
            <br>
            <p>---------------------</p>
        </div>
    </div>
</body>
</html>