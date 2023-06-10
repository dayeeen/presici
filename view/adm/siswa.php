<style>
  .search-form {
    display: flex;
    align-items: center;
  }

  .search-input {
    width: 30%;
    margin-right: 10px;
  }

  .search-button {
    background: linear-gradient(90deg, rgba(162, 0, 255, 1) 0%, rgba(169, 42, 232, 1) 35%, rgba(124, 42, 232, 1) 100%);
    color: #fff;
    border: solid 1px;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
  }
</style>
<h3 class='page-header'>Daftar Siswa SMAN 1 Cibaduyut</h3>
<form class="search-form" role="search" method="POST">
  <input class="form-control me-2 search-input" type="search" placeholder="Cari NIS atau Nama" aria-label="Search">
  <button class="btn btn-outline-success search-button" type="submit">Cari</button>
</form>

<?php
if (isset($_GET['st'])) {
    if ($_GET['st'] == 1) {
        echo "<div class='alert alert-warning'><strong>Berhasil Disimpan.</strong></div>";
    } elseif ($_GET['st'] == 2) {
        echo "<div class='alert alert-danger'><strong>Gagal Menyimpan.</strong></div>";
    } elseif ($_GET['st'] == 3) {
        echo "<div class='alert alert-success'><strong>Berhasil dihapus.</strong></div>";
    } elseif ($_GET['st'] == 4) {
        echo "<div class='alert alert-danger'><strong>Data tidak boleh kosong.</strong></div>";
    } elseif ($_GET['st'] == 5) {
        echo "<div class='alert alert-danger'><strong>Gagal dihapus.</strong></div>";
    }
}
?>
<div class='table-resfponsive'>
    <?php
    if (isset($_GET['id_siswa'])) {
        if ($_GET['id_siswa'] !== "") {
            $id_user = $_GET['id_siswa'];
            include './view/adm/edit_siswa.php';
        } else {
            header("location:siswa");
        }
    } else {
        $limit = 25;
        $start = 1;
        $slice = 9;
        $self_server = "./siswa";
        $q = "SELECT * FROM detail_user ORDER BY id_user ASC";
        $r = $conn->query($q);
        $totalrows = $r->num_rows;

        if (!isset($_GET['pn']) || !is_numeric($_GET['pn'])) {
            $page = 1;
        } else {
            $page = $_GET['pn'];
        }

        $numofpages = ceil($totalrows / $limit);
        $limitvalue = $page * $limit - ($limit);
        if (isset($_POST['keyword']) && $_POST['keyword'] != null) {
        	$keyword = $_POST['keyword'];
        	$q = "SELECT * FROM detail_user WHERE name_user LIKE '%$keyword%' OR nis_user LIKE '%$keyword%' ORDER BY name_user ASC";
        	$is_search = true;
        } else {
        	$q = "SELECT * FROM detail_user ORDER BY kelas_user ASC, name_user ASC LIMIT $limitvalue, $limit";
        	$is_search = false;
        }
        //jika user nakal paging lebih dari data yg dimiliki
        $cek_page = $conn->query($q);
        if ($cek_page->num_rows != 0) {
            if ($r = $conn->query($q)) {

                if ($r->num_rows !== 0) {
                    echo "<table class='table table-striped' style='width:100%'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>";
                    $query_siswa = $conn->query($q);
                    $no = 0;
                    while ($get_siswa = $query_siswa->fetch_assoc()) {
                        $id_siswa = $get_siswa['id_user'];
                        $name = $get_siswa['name_user'];
                        $school = $get_siswa['kelas_user'];
                        $no++;
                        echo "<tr>
                                <td>$no</td>
                                <td>$name</td>
                                <td><strong>$school</strong></td>
                                <td><a href='siswa&id_siswa=$id_siswa' title='Edit $name'>Edit info</a> &bullet; <a style='cursor:pointer' onclick='hapusSiswa($id_siswa)' >Hapus Siswa</a></td>
                            </tr>";
                    }
                    // $conn->close();
                    echo "</tbody></table>";

                } else {
                    echo "<hr />";
                }

            } else {
                echo "<div class='alert alert-danger'><strong>Terjadi kesalahan.</strong></div>";
            }
            if(!$is_search) {
            	$sql_cek_row = "SELECT*FROM detail_user";
	            $q_cek = $conn->query($sql_cek_row);
	            $hitung = $q_cek->num_rows;
	            if ($hitung >= $limit) {
	                echo "<hr><ul class='pagination'>";
	                if ($page != 1) {
	                    $pageprev = $page - 1;
	                    echo '<li><a href="' . $self_server . '&pn=' . $pageprev . '"><<</a></li>';
	                } else {
	                    echo "<li><a><<</a></li>";
	                }

	                if (($page + $slice) < $numofpages) {
	                    $this_far = $page + $slice;
	                } else {
	                    $this_far = $numofpages;
	                }

	                if (($start + $page) >= 10 && ($page - 10) > 0) {
	                    $start = $page - 10;
	                }

	                for ($i = $start; $i <= $this_far; $i++) {
	                    if ($i == $page) {
	                        echo "<li class='active'><a>" . $i . "</a></li> ";
	                    } else {
	                        echo '<li><a href="' . $self_server . '&pn=' . $i . '">' . $i . '</a></li> ';
	                    }
	                }

	                if (($totalrows - ($limit * $page)) > 0) {
	                    $pagenext = $page + 1;
	                    echo '<li><a href="' . $self_server . '&pn=' . $pagenext . '">>></a></li>';
	                } else {
	                    echo "<li><li><a>>></a></li>";
	                }
	                echo "</ul>";
	            }
            }
            
        } else {
            echo "<div class='alert alert-danger'><strong>Tidak ada data untuk ditampilkan</strong></div>";
        }
    }
    ?>
</div>
<script src="lib/js/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/js/sweetalert2.css">
<script>
    function hapusSiswa(id_siswa) {
        var id = id_siswa;
        swal({
            title: 'Anda Yakin?',
            text: 'Semua data Siswa akan dihapus!', type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            closeOnConfirm: true
        }, function () {
            window.location.href = "./model/proses.php?del_siswa=" + id;
        });
    }
</script>
<!-- <script>
function confirmSubmit() {
    var msg;
    msg = "Apakah Anda Yakin Akan Menghapus Data ? ";
    var agree=confirm(msg);
    if (agree)
    return true ;
    else
    return false ;
}
</script> -->
