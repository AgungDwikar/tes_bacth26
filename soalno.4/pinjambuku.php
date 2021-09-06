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
        $edit = mysqli_query($koneksi, "UPDATE books set
                                                            name_books = '$_POST[tbuku]',
                                                            stok = '$_POST[tstok]',
                                                            gambar = '$_POST[timage]',
                                                            deskripsi = '$_POST[tdeskripsi]',
                                                            kategory_id = '$_POST[tkategoribuku]'
                                                            WHERE id_books = '$_GET[id]'
                                                            ");
        if ($edit) {
            echo "<script>
                    alert('edit suksess!');
                    document.location='index.php';
                </script>";
        } else {
            echo "<script>
                    alert('edit gagal');
                    document.location='index.php';
                </script>";
        }
    } else {
        // data akan disimpan baru
        $tambah = mysqli_query($koneksi, "INSERT INTO books (name_books, stok, gambar, deskripsi, category_id)
                                                            VALUES ('$_POST[tbuku]',
                                                                         '$_POST[tstok]', 
                                                                         '$_POST[timage]', 
                                                                         '$_POST[tdeskripsi]',
                                                                          '$_POST[tkategoribuku]')
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
        $tampil = mysqli_query($koneksi, "SELECT * FROM books where id_books = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            // jika data ditemukan, maka akan di tampung kedalam variabel
            $vnamabuku = $data['name_books'];
            $vstok = $data['stok'];
            $vimage = $data['gambar'];
            $vdeskripsi = $data['deskripsi'];
            $vkategoribuku = $data['category_id'];
        }
    } else if ($_GET['hal'] == "hapus") {
        $hapus = mysqli_query($koneksi, "DELETE FROM books WHERE id_books = '$_GET[id]'");
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <h1 class="judul " style="text-align: center;">Soal no.4 CRUD</h1>
    <!-- menu tambah -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tambah buku
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="nama">Nama buku</label>
                                <input type="text" name="tbuku" value="<?= @$vnamabuku ?>" class="form-control" id="nama" placeholder="masukan nama buku">
                            </div>
                            <div class="form-group mt-3">
                                <label for="stok">Stok</label>
                                <input type="text" name="tstok" value="<?= @$vstok ?>" class=" form-control" id="stok" placeholder="masukan stok buku">
                            </div>
                            <div class="form-group mt-3">
                                <label for="gambar">gambar</label>
                                <input type="file" name="timage" value="<?= @$vimage ?>" class="form-control" id="gambar" placeholder="masukan image buku">
                            </div>
                            <div class="form-group mt-3">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="tdeskripsi" value="<?= @$vdeskripsi ?>" class="form-control" id="deskripsi" placeholder="masukan deskripsi buku">
                            </div>
                            <div class="form-group mt-3">
                                <label for="kategoribuku">Kategori buku</label>
                                <input type="text" name="tkategoribuku" value="<?= @$vkategoribuku ?>" class="form-control" id="kategoribuku" placeholder="masukan kategori buku">
                            </div>
                            <button type="submit" name="tambah" class="btn btn-primary mt-3">Tambah</button>
                            <button type="submit" class="btn btn-danger mt-3">Kosongkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- penutup tambah -->
    <!-- awal card tabel  -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Data Buku
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Buku</th>
                                    <th>Stok</th>
                                    <th>gambar</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori Buku</th>
                                    <th>Aksi</th>

                                </tr>
                                <?php
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "SELECT * FROM books order by id_books desc");
                                while ($data = mysqli_fetch_array($tampil)) :
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['name_books'] ?></td>
                                        <td><?= $data['stok'] ?></td>
                                        <td><img src="img/<?= $data['gambar'] ?>" width="100"></td>
                                        <td><?= $data['deskripsi'] ?></td>
                                        <td><?= $data['category_id'] ?></td>
                                        <td>
                                            <a href="index.php?hal=edit&id=<?= $data['id_books'] ?>" class="btn btn-warning">Edit</a>
                                            <a href="index.php?hal=hapus&id=<?= $data['id_books'] ?>" onclick="return confirm('apakah anda ingin menghapus')" class="btn btn-danger">Hapus</a>
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
    <!-- ahir card tabel -->
    <script type="text/javascript " src="js/bootstrap.min.js"></script>
</body>

</html>