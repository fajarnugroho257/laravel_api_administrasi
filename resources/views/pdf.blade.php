<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center><p>Data Peofesi Warga</p></center>
    <table boder="1" width="100%">
        <tr>
            <td width="10%" align="center">No</td>
            <td width="90%" align="center">Nama Profesi</td>
        </tr>
        @php
        $no = 1;
        @endphp
        @foreach ($datas as $data)
            <tr>
                <td  align="center">{{$no++}}</td>
                <td>{{$data['profesi_nama']}}</td>
            </tr>
        @endforeach 
    </table>
    
</body>
</html>
<style>
    table, th, td {
        border: 1px solid black;
    }
</style>