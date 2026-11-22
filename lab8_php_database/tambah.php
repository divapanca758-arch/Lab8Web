<?php
include "koneksi.php";

if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    $gambar = "";

    if (isset($_FILES['file_gambar']) &&
        $_FILES['file_gambar']['error'] == 0) {

        $namaFile = basename($_FILES['file_gambar']['name']);
        $tujuan = "gambar/" . $namaFile;

        if (move_uploaded_file(
            $_FILES['file_gambar']['tmp_name'],
            $tujuan
        )) {
            $gambar = $tujuan;
        }
    }

    $sql = "INSERT INTO data_barang
            (nama, kategori, harga_jual, harga_beli, stok, gambar)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt, "ssddis",
        $nama, $kategori, $harga_jual,
        $harga_beli, $stok, $gambar
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Tambah Barang</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Barang</label>
        <input type="text" name="nama" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <option value="Komputer">Komputer</option>
            <option value="Elektronik">Elektronik</option>
            <option value="Hand Phone">Hand Phone</option>
        </select>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" required>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <label>File Gambar</label>
        <input type="file" name="file_gambar"
               accept="image/*">

        <button type="submit" name="submit">Simpan</button>

    </form>

    <a href="index.php">Kembali</a>
</div>

</body>
</html>