<!DOCTYPE html>
<html>

<head>
    <title>Data Kunjungan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f3f3f3;
        }
    </style>
</head>

<body>
    <h3>Data Kunjungan</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>ID Kunjungan</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visits as $visit)
                <tr>
                    <td>{{ $visit->id }}</td>
                    <td>{{ $visit->visitor->full_name }}</td>
                    <td>{{ $visit->visitor->identity_number }}</td>
                    <td>{{ $visit->visit_id }}</td>
                    <td>{{ $visit->purpose }}</td>
                    <td>{{ $visit->visit_date }}</td>
                    <td>{{ $visit->check_in }}</td>
                    <td>{{ $visit->check_out ?? '-' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $visit->status)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
