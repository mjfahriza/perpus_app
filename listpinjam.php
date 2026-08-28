<?php
include 'koneksi.php';

if (isset($_GET['del'])) {
    $id_hapus = $_GET['del'];
    mysqli_query($conn, "DELETE FROM Pinjam WHERE No_Pinjam='$id_hapus'");
    header("Location: listpinjam.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>List Data Pinjam</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Data Peminjaman Buku</h2>
    <a href="index.php" style="display: inline-block; margin-bottom: 15px;">&larr; Kembali ke Menu</a><br>
    
    <a href="input_pinjam.php" style="display: inline-block; background-color: #2c3e50; color: #ffffff; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; margin-bottom: 15px;">Add New Data</a>
    
    <table>
        <tr>
            <th>No Pinjam</th>
            <th>Tanggal</th>
            <th>Nama Anggota</th>
            <th>Usia</th>
            <th>Jenis Kelamin</th>
            <th>Keperluan</th>
            <th>Nama Kategori</th>
            <th>Judul Buku</th>
            <th>Denda</th>
            <th>Action</th>
        </tr>
        <?php
        $query = "SELECT p.No_Pinjam, p.Tanggal_Pinjam, a.Nama_Anggota, 
                  TIMESTAMPDIFF(YEAR, a.Tanggal_Lahir_Anggota, CURDATE()) AS Usia, 
                  a.Jenis_Kelamin_Anggota, p.Keperluan_Pinjam, 
                  k.Nama_Kategori, b.Judul_Buku, p.Denda_Telat 
                  FROM Pinjam p 
                  JOIN Anggota a ON p.Anggota_ID = a.Anggota_ID 
                  JOIN Buku b ON p.Buku_ID = b.Buku_ID 
                  JOIN Kategori k ON b.Kategori_ID = k.Kategori_ID";
                  
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $denda = ($row['Denda_Telat'] == 0) ? "0" : number_format($row['Denda_Telat'], 0, ',', '.');
                echo "<tr>
                    <td>{$row['No_Pinjam']}</td>
                    <td>{$row['Tanggal_Pinjam']}</td>
                    <td>{$row['Nama_Anggota']}</td>
                    <td style='text-align:center;'>{$row['Usia']} Thn</td>
                    <td>{$row['Jenis_Kelamin_Anggota']}</td>
                    <td>{$row['Keperluan_Pinjam']}</td>
                    <td>{$row['Nama_Kategori']}</td>
                    <td>{$row['Judul_Buku']}</td>
                    <td>Rp {$denda}</td>
                    <td style='text-align:center;'>
                        <a href='edit_pinjam.php?id={$row['No_Pinjam']}'>Edit</a> | 
                        <a href='listpinjam.php?del={$row['No_Pinjam']}' onclick='return confirm(\"Hapus data?\")' style='color: #c0392b;'>Del</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='10' style='text-align:center; padding: 20px; color: #777;'>Belum ada data peminjaman.</td></tr>";
        }
        ?>
    </table>
</body>
</html>