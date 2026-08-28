<?php
include 'koneksi.php';

$arr_tanggal = range(1, 31);
$arr_bulan = [
    1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 
    7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
];

if (isset($_POST['submit'])) {
    $no_pinjam = $_POST['no_pinjam'];
    $anggota = $_POST['anggota_id'];
    $tgl_gabung = $_POST['tahun'] . '-' . sprintf("%02d", $_POST['bulan']) . '-' . sprintf("%02d", $_POST['tanggal']);
    $buku = $_POST['buku_id'];
    $keperluan = $_POST['keperluan'];
    $denda = $_POST['denda'];

    mysqli_query($conn, "INSERT INTO Pinjam (No_Pinjam, Anggota_ID, Tanggal_Pinjam, Buku_ID, Keperluan_Pinjam, Denda_Telat) 
                         VALUES ('$no_pinjam', '$anggota', '$tgl_gabung', '$buku', '$keperluan', '$denda')");
    header("Location: listpinjam.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Input Pinjam</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Form Input Peminjaman</h2>
    <a href="listpinjam.php" style="display: inline-block; margin-bottom: 15px;">&larr; Kembali ke List</a>
    
    <form method="POST">
        No Pinjam: <input type="text" name="no_pinjam" required placeholder="Contoh: PJ001">
        
        Nama Anggota: 
        <select name="anggota_id" required>
            <option value="">-- Pilih Anggota --</option>
            <?php
            $q_anggota = mysqli_query($conn, "SELECT * FROM Anggota");
            while($a = mysqli_fetch_assoc($q_anggota)){
                echo "<option value='{$a['Anggota_ID']}'>{$a['Nama_Anggota']}</option>";
            }
            ?>
        </select>
        
        Tanggal Pinjam:
        <div style="display: flex; gap: 8px;">
            <select name="tanggal" required style="flex: 1;">
                <option value="">-- Tanggal --</option>
                <?php foreach($arr_tanggal as $tgl): ?>
                    <option value="<?= $tgl ?>"><?= $tgl ?></option>
                <?php endforeach; ?>
            </select>
            <select name="bulan" required style="flex: 2;">
                <option value="">-- Bulan --</option>
                <?php foreach($arr_bulan as $angka => $nama): ?>
                    <option value="<?= $angka ?>"><?= $nama ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="tahun" placeholder="Tahun (Cth: 2026)" required style="flex: 1.5;">
        </div>
        
        Judul Buku: 
        <select name="buku_id" required>
            <option value="">-- Pilih Buku --</option>
            <?php
            $q_buku = mysqli_query($conn, "SELECT * FROM Buku");
            while($b = mysqli_fetch_assoc($q_buku)){
                echo "<option value='{$b['Buku_ID']}'>{$b['Judul_Buku']}</option>";
            }
            ?>
        </select>
        
        Keperluan: <input type="text" name="keperluan" required placeholder="Contoh: Tugas Kuliah">
        Denda Telat (Rp): <input type="number" name="denda" value="0" required>
        
        <button type="submit" name="submit">Submit</button>
        <button type="reset" style="background-color: #7f8c8d; margin-left: 10px;">Clear</button> 
    </form>
</body>
</html>