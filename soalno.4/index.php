<!-- awal php -->
<!-- konek database -->
<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "perpustakaan";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

if (isset($_POST['tambah'])) {
    // Cek apakah data ingin di edit atau disimpan
    if ($_GET['hal'] == "edit") {
        // data akan diedit
        $edit = mysqli_query($koneksi, "UPDATE categories set
                                                            name_categories = '$_POST[tnama]'
                                                            WHERE id_categories = '$_GET[id]'
                                                            ");
        if ($edit) {
            echo "<script>
                    alert('edit data suksess!');
                    document.location='index.php';
                    </script>";
        } else {
            echo "<script>
                    alert('data gagal diedit');
                    document.location='index.php';
                    </script>";
        }
    } else {
        $tambah = mysqli_query($koneksi, "INSERT INTO categories (name_categories)
                                                                    VALUES ('$_POST[tnama]')
                                                                    ");
        if ($tambah) {
            echo "<script>
            alert('simpan data suksess!');
            document.location='index.php';
            </script>";
        } else {
            echo "<script>
            alert('data gagal ditambah');
            document.location='index.php';
            </script>";
        }
    }
}
// pemgecekan get=id jika tombol edit di klik
if (isset($_GET['hal'])) {
    // pengujian jika edit data
    if ($_GET['hal'] == "edit") {
        // tampilkan data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM categories where id_categories = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            // jika data ditemukan, maka akan di tampung kedalam variabel
            $vnama = $data['name_categories'];
        }
    } else if ($_GET['hal'] == "hapus") {
        $hapus = mysqli_query($koneksi, "DELETE FROM categories WHERE id_categories = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
                        alert('data berhasil dihapus');
                        document.location='index.php';
                    </script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Crud_test</title>
</head>

<body>
    <!-- tambah -->
    <h1 class="judul" style="text-align: center;">Soal no.4 CRUD</h1>
    <!-- menu tambah -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tambah Kategori
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="nama">Nama Kategori :</label>
                                <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" id="nama" placeholder="masukan kategori buku">
                            </div>
                            <button type="submit" name="tambah" class="btn btn-primary mt-3">Tambah</button>
                            <button type="submit" class="btn btn-danger mt-3">kosongkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- penutup tambah -->
    <!-- awal card tabel -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Kategori buku
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori buku</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "SELECT * FROM categories order by id_categories desc");
                                while ($data = mysqli_fetch_array($tampil)) :
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['name_categories'] ?></td>
                                        <td>
                                            <a href="index.php?hal=edit&id=<?= $data['id_categories'] ?>" class="btn btn-warning">Edit</a>
                                            <a href="index.php?hal=hapus&id=<?= $data['id_categories'] ?>" class="btn btn-danger" onclick="return confirm('apakah anda ingin menghapus')" class=" btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                            </thead>
                        <?php endwhile; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- penutup card tabel -->
    <script type="text/javascript " src="js/bootstrap.min.js"></script>
</body>

</html>