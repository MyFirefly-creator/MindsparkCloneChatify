<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Peminjaman Buku</h1>
    <table>
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>User</th>
                <th>Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->user->nama }}</td>
                    <td>{{ $p->buku->NamaBuku }}</td>
                    <td>{{ $p->TanggalPeminjaman }}</td>
                    <td>{{ $p->TanggalPengembalian }}</td>
                    <td>{{ $p->StatusPeminjaman }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
