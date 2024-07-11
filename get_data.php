<?php
include 'db.php';

$type = $_POST['type'];
$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($type == 'buku') {
    if ($id) {
        $sql = "SELECT * FROM buku WHERE id_buku = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $judul = $row['judul'];
        $penulis = $row['penulis'];
        $penerbit = $row['penerbit'];
        $tahun_terbit = $row['tahun_terbit'];
        $action = 'edit';
    } else {
        $judul = $penulis = $penerbit = $tahun_terbit = '';
        $action = 'add';
    }
    $form = "
    <form id='dataForm'>
        <input type='hidden' name='type' value='buku'>
        <input type='hidden' name='id' value='$id'>
        <input type='hidden' name='action' value='$action'>
        <label>Judul:</label><br>
        <input type='text' name='judul' value='$judul'><br>
        <label>Penulis:</label><br>
        <input type='text' name='penulis' value='$penulis'><br>
        <label>Penerbit:</label><br>
        <input type='text' name='penerbit' value='$penerbit'><br>
        <label>Tahun Terbit:</label><br>
        <input type='date' name='tahun_terbit' value='$tahun_terbit'><br>
        <input type='submit' value='Simpan'>
        <button type='button' onclick='window.location.href=\"index.php\"'>Batal</button>
    </form>";
} elseif ($type == 'anggota') {
    if ($id) {
        $sql = "SELECT * FROM anggota WHERE id_anggota = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $no_telepon = $row['no_telepon'];
        $action = 'edit';
    } else {
        $nama = $alamat = $no_telepon = '';
        $action = 'add';
    }
    $form = "
    <form id='dataForm'>
        <input type='hidden' name='type' value='anggota'>
        <input type='hidden' name='id' value='$id'>
        <input type='hidden' name='action' value='$action'>
        <label>Nama:</label><br>
        <input type='text' name='nama' value='$nama'><br>
        <label>Alamat:</label><br>
        <input type='text' name='alamat' value='$alamat'><br>
        <label>No Telepon:</label><br>
        <input type='text' name='no_telepon' value='$no_telepon'><br>
        <input type='submit' value='Simpan'>
        <button type='button' onclick='window.location.href=\"index.php\"'>Batal</button>
    </form>";
} elseif ($type == 'peminjaman') {
    if ($id) {
        $sql = "SELECT * FROM peminjaman WHERE id_peminjaman = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $id_buku = $row['id_buku'];
        $id_anggota = $row['id_anggota'];
        $tanggal_pinjam = $row['tanggal_pinjam'];
        $tanggal_kembali = $row['tanggal_kembali'];
        $action = 'edit';
    } else {
        $id_buku = $id_anggota = $tanggal_pinjam = $tanggal_kembali = '';
        $action = 'add';
    }
    $form = "
    <form id='dataForm'>
        <input type='hidden' name='type' value='peminjaman'>
        <input type='hidden' name='id' value='$id'>
        <input type='hidden' name='action' value='$action'>
        <label>ID Buku:</label><br>
        <input type='text' name='id_buku' value='$id_buku'><br>
        <label>ID Anggota:</label><br>
        <input type='text' name='id_anggota' value='$id_anggota'><br>
        <label>Tanggal Pinjam:</label><br>
        <input type='date' name='tanggal_pinjam' value='$tanggal_pinjam'><br>
        <label>Tanggal Kembali:</label><br>
        <input type='date' name='tanggal_kembali' value='$tanggal_kembali'><br>
        <input type='submit' value='Simpan'>
        <button type='button' onclick='window.location.href=\"index.php\"'>Batal</button>
    </form>";
}

echo json_encode(['form' => $form]);

$conn->close();
?>
