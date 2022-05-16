<?php
	//koneksi database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database ="db_lilik";

	$koneksi= mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//simpan
	if(isset($_POST['bsimpan']))
	{
		//pengujian simpan baru atau edit
		if($_GET['hal'] == "edit"){
			//data diedit disimpan
			$edit = mysqli_query($koneksi," UPDATE tbl_011 set 
												id_011 = '$_POST[bid]',
												nama_011 = '$_POST[bnama]',
												email_011 = '$_POST[bemail]'
											WHERE id_011 = '$_GET[id]'

			");

			//simpan data
			if($edit)
			{
				echo "<script>
					alert('Anda Berhasil Mengedit Data!');
					document.location='index.php';
				</script>";
			}
			else
			{
				echo"<script>
					alert('Maaf Data Yang Anda Edit Gagal Tersimpan!');
					document.location='index.php';
				</script>";
			}

		}else{
			//data baru disimpan
			$simpan = mysqli_query($koneksi,"INSERT INTO tbl_011 
													(id_011,
													nama_011, 
													email_011) 
										VALUES ('$_POST[bid]',
												'$_POST[bnama]',
												'$_POST[bemail]')
			");

			//simpan data
			if($simpan)
			{
				echo "<script>
					alert('simpan data sukses!');
					document.location='index.php';
				</script>";
			}
			else
			{
				echo"<script>
					alert('simpan data gagal!');
					document.location='index.php';
				</script>";
			}
		}
		
	}

	//edit data
	if(isset($_GET['hal'])){

		//pengujian jika edit data
		if($_GET['hal'] == "edit"){
			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi,"SELECT * FROM tbl_011 WHERE id_011= '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data){
				//data ditampung dalam variabel
				$vid = $data['id_011'];
				$vnama = $data['nama_011'];
				$vemail = $data['email_011'];
			}
		}
		else if ($_GET['hal'] =="hapus"){
			//menghapus
			$hapus = mysqli_query($koneksi, "DELETE FROM tbl_011 WHERE id_011 = '$_GET[id]'");
			if($hapus)
			{
				echo "<script>
					alert('hapus data sukses!');
					document.location='index.php';
				</script>";
			}
			else
			{
				echo"<script>
					alert('hapus data gagal!');
					document.location='index.php';
				</script>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="https://w7.pngwing.com/pngs/863/305/png-transparent-contra-costa-county-library-brentwood-hercules-library-martinez-library-tanmen-blue-logo-%D0%B1%D0%B8%D0%B1%D0%BB%D0%B8%D0%BE%D1%82%D0%B5%D0%BA%D0%B0.png" alt="" width="40" height="30" class="d-inline-block align-text-top">
      Trunojoyo
    </a>
  </div>
</nav>
<div class="container">
	<!-- awal card form -->
	<div class="card mt-3">
	  <div class="card-header bg-secondary text-white">
	    FORM LOGIN
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>ID Mahasiswa</label>
	    		<input type="text" name="bid" value="<?=@$vid?>" class="form-control" placeholder="Masukkan ID Mahasiswa" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Nama Mahasiswa</label>
	    		<input type="text" name="bnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama Mahasiswa" required="">
	    	</div>
	    	<div class="form-group">
	    		<label>Nama email mahasiswa</label>
	    		<input type="text" name="bemail" value="<?=@$vemail?>" class="form-control" placeholder="Masukkan email" required="">
	    	</div>
	    	<button type="submit" class="btn btn-success" name="bsimpan">SIMPAN</button>
	    	<button type="reset" class="btn btn-warning" name="briset">KOSONGKAN</button>
	    </form>
	  </div>
	</div>
	<!-- end card -->

	<!-- awal card table -->
	<div class="card mt-3">
	  <div class="card-header bg-secondary text-white">
	    DAFTAR BUKU
	  </div>
	  <div class="card-body">
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>ID BUKU</th>
	    		<th>NAMA</th>
	    		<th>EMAIL</th>
	    	</tr>
	    	<?php
	    		$tampil =mysqli_query($koneksi, "SELECT *from tbl_011 order by id_011");
	    		while($data = mysqli_fetch_array($tampil)):
	    	?>
	    	<tr>
	    		<td><?=$data['id_011']?></td>
	    		<td><?=$data['nama_011']?></td>
	    		<td><?=$data['email_011']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_011']?>" class="btn btn-warning"> Edit</a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_011']?>" onclick= "return confirm('Apakah yakin ingin menghapus data ini?')"
	    			class="btn btn-danger"> Hapus</a>
	    		</td>
	    	</tr>
	    	<?php endwhile; //penutup perulangan while ?> 
	    </table>
	  </div>
	</div>
	<!-- end card table -->
</div> 
<script type="text/javascript" src="bootstrap.min.js"></script>
</body>
</html>