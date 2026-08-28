<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM Buku WHERE Buku_ID='{$_GET['hapus']}'");
    header("Location: buku.php");
}

if (isset($_POST['submit'])) {
    $judul = $_POST['Judul_Buku'];
    $kategori = $_POST['Kategori_ID'];
    
    if (!empty($_POST['Buku_ID'])) {
        mysqli_query($conn, "UPDATE Buku SET Judul_Buku='$judul', Kategori_ID='$kategori' WHERE Buku_ID='{$_POST['Buku_ID']}'");
    } else {
        mysqli_query($conn, "INSERT INTO Buku (Judul_Buku, Kategori_ID) VALUES ('$judul', '$kategori')");
    }
    header("Location: buku.php");
}

$edit = ['Buku_ID'=>'', 'Judul_Buku'=>'', 'Kategori_ID'=>''];
if (isset($_GET['edit'])) {
    $q = mysqli_query($conn, "SELECT * FROM Buku WHERE Buku_ID='{$_GET['edit']}'");
    $edit = mysqli_fetch_assoc($q);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Form Pengelolaan Buku</h2>
    <a href="index.php" style="display: inline-block; margin-bottom: 15px;">&larr; Kembali ke Menu</a>
    
    <form method="POST">
        <input type="hidden" name="Buku_ID" value="<?= $edit['Buku_ID'] ?>">
        Judul Buku: <input type="text" name="Judul_Buku" value="<?= $edit['Judul_Buku'] ?>" required>
        Kategori: 
        <select name="Kategori_ID" required>
            <option value="">-- Pilih Kategori --</option>
            <?php 
            $k = mysqli_query($conn, "SELECT * FROM Kategori"); 
            while($rk = mysqli_fetch_assoc($k)){
                $sel = ($rk['Kategori_ID'] == $edit['Kategori_ID']) ? 'selected' : '';
                echo "<option value='{$rk['Kategori_ID']}' $sel>{$rk['Nama_Kategori']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="submit">Simpan</button>
        <a href="buku.php" style="margin-left: 10px;">Batal</a>
    </form>
    
    <table>
        <tr><th>ID</th><th>Judul Buku</th><th>Kategori</th><th>Aksi</th></tr>
        <?php
        $res = mysqli_query($conn, "SELECT Buku.*, Kategori.Nama_Kategori FROM Buku JOIN Kategori ON Buku.Kategori_ID = Kategori.Kategori_ID");
        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$r['Buku_ID']}</td>
                <td>{$r['Judul_Buku']}</td>
                <td>{$r['Nama_Kategori']}</td>
                <td style='text-align:center;'>
                    <a href='?edit={$r['Buku_ID']}'>Edit</a> | 
                    <a href='?hapus={$r['Buku_ID']}' onclick='return confirm(\"Hapus?\")' style='color: #c0392b;'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>