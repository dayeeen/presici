<?php 
// Jika sudah absen, maka tidak bisa menambahkan catatan
$this_day = date("d");
$sql = "SELECT * FROM data_absen NATURAL LEFT JOIN tanggal WHERE nama_tgl='$this_day' AND id_user='$_SESSION[id]'";
$query_tday = $conn->query($sql);

if ($query_tday->num_rows > 0) {
    $row = $query_tday->fetch_assoc();
    if ($row['st_ab_lain'] == 'Menunggu') {
        echo "<div class='alert alert-warning'><strong>Tambahkan catatan jika anda sakit atau izin.</strong></div>";
        $disable = "";
    } else {
        echo "<div class='alert alert-warning'><strong>Anda sudah absen hari ini. Tidak bisa menambahkan catatan.</strong></div>";
        $disable = "disabled='disabled'";
    }
} else {
    echo "<div class='alert alert-warning'><strong>Anda belum absen hari ini. Tidak bisa menambahkan catatan.</strong></div>";
    $disable = "disabled='disabled'";
}


?>
<label><h3>Tambah Catatan</h3></label>
<form method="post" action="./model/proses.php" name="form1" id="form1" onSubmit="return valregister()">
	<div class="table-responsive">
	  <table class="table">
	   <tr>
	   	<td style="border-top:none;">
  			<textarea class="form-control" rows="10" name="note" id="note"></textarea>
	   	</td>
	   </tr>
	   <tr>
	   		<td style="border-top:none;">
	   			<button type="submit" name="simpan_note" id="save" onclick="saveForm(); return false;" class="btn btn-success" <?php echo $disable ?>>Simpan</button>
	   		</td>
	   </tr>
	  </table>
	</div>
</form>
<script type="text/javascript">
function valregister(){
            if(form1.note.value==""){
                        alert("Catatan tidak boleh kosong");
                        form1.note.focus();
                        return false;
            }
             return true; 
}
</script>
