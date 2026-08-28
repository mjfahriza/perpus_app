<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM Kategori WHERE Kategori_ID='{$_GET['hapus']}'");
    header("Location: kategori.php");
}

if (isset($_POST['submit'])) {
    $nama = $_POST['Nama_Kategori'];
    if (!empty($_POST['Kategori_ID'])) {
        mysqli_query($conn, "UPDATE Kategori SET Nama_Kategori='$nama' WHERE Kategori_ID='{$_POST['Kategori_ID']}'");
    } else {
        mysqli_query($conn, "INSERT INTO Kategori (Nama_Kategori) VALUES ('$nama')");
    }
    header("Location: kategori.php");
}

$edit = ['Kategori_ID'=>'', 'Nama_Kategori'=>''];
if (isset($_GET['edit'])) {
    $q = mysqli_query($conn, "SELECT * FROM Kategori WHERE Kategori_ID='{$_GET['edit']}'");
    $edit = mysqli_fetch_assoc($q);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Form Kategori Buku</h2>
    <a href="index.php" style="display: inline-block; margin-bottom: 15px;">&larr; Kembali ke Menu</a>
    
    <form method="POST" style="max-width: 400px;">
        <input type="hidden" name="Kategori_ID" value="<?= $edit['Kategori_ID'] ?>">
        Nama Kategori: <input type="text" name="Nama_Kategori" value="<?= $edit['Nama_Kategori'] ?>" required>
        <button type="submit" name="submit">Simpan</button>
        <a href="kategori.php" style="margin-left: 10px;">Batal</a>
    </form>
    
    <table>
        <tr><th>ID</th><th>Nama Kategori</th><th>Aksi</th></tr>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM Kategori");
        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$r['Kategori_ID']}</td>
                <td>{$r['Nama_Kategori']}</td>
                <td style='text-align:center;'>
                    <a href='?edit={$r['Kategori_ID']}'>Edit</a> | 
                    <a href='?hapus={$r['Kategori_ID']}' onclick='return confirm(\"Hapus?\")' style='color: #c0392b;'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>