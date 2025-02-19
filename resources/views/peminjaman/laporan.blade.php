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
            @forelse($peminjaman as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ isset($p->user) ? $p->user->name : 'Data Tidak Ada' }}</td>
                    <td>{{ isset($p->buku) ? $p->buku->NamaBuku : 'Data Tidak Ada' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->TanggalPeminjaman)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d-m-Y') }}</td>
                    <td>{{ $p->StatusPeminjaman }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
