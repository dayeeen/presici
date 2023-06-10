<?php
if (isset($_SESSION['sw'])) {
	$sql = "SELECT*FROM detail_user WHERE id_user='$_SESSION[id]'";
	$query = $conn->query($sql);
	$get_user = $query->fetch_assoc();
	$name = $get_user['name_user'];
	$id_user = $get_user['id_user'];

	echo "<h1 class='page-header'>Selamat datang, $name</h1>";

	if ($conn->query("SELECT*FROM data_absen WHERE id_user='$id_user'")->num_rows !== 0) {
		$no = 0;
		$query_month = $conn->query("SELECT*FROM bulan ORDER BY id_bln DESC");
		while ($get_month = $query_month->fetch_assoc()) {
			$month = $get_month['nama_bln'];
			$id_month = $get_month['id_bln'];

			$h = $conn->query("SELECT COUNT(id_user) AS jml_hadir FROM data_absen WHERE id_user = $id_user AND (st_jam_msk = 'Dikonfirmasi' OR st_jam_msk = 'Terlambat') AND st_jam_klr = 'Dikonfirmasi' AND id_bln = $id_month");
			$i = $conn->query("SELECT COUNT(id_user) AS jml_izin FROM data_absen WHERE id_user = $id_user AND absen_lainnya = 'Izin' AND st_ab_lain = 'Dikonfirmasi' AND id_bln = $id_month");
			$s = $conn->query("SELECT COUNT(id_user) AS jml_sakit FROM data_absen WHERE id_user = $id_user AND absen_lainnya = 'Sakit' AND st_ab_lain = 'Dikonfirmasi' AND id_bln = $id_month");
			$a = $conn->query("SELECT COUNT(id_user) AS jml_alpa FROM data_absen WHERE id_user = $id_user AND (absen_lainnya = 'Alpa' OR st_jam_msk = 'Ditolak' OR st_jam_klr = 'Ditolak' OR st_ab_lain = 'Ditolak') AND id_bln = $id_month");
			$hadir = $h->fetch_assoc()['jml_hadir'];
			$izin = $i->fetch_assoc()['jml_izin'];
			$sakit = $s->fetch_assoc()['jml_sakit'];
			$alpa = $a->fetch_assoc()['jml_alpa'];

			$query_absen = $conn->query("SELECT*FROM data_absen NATURAL LEFT JOIN bulan NATURAL JOIN hari NATURAL JOIN tanggal WHERE id_bln='$id_month' AND id_user='$id_user'");

			$cek = $query_absen->num_rows;
			if ($cek !== 0) {
				echo "<h3 class='sub-header'>Absensiku - $month </h3>";
				echo "<h4 class='sub-header'><strong>Kehadiran:</strong> $hadir, <strong>Izin:</strong> $izin, <strong>Sakit:</strong> $sakit, <strong>Alpa:</strong> $alpa.</h4>";
				echo "<div class='table-responsive'>
			           <table class='table table-striped'>
			            <thead>
			               <tr>
			                <th>No</th>
			                <th>Hari, Tanggal</th>
			                <th>Jam Masuk</th>
			                <th>Status</th>
			                <th>Jam Keluar</th>
			                <th>Status</th>
							<th>Absen Lainnya</th>
							<th>Status</th>
			               </tr>
			            </thead>
			            <tbody>";
				$no = 0;
				while ($get_absen = $query_absen->fetch_assoc()) {
					$no++;
					$date = "$get_absen[nama_hri], $get_absen[nama_tgl] $get_absen[nama_bln] " . date("Y");
					$time_in = "$get_absen[jam_msk]";
					if ($get_absen['jam_klr'] === "") {
						$time_out = "<strong>Belum Absen</strong>";
					} else {
						$time_out = "$get_absen[jam_klr]";
					}
					$st_in = "$get_absen[st_jam_msk]";
					$st_out = "$get_absen[st_jam_klr]";
					$ab_lain = "$get_absen[absen_lainnya]";
					$st_ab_lain = "$get_absen[st_ab_lain]";
					echo "<tr>
			                <td>$no</td>
			                <td>$date</td>
			                <td>$time_in</td>
			                <td>$st_in</td>
			                <td>$time_out</td>
			                <td>$st_out</td>
							<td>$ab_lain</td>
							<td>$st_ab_lain</td>
			              </tr>";
				}
				echo "</table></div>";
			}
		}
		$conn->close();
	} else {
		echo "<div class='alert alert-warning'><strong>Tidak ada Absensi untuk ditampilkan.</strong></div>";
	}
} else {
	$id_siswa = mysqli_real_escape_string($conn, $_GET['id_siswa']);
	$query = $conn->query("SELECT*FROM detail_user WHERE id_user='$id_siswa'");
	$get_user = $query->fetch_assoc();
	$name = $get_user['name_user'];
	$kelas = $get_user['kelas_user'];
	$id_user = $get_user['id_user'];
	echo "<h3 class='page-header'>$name - $kelas</h2>";
	if ($conn->query("SELECT*FROM data_absen WHERE id_user='$id_user'")->num_rows !== 0) {
		$no = 0;
		$query_month = $conn->query("SELECT*FROM bulan ORDER BY id_bln DESC");
		while ($get_month = $query_month->fetch_assoc()) {
			$month = $get_month['nama_bln'];
			$year = date("Y");
			$id_month = $get_month['id_bln'];

			$h = $conn->query("SELECT COUNT(id_user) AS jml_hadir FROM data_absen WHERE id_user = $id_siswa AND (st_jam_msk = 'Dikonfirmasi' OR st_jam_msk = 'Terlambat') AND st_jam_klr = 'Dikonfirmasi' AND id_bln = $id_month");
			$i = $conn->query("SELECT COUNT(id_user) AS jml_izin FROM data_absen WHERE id_user = $id_siswa AND absen_lainnya = 'Izin' AND st_ab_lain = 'Dikonfirmasi' AND id_bln = $id_month");
			$s = $conn->query("SELECT COUNT(id_user) AS jml_sakit FROM data_absen WHERE id_user = $id_siswa AND absen_lainnya = 'Sakit' AND st_ab_lain = 'Dikonfirmasi' AND id_bln = $id_month");
			$a = $conn->query("SELECT COUNT(id_user) AS jml_alpa FROM data_absen WHERE id_user = $id_siswa AND (absen_lainnya = 'Alpa' OR st_jam_msk = 'Ditolak' OR st_jam_klr = 'Ditolak' OR st_ab_lain = 'Ditolak') AND id_bln = $id_month");
			$hadir = $h->fetch_assoc()['jml_hadir'];
			$izin = $i->fetch_assoc()['jml_izin'];
			$sakit = $s->fetch_assoc()['jml_sakit'];
			$alpa = $a->fetch_assoc()['jml_alpa'];

			$query_absen = $conn->query("SELECT*FROM data_absen NATURAL LEFT JOIN bulan NATURAL JOIN hari NATURAL JOIN tanggal WHERE id_bln='$id_month' AND id_user='$id_user'");

			$cek = $query_absen->num_rows;
			if ($cek !== 0) {
				echo "<h4 class='sub-header'><strong>Bulan:</strong> $month $year </h4>";
				echo "<h4 class='sub-header'><strong>Kehadiran:</strong> $hadir, <strong>Izin:</strong> $izin, <strong>Sakit:</strong> $sakit, <strong>Alpa:</strong> $alpa.</h4>";
				echo "<div class='table-responsive'>
			           <table class='table table-striped'>
			            <thead>
			               <tr>
			                <th>No</th>
			                <th>Hari, Tanggal</th>
			                <th>Jam Masuk</th>
			                <th>Status</th>
			                <th>Jam Keluar</th>
			                <th>Status</th>
							<th>Absen Lainnya</th>
							<th>Status</th>
			               </tr>
			            </thead>
			            <tbody>";
				$no = 0;
				while ($get_absen = $query_absen->fetch_assoc()) {
					$no++;
					$date = "$get_absen[nama_hri], $get_absen[nama_tgl] $get_absen[nama_bln] " . date("Y");
					$time_in = "$get_absen[jam_msk]";
					if ($get_absen['jam_klr'] === "") {
						$time_out = "<strong>Belum Absen</strong>";
					} else {
						$time_out = "$get_absen[jam_klr]";
					}
					$st_in = "$get_absen[st_jam_msk]";
					$st_out = "$get_absen[st_jam_klr]";
					echo "<tr>
			                <td>$no</td>
			                <td>$date</td>
			                <td>$time_in</td>
			                <td><strong>$st_in</strong></td>
			                <td>$time_out</td>
			                <td><strong>$st_out</strong></td>
							<td>$get_absen[absen_lainnya]</td>
							<td><strong>$get_absen[st_ab_lain]</strong></td>
			              </tr>";
				}
				echo "</table></div>";
			}
		}
		$conn->close();
	} else {
		echo "<div class='alert alert-warning'><strong>Tidak ada Absensi untuk ditampilkan.</strong></div>";
	}
}
?>