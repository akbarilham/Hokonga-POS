<?
	$angka_sebelumnya = 2;
	$angka_sekarang = 3;

	for ($i=0; $i <10; $i++) {

		if ($fibo == '') {
		# Di mulai dari angka 2
			$angka_sebelumnya = 0;
			$angka_sekarang = 2;
		}	
		if ($fibo > 0) {
			$angka_sebelumnya = $fibo;
			$angka_sekarang = 3;
		}		

		$fibo = $angka_sekarang + $angka_sebelumnya;
		$angka_sebelumnya = $fibo;
		$angka_sekarang = 3;		

	}
?>