
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Cetak Berita Acara 
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
		
		<?php echo form_open('superuser/pembayaran_beritaacara'); ?>
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
                        BERITA ACARA PENYERAHAN UANG DAN BUKTI TRANSAKSI
                    </h5>
                </center>
                <?php
                    $petugas = $this->superuser_model->getPetugas($petugas_id);
                ?>
                
                <p style="font-size: 14px;padding: 10px 20px ;">
                    Pada hari <?php echo hari(date("N",strtotime($tanggal))); ?> 
                    tanggal <?php echo date("d",strtotime($tanggal)); ?> 
                    bulan <?php echo bulan(date("n",strtotime($tanggal))); ?> 
                    tahun <?php echo date("Y",strtotime($tanggal)); ?> , 
                    telah diserahkan uang dan bukti transaksi pembayaran dengan perincian sebagai berikut :
                </p>

                <?php
                    $countTransaksi = $this->superuser_model->countTransaksi($tanggal, $petugas_id);
                    $countRincian = $this->superuser_model->countRincian($tanggal, $petugas_id);
                    $sumTunai = $this->superuser_model->sumRincian($tanggal, $petugas_id, 'tunai');
                    $sumDiskon = $this->superuser_model->sumRincian($tanggal, $petugas_id, 'diskon');
                    $total_bersih = $sumTunai - $sumDiskon;
                ?>
                
                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td width="15%">&nbsp;</td>
                        <td class="text-left" width="170px">Nama Teller</td>
                        <td class="text-center" width="10px">:</td>
                        <td class="text-right"><?php echo $petugas->row()->nama_petugas; ?></td>
                        <td width="50%">&nbsp;</td>
                    </tr>
					
					<tr>
                        <td width="15%">&nbsp;</td>
                        <td class="text-left" width="170px">Slip Pembayaran</td>
                        <td class="text-center" width="10px">:</td>
                        <td class="text-right"><?php echo $countTransaksi; ?> lembar</td>
                        <td width="50%">&nbsp;</td>
                    </tr>

                    <tr>
                        <td width="10%">&nbsp;</td>
                        <td class="text-left" width="170px">Daftar Transaksi</td>
                        <td class="text-center" width="10px">:</td>
                        <td class="text-right"><?php echo $countRincian; ?> baris</td>
                        <td width="50%">&nbsp;</td>
                    </tr>
                    <tr><td colspan="5">&nbsp;</td></tr>
                    
                    <!--
                    <tr>
                        <td width="10%">&nbsp;</td>
                        <td class="text-left" width="170px">Jumlah Transaksi </td>
                        <td class="text-center" width="10px">:</td>
                        <td class="text-right"><?php echo rupiah($sumTunai); ?> </td>
                        <td width="50%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="10%">&nbsp;</td>
                        <td class="text-left" width="170px">Jumlah Diskon </td>
                        <td class="text-center" width="10px">:</td>
                        <td class="text-right"><?php echo rupiah($sumDiskon); ?> </td>
                        <td width="50%">&nbsp;</td>
                    </tr>
                    -->

                    <tr>
                        <td width="10%">&nbsp;</td>
                        <td class="text-left" width="170px"><strong>Total</strong> </td>
                        <td class="text-center" width="10px"><strong>:</strong></td>
                        <td class="text-right"><strong><?php echo rupiah($total_bersih); ?> </strong></td>
                        <td width="50%">&nbsp;</td>
                    </tr>
                    <tr><td colspan="5" style="padding: 20px;">
                        Terbilang : <em><?php echo terbilang($total_bersih); ?> rupiah</em>
                    </td></tr>
                </table>

                <p style="font-size: 14px;padding: 10px 20px ;">
                   Demikian berita acara ini dibuat untuk dipergunakan sebagaimana mestinya.
                </p>

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
