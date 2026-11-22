<?php
include "koneksi.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID barang tidak ditemukan.");
}

if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    $sql = "UPDATE data_barang
            SET nama=?, kategori=?, harga_jual=?,
                harga_beli=?, stok=?
            WHERE id_barang=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt, "ssddii",
        $nama, $kategori, $harga_jual,
        $harga_beli, $stok, $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM data_barang WHERE id_barang=?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak tersedia.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Ubah Barang</h1>

    <form method="POST">

        <label>Nama Barang</label>
        <input type="text" name="nama"
        value="<?= htmlspecialchars($data['nama']); ?>" required>

        <label>Kategori</label>
        <select name="kategori">
            <option value="Komputer"
            <?= $data['kategori'] == 'Komputer' ? 'selected' : ''; ?>>
                Komputer
            </option>

            <option value="Elektronik"
            <?= $data['kategori'] == 'Elektronik' ? 'selected' : ''; ?>>
                Elektronik
            </option>

            <option value="Hand Phone"
            <?= $data['kategori'] == 'Hand Phone' ? 'selected' : ''; ?>>
                Hand Phone
            </option>
        </select>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual"
        value="<?= $data['harga_jual']; ?>" required>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli"
        value="<?= $data['harga_beli']; ?>" required>

        <label>Stok</label>
        <input type="number" name="stok"
        value="<?= $data['stok']; ?>" required>

        <button type="submit" name="submit">Simpan Perubahan</button>

    </form>

    <a href="index.php">Kembali</a>
</div>

</body>
</html>