<style>
    .pagination>.active>a,
    .pagination>.active>a:hover {
        border-color: rgb(162, 0, 255);
        background: linear-gradient(90deg, rgba(162, 0, 255, 1) 0%, rgba(169, 42, 232, 1) 35%, rgba(124, 42, 232, 1) 100%);
    }

    .pagination>li>a,
    .pagination>li>a:hover {
        color: rgb(162, 0, 255);
    }
    .aksi>a {
        color: rgb(162, 0, 255);
    }
</style>
<div class='table-responsive'>
	<?php
	if (isset($_GET['id_siswa'])) {
		if ($_GET['id_siswa'] !== "") {
			$id_user = $_GET['id_siswa'];            
			include './view/detail_absen.php';
		} else {
			header("location:absensi");
		}
	} else {
        echo "<h3 class='page-header'>Detail Absensi Siswa SMAN 1 Cibaduyut</h3>";
		$limit = 25;
        $start = 1;
        $slice = 9;
        $self_server = "./absensi";
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

        $q = "SELECT * FROM detail_user ORDER BY kelas_user ASC, name_user ASC LIMIT $limitvalue, $limit";
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
                            <th>Riwayat Absensi</th>
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
                                <td class='aksi'><a href='absensi&id_siswa=$id_siswa' title='Absensi $name'>Lihat Absensi</a></td>
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
        } else {
            echo "<div class='alert alert-danger'><strong>Tidak ada data untuk ditampilkan</strong></div>";
        }
    }
    ?>
</div>