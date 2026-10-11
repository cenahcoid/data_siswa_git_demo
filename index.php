<?php
require_once 'data_siswa.php';
?>
<html>
    <head>
        <title>Table Siswa</title>
</head>
<body>
    <h1>Table Siswa</h1>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
        </tr>
        <?php
        $data_siswa = new data_siswa();
        $siswa = $data_siswa->get();
        $no = 1;
        foreach ($siswa as $data) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $data->nama . "</td>";
            echo "<td>" . $data->kelas . "</td>";
            echo "<td>" . $data->jenis_kelamin . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>