<html>
<head>
    <title>Export Kategori</title>
</head>
<body>

<h2>Kategori</h2>

<table style="width: 100%" border="1">
    <tr>
        <th>No</th>
        <th>Kategori</th>
    </tr>
    @php
    $no=1;
    @endphp
    @foreach($kategori as $row)
    <tr>
        <td>{{$no++}}</td>
        <td>{{$row->nama_kategori}}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
