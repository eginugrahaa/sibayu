<?php

	if ( ! function_exists('bulan'))
	{
		function bulan($bln)
		{
			switch ($bln)
			{
				case 1:
					return "Januari";
					break;
				case 2:
					return "Februari";
					break;
				case 3:
					return "Maret";
					break;
				case 4:
					return "April";
					break;
				case 5:
					return "Mei";
					break;
				case 6:
					return "Juni";
					break;
				case 7:
					return "Juli";
					break;
				case 8:
					return "Agustus";
					break;
				case 9:
					return "September";
					break;
				case 10:
					return "Oktober";
					break;
				case 11:
					return "November";
					break;
				case 12:
					return "Desember";
					break;
			}
		}
	}

	if( ! function_exists('hari'))
	{
		function hari($hari)
		{
			switch ($hari) 
			{
				case 1:
					return "Senin";
					break;
				case 2:
					return "Selasa";
					break;
				case 3:
					return "Rabu";
					break;
				case 4:
					return "Kamis";
					break;
				case 5:
					return "Jum'at";
					break;
				case 6:
					return "Sabtu";
					break;
				case 7:
					return "Minggu";
					break;
			}
		}
	}


	if ( ! function_exists('tgl_lengkap'))
	{
		function tgl_lengkap($tanggal_ex)
		{
			$hari 	= hari(date("N",strtotime($tanggal_ex)));
			$bulan 	= bulan(date("n",strtotime($tanggal_ex)));
			$tanggal 	= date("d",strtotime($tanggal_ex));
			$tahun 	= date("Y",strtotime($tanggal_ex));

			return $hari.', '.$tanggal.' '.$bulan.' '.$tahun;
		}

	}

	if ( ! function_exists('tgl_aga_lengkap'))
	{
		function tgl_aga_lengkap($tanggal_ex)
		{
			$hari 	= hari(date("N",strtotime($tanggal_ex)));
			$bulan 	= bulan(date("n",strtotime($tanggal_ex)));
			$tanggal 	= date("d",strtotime($tanggal_ex));
			$tahun 	= date("Y",strtotime($tanggal_ex));

			return $tanggal.' '.$bulan.' '.$tahun;
		}

	}

	if ( ! function_exists('tgl_waktu'))
	{
		function tgl_waktu($tanggal_ex)
		{
			return date("H:i:s",strtotime($tanggal_ex));
		}

	}

	if ( ! function_exists('full_datetime'))
	{
		function full_datetime($tanggal_ex)
		{
			if($tanggal_ex == NULL){
				return "-";
			}else{
				return tgl_lahir($tanggal_ex)." ".tgl_waktu($tanggal_ex);
			}
		}

	}



	if ( ! function_exists('tgl_lahir'))
	{
		function tgl_lahir($tanggal_ex)
		{
			$tanggal 	= date("d",strtotime($tanggal_ex));
			$bulan 		= date("m",strtotime($tanggal_ex));
			$tahun 		= date("Y",strtotime($tanggal_ex));

			return $tanggal.'/'.$bulan.'/'.$tahun;
		}

	}

	if ( ! function_exists('leading_zero'))
	{
		function leading_zero($text, $lead)
		{
			return str_pad($text, $lead, '0', STR_PAD_LEFT);
		}

	}

	if ( ! function_exists('pilihan'))
	{
		function pilihan($jawaban_sementara, $no_urut)
		{
			return substr($jawaban_sementara,($no_urut-1),1);
		}

	}

	if ( ! function_exists('status_login'))
	{
		function status_login($status = NULL)
		{
			if ($status == 0) {
				return "Halaman Login";
			}elseif ($status == 1) {
				return "Dashboard";
			}elseif ($status == 2) {
				return "Mengerjakan Ujian";
			}elseif ($status == 3) {
				return "Selesai Ujian";
			}else{
				return 'Status tidak diketahui';
			}
		}

	}

	if ( ! function_exists('status_jawaban'))
	{
		function status_jawaban($status = NULL)
		{
			if ($status == 1) {
				return '<span class="badge badge-pill badge-primary">Sedang Berlangsung</span>';
			}elseif ($status == 2) {
				return '<span class="badge badge-pill badge-success">Selesai</span>';
			}else{
				return '<span class="badge badge-pill badge-danger">Belum Mulai</span>';
			}
		}

	}

	if ( ! function_exists('status_nilai'))
	{
		function status_nilai($status = FALSE)
		{
			if ($status == FALSE) {
				return '<span class="badge badge-pill badge-danger">Belum</span>';
			}else{
				return '<span class="badge badge-pill badge-success">Sudah</span>';
			}
		}

	}

	function getActive($active){
		if($active == 0){
			return '<span class="m-badge m-badge--danger m-badge--wide">deactive</span>';
		}elseif($active == 1){
			return '<span class="m-badge m-badge--success m-badge--wide">active</span>';
		}else{
			return '<span class="m-badge m-badge--default m-badge--wide">unknown</span>';
		}
	}

	function getStatus($active){
		if($active == 0){
			return '<span class="m-badge m-badge--danger m-badge--wide">deactive</span>';
		}elseif($active == 1){
			return '<span class="m-badge m-badge--info m-badge--wide">active</span>';
		}elseif($active == 2){
			return '<span class="m-badge m-badge--success m-badge--wide">finish</span>';
		}else{
			return '<span class="m-badge m-badge--default m-badge--wide">unknown</span>';
		}
	}

	function rupiah($angka){
		if($angka == 0){
			$hasil_rupiah = "-";
		}else{
			$hasil_rupiah = number_format($angka,0,',','.');
		}
		
		// return '<span style="float:left;">Rp.</span>'.$hasil_rupiah;
		return $hasil_rupiah;
	}

	function toNumberFormat($number){
		if($number == 0){
			return "-";
		}else{
			return str_replace('.', '', $number);
		}
	}

	function jk($jk = NULL)
	{
		if ($jk == 'L') {
			return 'Laki-laki';
		}else if ($jk == 'P') {
			return 'Perempuan';
		}else{
			return 'Unkwon';
		}
	}

	function full_waktu($datetime){
		return tgl_lengkap($datetime)."<br>".date("H:i:s", strtotime($datetime));
	}

	function penyebut($nilai) {
		$nilai = (int) abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
	
