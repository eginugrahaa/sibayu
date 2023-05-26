
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Cetak Laporan Transaksi Pembayaran
                </h3>
            </div>
        </div>
	</div>
	<div class="m-portlet__body">
		<?php
			if ($this->session->userdata('alert_error') != NULL) {
				$alert_error = $this->session->userdata('alert_error');
				$alert_error_type = $this->session->userdata('alert_error_type');

				echo '
					<div class="m-alert m-alert--icon m-alert--air m-alert--square alert '.$alert_error_type.' alert-dismissible fade show" role="alert" >
						<div class="m-alert__icon">
							<i class="la la-warning"></i>
						</div>
						<div class="m-alert__text">
							'.$alert_error.'
						</div>
						<div class="m-alert__close">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							</button>
						</div>
					</div>
				';

				$this->session->unset_userdata('alert_error');
				$this->session->unset_userdata('alert_error_type');
			}
		?>   
		
		<?php echo form_open('superuser/pembayaran_laporan'); ?>
		<div class="form-group m-form__group row">
			<div class="col-lg-3">
				<label>Tanggal :</label>
				<input type="date" name="tanggal" value="<?php echo $tanggal; ?>" class="form-control m-input" placeholder="..." required />
			</div>
			<div class="col-lg-3">
				<label>Petugas :</label>
				<?php echo 
					form_dropdown('petugas_id', $dropdownPetugas, $petugas_id, 'class="form-control m-input" placeholder="..." required');
				?>
			</div>
			<div class="col-lg-2">
				<label class="">&nbsp;</label>
				<input name="tombol_submit" type="submit" class="btn form-control btn-brand m-input" value="Tampilkan">
			</div>
			<?php
                if(!empty($tanggal) OR !empty($petugas_id)){
                    echo '
                    <div class="col-lg-1">
                        <label class="">&nbsp;</label>
                        '.anchor('superuser/pembayaran_laporan','<i class="la la-refresh"></i>','title="Reset Filter" class="btn form-control btn-default m-input"').'
                    </div>

                    ';
                }
            ?>
		</div>
		<?php echo form_close(); ?>

		<?php if ( isset($tombol_submit) ) : ?>
            <a href="#" class="btn btn-accent" onclick="printDiv('cetak_nilai');"><i class="la la-print"></i> Cetak</a>
            <hr/>
            <div id="cetak_nilai" style="border:1px dashed #777; padding: 10px;">
                <table width="100%">
                    <tr>
                        <?php $iden = $this->superuser_model->getIdentitas(); ?>
                        <!-- <td align="center" width="100px">
                            <img src="<?php echo base_url('_assets/images/'.$iden[7]); ?>" width="100px">
                        </td> -->
                        <td style="padding: 0px;padding-left: 10px;">
                            <?php 
                                echo '
                                    <h1 style="margin: 0;padding: 0;">'.$iden[1].'</h1>
                                    <h5 style="margin: 0;padding: 0;">'.$iden[4].'</h5>
                                    <h5 style="margin: 0;padding: 0;">'.$iden[6].'</h5>
                                ';
                            ?>
                        </td>
                    </tr>
                </table>
                <center>
                    <h5 style="margin:10px 0;padding:10px 0;border-bottom: 2px solid #555;border-top: 2px solid #555;">
                    DAFTAR TRANSAKSI PEMBAYARAN PER-PETUGAS
                    </h5>
                </center>
                <?php
                    $petugas = $this->superuser_model->getPetugas($petugas_id);
                ?>
                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td width="150px">Nama Petugas</td>
                        <td width="10px">:</td>
                        <td><?php echo $petugas->row()->nama_petugas; ?></td>

                        <td width="20%"></td>
                    </tr>

                    <tr>
                        <td width="150px">Tanggal Transaksi </td>  
                        <td width="10px">:</td>
                        <td><?php echo tgl_lengkap($tanggal); ?></td>  

                        <td></td>
                    </tr>
                </table>

                <table width="100%" border="2" cellpadding="5" style="font-size: 14px;margin-top: 10px;">
                    <thead>
                        <tr>
                            <th class="text-center" width="50px">No</th>
                            <th class="text-center" width="100px">Kelas</th>
                            <th>Nama Peserta</th>
                            <th>Nama Transaksi</th>
                            <th class="text-right" width="120px">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($transaksi) > 0){
                                $no = 1;
                                $nama_transaksi = "";
                                $nominal = 0;
                                $diskon = 0;
                                $jumlah = 0;

                                $total_nominal = 0;
                                $total_diskon = 0;
                                $total_jumlah = 0;
                                foreach($transaksi as $row_transaksi){
                                    if($row_transaksi["tipe_transaksi"] == "diskon"){
                                        $nama_transaksi = "Diskon / Potongan";
                                        $nominal = 0;
                                        $diskon = $row_transaksi["nominal_bayar"];
                                    }else{
                                        $nama_transaksi = $row_transaksi["nama_tagihan"];
                                        $nominal =$row_transaksi["nominal_bayar"];
                                        $diskon = 0;
                                    }
                                    $jumlah += $nominal - $diskon;
                                    echo '
                                        <tr>
                                            <td class="text-center" height="50px">'.$no.'</td>
                                            <td class="text-center">'.$row_transaksi["tingkat"]."-".$row_transaksi["kelas"].'</td>
                                            <td>'.$row_transaksi["nama_lengkap"].'</td>
                                            <td>'.$nama_transaksi.'</td>
                                            <td class="text-right">'.rupiah($nominal).'</td>
                                        </tr>
                                    ';
                                    $no++;

                                    $total_nominal += $nominal;
                                    $total_diskon += $diskon;
                                }
                                $total_jumlah = $jumlah;

                                echo '
                                    <tr>
                                        <td class="text-center" colspan="4"><strong>Total</strong></td>
                                        <td class="text-right"><strong>'.rupiah($total_jumlah).'</strong></td>
                                    </tr>
                                ';
                            }else{
                                echo '
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada transaksi pembayaran.</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>

                <table width="100%" style="margin-top: 10px;font-size:14px;">
                <tr>
                    <td style="padding-top: 10px;"></td>
                    <td style="padding-top: 10px;">&nbsp;</td>
                    <td style="padding-top: 10px;" width="250px"><?php echo $iden[5]; ?>, <?php echo tgl_aga_lengkap($tanggal); ?></td>
                    <td style="padding-top: 10px;" width="50px">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Petugas,</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <br><br><br>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo $petugas->row()->nama_petugas; ?></td>
                    <td></td>
                </tr>
            </table>

            </div>
		<?php endif; ?>	
	</div>
</div>
