<?php
include 'db.php';

$type = $_POST['type'];
$id = $_POST['id'];

if ($type == 'buku') {
    $sql = "DELETE FROM buku WHERE id_buku = $id";
} elseif ($type == 'anggota') {
    $sql = "DELETE FROM anggota WHERE id_anggota = $id";
} elseif ($type == 'peminjaman') {
    $sql = "DELETE FROM peminjaman WHERE id_peminjaman = $id";
}

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus";
} else {
    echo "Error menghapus data: " . $conn->error;
}

$conn->close();
?>
