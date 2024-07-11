<?php
include 'db.php';

// Mengambil data dari tabel buku
$sql_buku = "SELECT * FROM buku";
$result_buku = $conn->query($sql_buku);

// Mengambil data dari tabel anggota
$sql_anggota = "SELECT * FROM anggota";
$result_anggota = $conn->query($sql_anggota);

// Mengambil data dari tabel peminjaman
$sql_peminjaman = "SELECT peminjaman.*, buku.judul, anggota.nama FROM peminjaman 
                   JOIN buku ON peminjaman.id_buku = buku.id_buku 
                   JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota";
$result_peminjaman = $conn->query($sql_peminjaman);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Perpustakaan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons a, .action-buttons button {
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #000;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
        }
        .action-buttons a.delete, .action-buttons button.delete {
            background-color: #f44336;
        }
        #formModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        #formContent {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .add-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function deleteData(type, id) {
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: { type: type, id: id },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }

        function showEditForm(type, id) {
            $.ajax({
                url: 'get_data.php',
                type: 'POST',
                data: { type: type, id: id },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#formContent').html(data.form);
                    $('#formModal').show();
                }
            });
        }

        function showAddForm(type) {
            $.ajax({
                url: 'get_data.php',
                type: 'POST',
                data: { type: type },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#formContent').html(data.form);
                    $('#formModal').show();
                }
            });
        }

        function closeModal() {
            $('#formModal').hide();
        }

        $(document).on('submit', '#dataForm', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'add_edit.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response);
                    $('#formModal').hide();
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });
    </script>
</head>
<body>

<h2>Data Buku</h2>
<button class="add-button" onclick="showAddForm('buku')">Tambah Buku</button>
<table>
    <tr>
        <th>ID Buku</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Penerbit</th>
        <th>Tahun Terbit</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = $result_buku->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id_buku']; ?></td>
        <td><?php echo $row['judul']; ?></td>
        <td><?php echo $row['penulis']; ?></td>
        <td><?php echo $row['penerbit']; ?></td>
        <td><?php echo $row['tahun_terbit']; ?></td>
        <td class="action-buttons">
            <button onclick="showEditForm('buku', <?php echo $row['id_buku']; ?>)">Edit</button>
            <button class="delete" onclick="deleteData('buku', <?php echo $row['id_buku']; ?>)">Hapus</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Data Anggota</h2>
<button class="add-button" onclick="showAddForm('anggota')">Tambah Anggota</button>
<table>
    <tr>
        <th>ID Anggota</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No Telepon</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = $result_anggota->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id_anggota']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['alamat']; ?></td>
        <td><?php echo $row['no_telepon']; ?></td>
        <td class="action-buttons">
            <button onclick="showEditForm('anggota', <?php echo $row['id_anggota']; ?>)">Edit</button>
            <button class="delete" onclick="deleteData('anggota', <?php echo $row['id_anggota']; ?>)">Hapus</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Data Peminjaman</h2>
<button class="add-button" onclick="showAddForm('peminjaman')">Tambah Peminjaman</button>
<table>
    <tr>
        <th>ID Peminjaman</th>
        <th>Judul Buku</th>
        <th>Nama Anggota</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = $result_peminjaman->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id_peminjaman']; ?></td>
        <td><?php echo $row['judul']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['tanggal_pinjam']; ?></td>
        <td><?php echo $row['tanggal_kembali']; ?></td>
        <td class="action-buttons">
            <button onclick="showEditForm('peminjaman', <?php echo $row['id_peminjaman']; ?>)">Edit</button>
            <button class="delete" onclick="deleteData('peminjaman', <?php echo $row['id_peminjaman']; ?>)">Hapus</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Modal untuk form tambah dan edit -->
<div id="formModal">
    <div id="formContent">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Form content will be loaded here -->
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
