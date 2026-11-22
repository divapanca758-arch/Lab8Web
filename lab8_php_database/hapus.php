<?php

include "koneksi.php";

$id = $_GET['id'] ?? null;

if ($id) {

    $sql = "DELETE FROM data_barang WHERE id_barang = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;

?>