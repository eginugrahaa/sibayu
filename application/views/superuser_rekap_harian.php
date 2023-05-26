<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Rekapitulasi Keuangan Harian
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
		
		<?php echo form_open('superuser/rekap_harian'); ?>
		<div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label class="">Periode Tanggal:</label>
                <input id="daterange" type="text" name="filter_tanggal" value="<?php echo $value_tanggal; ?>" class="form-control m-input" placeholder="..." required max="<?php echo date("Y-m-d"); ?>"/>
            </div>

            <div class="col-lg-3">
                <label class="">Tagihan:</label>
                <?php echo form_dropdown('filter_tagihan', $tagihan, $value_tagihan, 'class="form-control m-input"'); ?>
            </div>

			<div class="col-lg-2">
				<label class="">&nbsp;</label>
				<input name="tombol_submit" type="submit" class="btn form-control btn-brand m-input" value="Tampilkan">
			</div>
			<?php
                if(!empty($value_tanggal)){
                    echo '
                    <div class="col-lg-1">
                        <label class="">&nbsp;</label>
                        '.anchor('superuser/rekap_harian','<i class="la la-refresh"></i>','title="Reset Filter" class="btn form-control btn-default m-input"').'
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
                        <td align="center" width="100px">
                            <img src="<?php echo base_url('_assets/images/'.$iden[7]); ?>" width="100px">
                        </td>
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
                        REKAPITULASI PEMBAYARAN TRANSAKSI PERIODE-TANGGAL
                    </h5>
                </center>

                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td width="150px">Tanggal Rekap Awal</td>
                        <td width="10px">:</td>
                        <td><?php echo tgl_lengkap($ex_tanggal[0]); ?></td>
                    </tr>

                    <tr>
                        <td width="150px">Tanggal Rekap Akhir</td>
                        <td width="10px">:</td>
                        <td><?php echo tgl_lengkap($ex_tanggal[1]); ?></td>
                    </tr>
                </table>

                <table width="100%" border="2" cellpadding="5" style="font-size: 14px;margin-top: 10px;" class="table-print">
                    <thead>
                        <tr>
                            <th class="text-center" width="30px">No</th>
                            <th class="text-left">Tanggal Pembayaran</th>
                            <th class="text-right" width="150px">Total Dibayar</th>
                            <!--
                            <th class="text-right" width="150px">Total Diskon</th>
                            <th class="text-right" width="150px">(Dibayar+Diskon)</th>
                            -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($tanggal) > 0){
                                $no = 1;

                                $sum_dibayar = 0;
                                $sum_diskon = 0;
                                $sum_asli = 0;
                                foreach($tanggal as $row_tanggal){
                                    $totalBayar = $this->superuser_model->getRekapBayarTanggal($row_tanggal["tanggal_transaksi"], $value_tagihan);
                                    $totalDiskon = $this->superuser_model->getRekapDiskonTanggal($row_tanggal["tanggal_transaksi"], $value_tagihan);

                                    $totalBayar = $totalBayar - $totalDiskon;
                                    $totalAsli = $totalBayar + $totalDiskon;
                                    
                                    echo '
                                        <tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td>'.tgl_lengkap($row_tanggal["tanggal_transaksi"]).'</td>
                                            <td class="text-right">'.rupiah($totalBayar).'</td>
                                            <!--
                                            <td class="text-right">'.rupiah($totalDiskon).'</td>
                                            <td class="text-right">'.rupiah($totalAsli).'</td>
                                            -->
                                        </tr>
                                    ';
                                    $no++;

                                    $sum_dibayar += $totalBayar;
                                    $sum_diskon += $totalDiskon;
                                    $sum_asli += $totalAsli;
                                }

                                echo '
                                    <tr>
                                        <th colspan="2" class="text-center">Total</th>
                                        <th class="text-right">'.rupiah($sum_dibayar).'</th>
                                        <!--
                                        <th class="text-right">'.rupiah($sum_diskon).'</th>
                                        <th class="text-right">'.rupiah($sum_asli).'</th>
                                        -->
                                    </tr>
                                ';
                            }else{
                                echo '
                                    <tr>
                                        <td colspan="10" class="text-center">Data rekapitulasi harian tidak ditemukan.</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
                <table width="100%" style="margin-top: 10px;font-size:14px;">
                    <tr>
                        <td style="padding-top: 10px;"><strong>Catatan:</strong> <em>hanya tanggal yang terjadi proses transaksi pembayaran muncul pada rekapitulasi diatas.</em></td>
                        <td style="padding-top: 10px;" width="250px">&nbsp;</td>
                        <td style="padding-top: 10px;" width="200px"><?php echo $iden[5]; ?>, <?php echo tgl_aga_lengkap(date('Y-m-d')); ?><br>Petugas,</td>
                        <td style="padding-top: 10px;" width="50px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td><?php echo $this->session->userdata("session_petugas_nama"); ?></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>