<?php
$nama = $_POST['type'] ?? '';
$simpan = $_POST['simpan'] ?? '';

$ket_alert = '';
$ket_data = '';
$no = 0;

if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM type WHERE type = '$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket_alert = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO type(type) VALUES('$nama')");
        if ($query) {
            $ket_alert = "<div class='alert alert-success'>Data Tersimpan</div>";
        } else {
            $ket_alert = "<div class='alert alert-danger'>Memasukan Data Gagal</div>";
        }
    }
}

// Tampilkan data
$s = mysqli_query($koneksi, "SELECT * FROM type");
while ($data = mysqli_fetch_array($s)) {
    $no++;
    $ket_data .= "
        <tr class='text-center'>
            <td>$no</td>
            <td>{$data['id_type']}</td>
            <td>{$data['type']}</td>
            <td><a href='index.php?url=etype&id={$data['id_type']}'>Edit</a></td>
        </tr>
    ";
}

// Output seluruh halaman
$isi = "
<section class='content-header'>
  <div class='container-fluid'>
    <h1>Type Lemari</h1>
  </div>
</section>

<section class='content'>
  <div class='container-fluid'>
    $ket_alert
    <form method='post' class='form-horizontal' id='quickForm'>
      <div class='card card-default'>
        <div class='card-header'>
          <h3 class='card-title'>Tambah Type Lemari</h3>
        </div>
        <div class='card-body'>
          <div class='form-group row'>
            <label for='typeInput' class='col-sm-2 offset-sm-2 col-form-label'>Type Lemari</label>
            <div class='col-sm-3'>
              <input type='text' name='type' class='form-control' id='typeInput' required autofocus>
            </div>
          </div>
          <div class='form-group row'>
            <div class='col-sm-5 offset-sm-4'>
              <input type='submit' name='simpan' class='btn btn-success' value='Masukkan'>
            </div>
          </div>	
        </div>
      </div>
    </form>
  </div>
</section>

<section class='content'>
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-sm-12'>
        <div class='card'>
          <div class='card-header'>
            <h3 class='card-title'>Data Type Lemari</h3>
          </div>
          <div class='card-body'>
            <table id='example1' class='table table-bordered table-striped'>
              <thead>
                <tr class='text-center'>
                  <th>No</th>
                  <th>ID Type</th>
                  <th>Nama Type Lemari</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                $ket_data
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Fokus ke input saat halaman dimuat
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('typeInput').focus();
  });
</script>
";
?>
