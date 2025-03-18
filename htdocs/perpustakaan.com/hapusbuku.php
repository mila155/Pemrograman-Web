<?php
include_once("koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM tb_buku WHERE id_buku='$id'";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header('location:index.php');
    } else {
        echo "Hapus Data Gagal";
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
