<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>

<h3>Hey Sir/Madam,</h3>
<p>Berikut Daftar {{$jenis_izin}} Warning dan Expired untuk area {{$area}}.</p>
<div class="table-responsive m-t-20">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=0; ?>
        @foreach($data as $res)
        <tr>
            <td>
                {{ $no }}
            </td>
            <td>
              @if ($jenis_izin == 'Permits')
                {{ $res->no_surat_keputusan}}
              @elseif ($jenis_izin == 'Mou')
                {{ $res->nomor_kontrak}} 
              @else
                {{ $res->no_polisi}}
              @endif
            </td>
        </tr>
        <?php $no++; ?>
        @endforeach
        </tbody>
    </table>
</div>
<p>Mohon segera meng-update lisensi yang sudah melewati masa berlakunya melalui link: <a href="{{$link}}">{{$link}}</a></p>
<p>Untuk informasi lebih lanjut dapat menghubungi vie email berikut: <a href="mailto:{{$contact_email}}">{{$contact_email}}</a> - {{$contact_name}}</p>
<p>Email ini terkirim secara otomatis melalui LCS, mohon untuk tidak me-reply email ini.</p>
<p>@2018 All Right Reserved | Licensi Control System - GA Operation 3</p>
</body>
</html>
