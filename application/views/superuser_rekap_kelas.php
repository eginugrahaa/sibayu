<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Rekapitulasi Tagihan Kelas
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
		
		<?php echo form_open('superuser/rekap_kelas'); ?>
		<div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label class="">Kelas:</label>
                <?php echo form_dropdown('filter_kelas', $kelas, $value_kelas, 'class="form-control m-input"'); ?>
            </div>
			<div class="col-lg-2">
				<label class="">&nbsp;</label>
				<input name="tombol_submit" type="submit" class="btn form-control btn-brand m-input" value="Tampilkan">
			</div>
			<?php
                if(!empty($value_kelas)){
                    echo '
                    <div class="col-lg-1">
                        <label class="">&nbsp;</label>
                        '.anchor('superuser/rekap_kelas','<i class="la la-refresh"></i>','title="Reset Filter" class="btn form-control btn-default m-input"').'
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
                        REKAPITULASI PEMBAYARAN KELAS
                    </h5>
                </center>

                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td width="100px">Kelas</td>
                        <td width="10px">:</td>
                        <td><?php echo $value_kelas; ?></td>

                        <td width="20%"></td>
                    </tr>

                </table>

                <table width="100%" border="2" cellpadding="2" style="font-size: 14px;margin-top: 10px;" class="table-print">
                    <thead>
                        <tr>
                            <th class="text-center" width="30px">No</th>
                            <th class="text-center" width="100px">No Identitas</th>
                            <th>Nama Peserta</th>
                            <th class="text-center" width="30px">L/P</th>

                            <th class="text-right" width="100px">Total <br>Tagihan</th>
                            <th class="text-right" width="100px">Total <br>Dibayar</th>
                            <th class="text-right" width="100px">Sisa <br>Bayar</th>
                            <!--
                            <th class="text-right" width="100px">Total <br>Diskon</th>
                            <th class="text-right" width="100px">Total <br>(Dibayar + Diskon)</th>
                            -->
                            <th class="text-center" width="100px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($peserta) > 0){
                                $no = 1;
                                $status_tagihan = "";
                                $sum_tagihan = 0;
                                $sum_dibayar = 0;
                                $sum_diskon = 0;
                                $sum_asli = 0;
                                foreach($peserta as $row_peserta){
                                    $totalTagihan = $this->superuser_model->getRekapTagihan($row_peserta["peserta_id"]);
                                    $totalBayar = $this->superuser_model->getRekapBayar($row_peserta["peserta_id"]);
                                    $totalDiskon = $this->superuser_model->getRekapDiskon($row_peserta["peserta_id"]);

                                    $totalBayar = $totalBayar - $totalDiskon;
                                    $totalAsli = $totalBayar + $totalDiskon;

                                    if($totalTagihan == $totalAsli){
                                        $status_tagihan = '<strong>lunas</strong>';
                                    }else{
                                        $status_tagihan = '<span>belum lunas</span>';
                                    }

                                    echo '
                                        <tr>
                                            <td class="text-center" height="10px">'.$no.'</td>
                                            <td class="text-center" >'.$row_peserta["no_identitas"].'</td>
                                            <td>'.$row_peserta["nama_lengkap"].'</td>
                                            <td class="text-center">'.$row_peserta["jenis_kelamin"].'</td>
                                            <td class="text-right">'.rupiah($totalTagihan).'</td>
                                            <td class="text-right">'.rupiah($totalBayar).'</td>
                                            <td class="text-right">'.rupiah($totalTagihan - $totalBayar).'</td>
                                            <!--
                                            <td class="text-right">'.rupiah($totalDiskon).'</td>
                                            <td class="text-right">'.rupiah($totalAsli).'</td>
                                            -->
                                            <td class="text-center">'.$status_tagihan.'</td>
                                        </tr>
                                    ';
                                    $no++;

                                    $sum_dibayar += $totalBayar;
                                    $sum_diskon += $totalDiskon;
                                    $sum_asli += $totalAsli;
                                    $sum_tagihan += $totalTagihan;
                                }

                                echo '
                                    <tr>
                                        <th colspan="4" class="text-center">Total</th>
                                        <th class="text-right">'.rupiah($sum_tagihan).'</th>
                                        <th class="text-right">'.rupiah($sum_dibayar).'</th>
                                        <th class="text-right">'.rupiah($sum_tagihan-$sum_dibayar).'</th>
                                        <!--
                                        <th class="text-right">'.rupiah($sum_diskon).'</th>
                                        <th class="text-right">'.rupiah($sum_asli).'</th>
                                        -->
                                        <th class="text-center">-</th>
                                    </tr>
                                ';
                            }else{
                                echo '
                                    <tr>
                                        <td colspan="10" class="text-center">Data Peserta tidak ditemukan.</td>
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
                        <td style="padding-top: 10px;" width="250px"><?php echo $iden[5]; ?>, <?php echo tgl_aga_lengkap(date('Y-m-d')); ?></td>
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
                        <td><?php echo $this->session->userdata("session_petugas_nama"); ?></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        <?php endif;?>
    </div>
</div>