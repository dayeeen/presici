<h1 class="page-header">Absen</h1>
<?php

$this_day = date("d");
$sql = "SELECT * FROM data_absen NATURAL LEFT JOIN tanggal WHERE nama_tgl='$this_day' AND id_user='$_SESSION[id]'";
$query_tday = $conn->query($sql);

// Notifikasi Absen
if (isset($_GET['ab'])) {
       if ($_GET['ab'] == 1) {
              echo "<div class='alert alert-warning'><strong>Terimakasih, Absen berhasil.</strong></div>";
       } elseif ($_GET['ab'] == 2) {
              echo "<div class='alert alert-danger'><strong>Maaf, Absen Gagal. Silahkan Coba Kembali!</strong></div>";
       }
}
echo "<div class='table-responsive'>
           <table class='table table-striped'>
            <thead>
               <tr>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Absen Masuk</th>
                <th>Absen Pulang</th>
                <th class='ab'>Absen Lainnya</th>
                <th>Opsi Lain</th>
               </tr>
            </thead>
            <tbody>";

if ($query_tday->num_rows == 0) {
       $status = './lib/img/warning.png';
       $message = "Anda Belum Mengisi Absen Hari Ini";
       $disable_in = "";
       $disable_free = " disabled='disabled'";
       $disable_out = " disabled='disabled'";
} else {

       $disable_in = " disabled='disabled'";
       $disable_free = "";
       $get_day = $query_tday->fetch_assoc();
       $conn->close();

       if ($get_day['jam_klr'] !== "") {
              $status = './lib/img/complete.png';
              $message = "Absensi hari ini selesai! Terimakasih.";
              $disable_out = " disabled='disable'";
       } else {
              $status = './lib/img/minus.png';
              $message = "Absen Masuk Selesai. Jangan Lupa Absen Pulang !";
              $disable_out = "";
              $disable_free = "";
       }
}
echo "<tr>
        <td class='ba'><img src='$status' width='30px'/></td>
        <td class='ba'><h5>$message</h5></td>
        <td class='ba'><button type='button' class='btn btn-success' onclick=\"window.location.href='./model/proses.php?absen=1';\" $disable_in>Absen Masuk</button></td>
        <td class='ba'><button type='button' class='btn btn-warning' onclick=\"window.location.href='./model/proses.php?absen=6';\" $disable_out>Absen Pulang</button></td>
        <td class='ab'>
        <div class='btn-group' role='group'>
        <button type='button' class='btn btn-danger' style='margin-right: 10px; margin-bottom: 10px; border-radius: 5px;' onclick=\"window.location.href='./model/proses.php?absen=2';\" $disable_in>Sakit</button>
        <button type='button' class='btn btn-danger' style='margin-right: 10px; margin-bottom: 10px; border-radius: 5px;' onclick=\"window.location.href='./model/proses.php?absen=3';\" $disable_in>Izin</button>
        <button type='button' class='btn btn-danger' style='border-radius: 5px;' onclick=\"window.location.href='./model/proses.php?absen=4';\" $disable_in>Alpa</button>
        </div>
        </td>
        <td class='ba'><button type='button' class='btn btn-primary' onclick=\"window.location.href='./model/proses.php?absen=5'\" $disable_free>Batalkan Absen</button></td>
        </tr>";
echo "</table></div>";
echo "<style>
/* Style untuk mode desktop */
.btn {
  
}
/* Style untuk mode mobile */
@media (max-width: 767px) {
       .ab {
       width: 260px;
       display: inline-block;
       justify-content: center;
       align-items: center;
       }
  .btn-danger {
    width: 70px;
    margin-right: 10px;
    margin-bottom: 10px;
  }
}
@media (min-width: 768px) {
       .ab {
       width: 260px;
       display: inline-block;
       justify-content: center;
       align-items: center;
       }
  .btn-danger {
    width: 70px;
    margin-right: 10px;
    margin-bottom: 10px;
  }
}
</style>";
?>