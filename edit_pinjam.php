<?php
include 'koneksi.php';

$arr_tanggal = range(1, 31);
$arr_bulan = [
    1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 
    7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
];

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM Pinjam WHERE No_Pinjam='$id'");
$data = mysqli_fetch_assoc($query);

$tgl_db = explode('-', $data['Tanggal_Pinjam']);
$db_tahun = $tgl_db[0];
$db_bulan = (int)$tgl_db[1];
$db_tanggal = (int)$tgl_db[2];

if (isset($_POST['submit'])) {
    $anggota = $_POST['anggota_id'];
    $tgl_gabung = $_POST['tahun'] . '-' . sprintf("%02d", $_POST['bulan']) . '-' . sprintf("%02d", $_POST['tanggal']);
    $buku = $_POST['buku_id'];
    $keperluan = $_POST['keperluan'];
    $denda = $_POST['denda'];

    mysqli_query($conn, "UPDATE Pinjam SET Anggota_ID='$anggota', Tanggal_Pinjam='$tgl_gabung', Buku_ID='$buku', Keperluan_Pinjam='$keperluan', Denda_Telat='$denda' WHERE No_Pinjam='$id'");
    header("Location: listpinjam.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pinjam</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Form Edit Peminjaman</h2>
    <a href="listpinjam.php" style="display: inline-block; margin-bottom: 15px;">&larr; Kembali ke List</a>
    
    <form method="POST">
        No Pinjam: <input type="text" name="no_pinjam" value="<?= $data['No_Pinjam'] ?>" readonly style="background:#e9ecef; color:#666;">
        
        Nama Anggota: 
        <select name="anggota_id" required>
            <?php
            $q_anggota = mysqli_query($conn, "SELECT * FROM Anggota");
            while($a = mysqli_fetch_assoc($q_anggota)){
                $sel = ($a['Anggota_ID'] == $data['Anggota_ID']) ? 'selected' : '';
                echo "<option value='{$a['Anggota_ID']}' $sel>{$a['Nama_Anggota']}</option>";
            }
            ?>
        </select>
        
        Tanggal Pinjam:
        <div style="display: flex; gap: 8px;">
            <select name="tanggal" required style="flex: 1;">
                <?php foreach($arr_tanggal as $tgl): ?>
                    <option value="<?= $tgl ?>" <?= ($tgl == $db_tanggal) ? 'selected' : '' ?>><?= $tgl ?></option>
                <?php endforeach; ?>
            </select>
            <select name="bulan" required style="flex: 2;">
                <?php foreach($arr_bulan as $angka => $nama): ?>
                    <option value="<?= $angka ?>" <?= ($angka == $db_bulan) ? 'selected' : '' ?>><?= $nama ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="tahun" value="<?= $db_tahun ?>" required style="flex: 1.5;">
        </div>
        
        Judul Buku: 
        <select name="buku_id" required>
            <?php
            $q_buku = mysqli_query($conn, "SELECT * FROM Buku");
            while($b = mysqli_fetch_assoc($q_buku)){
                $sel = ($b['Buku_ID'] == $data['Buku_ID']) ? 'selected' : '';
                echo "<option value='{$b['Buku_ID']}' $sel>{$b['Judul_Buku']}</option>";
            }
            ?>
        </select>
        
        Keperluan: <input type="text" name="keperluan" value="<?= $data['Keperluan_Pinjam'] ?>" required>
        Denda Telat (Rp): <input type="number" name="denda" value="<?= $data['Denda_Telat'] ?>" required>
        
        <button type="submit" name="submit">Submit</button>
        <button type="reset" style="background-color: #7f8c8d; margin-left: 10px;">Clear</button> 
    </form>
</body>
</html>