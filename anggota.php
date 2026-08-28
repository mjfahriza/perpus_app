<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM Anggota WHERE Anggota_ID='{$_GET['hapus']}'");
    header("Location: anggota.php");
}

if (isset($_POST['submit'])) {
    $id = $_POST['Anggota_ID']; $nama = $_POST['Nama_Anggota']; $tgl = $_POST['Tanggal_Lahir_Anggota']; 
    $jk = $_POST['Jenis_Kelamin_Anggota']; $alamat = $_POST['Alamat_Anggota'];
    
    $cek = mysqli_query($conn, "SELECT * FROM Anggota WHERE Anggota_ID='$id'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE Anggota SET Nama_Anggota='$nama', Tanggal_Lahir_Anggota='$tgl', Jenis_Kelamin_Anggota='$jk', Alamat_Anggota='$alamat' WHERE Anggota_ID='$id'");
    } else {
        mysqli_query($conn, "INSERT INTO Anggota VALUES('$id', '$nama', '$tgl', '$jk', '$alamat')");
    }
    header("Location: anggota.php");
}

$edit = ['Anggota_ID'=>'', 'Nama_Anggota'=>'', 'Tanggal_Lahir_Anggota'=>'', 'Jenis_Kelamin_Anggota'=>'Laki-Laki', 'Alamat_Anggota'=>''];
if (isset($_GET['edit'])) {
    $q = mysqli_query($conn, "SELECT * FROM Anggota WHERE Anggota_ID='{$_GET['edit']}'");
    $edit = mysqli_fetch_assoc($q);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Form Pengelolaan Anggota</h2>
    <a href="index.php" style="display: inline-block; margin-bottom: 15px;">&larr; Kembali ke Menu</a>
    
    <form method="POST">
        ID Anggota: <input type="text" name="Anggota_ID" value="<?= $edit['Anggota_ID'] ?>" required <?= isset($_GET['edit']) ? 'readonly style="background:#e9ecef;"' : '' ?>>
        Nama Anggota: <input type="text" name="Nama_Anggota" value="<?= $edit['Nama_Anggota'] ?>" required>
        Tanggal Lahir: <input type="date" name="Tanggal_Lahir_Anggota" value="<?= $edit['Tanggal_Lahir_Anggota'] ?>" required>
        Jenis Kelamin: 
        <select name="Jenis_Kelamin_Anggota">
            <option value="Laki-Laki" <?= ($edit['Jenis_Kelamin_Anggota'] == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
            <option value="Perempuan" <?= ($edit['Jenis_Kelamin_Anggota'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
        </select>
        Alamat: <input type="text" name="Alamat_Anggota" value="<?= $edit['Alamat_Anggota'] ?>" required>
        <button type="submit" name="submit">Simpan Data</button>
        <a href="anggota.php" style="margin-left: 10px;">Batal</a>
    </form>
    
    <table>
        <tr><th>ID</th><th>Nama</th><th>Tgl Lahir</th><th>JK</th><th>Alamat</th><th>Aksi</th></tr>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM Anggota");
        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$r['Anggota_ID']}</td>
                <td>{$r['Nama_Anggota']}</td>
                <td>{$r['Tanggal_Lahir_Anggota']}</td>
                <td>{$r['Jenis_Kelamin_Anggota']}</td>
                <td>{$r['Alamat_Anggota']}</td>
                <td style='text-align:center;'>
                    <a href='?edit={$r['Anggota_ID']}'>Edit</a> | 
                    <a href='?hapus={$r['Anggota_ID']}' onclick='return confirm(\"Hapus data?\")' style='color: #c0392b;'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>