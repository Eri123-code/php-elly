<?php
include 'db.php';

$type = $_POST['type'];
$id = $_POST['id'];
$action = $_POST['action'];

if ($type == 'buku') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];

    if ($action == 'edit') {
        $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun_terbit='$tahun_terbit' WHERE id_buku=$id";
    } else {
        $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit) VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit')";
    }
} elseif ($type == 'anggota') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    if ($action == 'edit') {
        $sql = "UPDATE anggota SET nama='$nama', alamat='$alamat', no_telepon='$no_telepon' WHERE id_anggota=$id";
    } else {
        $sql = "INSERT INTO anggota (nama, alamat, no_telepon) VALUES ('$nama', '$alamat', '$no_telepon')";
    }
} elseif ($type == 'peminjaman') {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    if ($action == 'edit') {
        $sql = "UPDATE peminjaman SET id_buku='$id_buku', id_anggota='$id_anggota', tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali' WHERE id_peminjaman=$id";
    } else {
        $sql = "INSERT INTO peminjaman (id_buku, id_anggota, tanggal_pinjam, tanggal_kembali) VALUES ('$id_buku', '$id_anggota', '$tanggal_pinjam', '$tanggal_kembali')";
    }
}

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
