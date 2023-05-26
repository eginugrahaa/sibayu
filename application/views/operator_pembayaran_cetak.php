<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Bukti Pembayaran
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('operator/pembayaran_detail/'.$row["peserta_id"]); ?>" class="btn btn-metal m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Kembali Ke Detail Tagihan</span>
                        </span>
                    </a>
                </li>
            </ul>    
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

        <a href="#" class="btn btn-accent" onclick="printDiv('cetak_nilai');"><i class="la la-print"></i> Cetak</a>
        <hr/>
        <div id="cetak_nilai" class="land-print" style="border:1px dashed #777; padding: 10px;">
            <table width="100%">
                <tr>
                    <?php $iden = $this->superuser_model->getIdentitas(); ?>
                    <!-- <td align="center" width="100px">
                        <img src="<?php echo base_url('_assets/images/'.$iden[7]); ?>" width="70px">
                    </td> -->
                    <td style="padding: 0px;">
                        <?php 
                            echo '
                                <h2 style="margin: 0;padding: 0;">'.$iden[1].'</h2>
                                <h6 style="margin: 0;padding: 0;">'.$iden[4].'</h6>
                                <h6 style="margin: 0;padding: 0;">'.$iden[6].'</h6>
                            ';
                        ?>
                    </td>
                </tr>
            </table>
            <center><h5 style="margin:10px 0;padding:10px 0;border-bottom: 2px solid #555;border-top: 2px solid #555;">BUKTI PEMBAYARAN</h5></center>
            <table width="100%" style="font-size: 14px;">
                <tr>
                    <td width="150px">No Identitas</td>
                    <td width="10px">:</td>
                    <td><?php echo $peserta['no_identitas']; ?></td>

                    <td width="20%"></td>
                    
                    <td width="150px">Tanggal Transaksi</td>  
                    <td width="10px">:</td>
                    <td><?php echo full_datetime($row['waktu_transaksi']); ?></td>  
                </tr>

                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><?php echo $peserta['nama_lengkap']; ?></td>

                    <td></td>
                    
                    <td>Nama Petugas</td>
                    <td>:</td>
                    <td><?php echo $row['nama_petugas']; ?></td>
                </tr>

                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?php echo $peserta['tingkat']." - ".$peserta['kelas']; ?></td>

                    <td></td>
                    
                    <td>Waktu Cetak</td>
                    <td>:</td>
                    <td><?php echo full_datetime(date('Y-m-d H:i:s')); ?></td>  
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <?php echo form_open('operator/pembayaran_rincian_hapus'); ?>
            <?php echo form_hidden('transaksi_id', $row["transaksi_id"]); ?>
            <table width="100%" style="margin-top: 10px;font-size:14px;border-top: 2px solid #555;" cellpadding="2">
                <thead >
                    <tr>
                        <th width="50px" class="text-center" style="padding-top: 10px;" >#</th>
                        <th style="padding-top: 10px;">Nama Pembayaran</th>
                        <th width="150px" class="text-right" style="padding-top: 10px;">Nominal</th>
                        <th width="50px" style="padding-top: 10px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $subtotal = 0;
                        $total_bayar = 0;
                        if(count($rincian) > 0){
                            $no = 1;
                            foreach($rincian as $row_rincian){

                                if($row_rincian["tipe_tagihan"] == "angsur"){
                                    $tipe = "[ANGSUR]";
                                }else if($row_rincian["tipe_tagihan"] == "sekali"){
                                    $tipe = "[TUNAI]";
                                }else{
                                    $tipe = "[-]";
                                }

                                echo '
                                    <tr>
                                        <td align="center">'.$no.'</td>
                                        <td>'.$tipe." - ".$row_rincian["nama_tagihan"].'</td>
                                        <td align="right">'.rupiah($row_rincian["nominal_bayar"]).'</td>
                                    </tr>
                                ';
                                $no++;
                                $subtotal += $row_rincian["nominal_bayar"];
                            }
                        }else{
                            echo '
                                <tr>
                                    <td colspan="5">Data Pembayaran Tidak Ditemukan.</td>
                                </tr>
                            ';
                        }

                        // $total_bayar = $subtotal - $diskon["nominal_bayar"];
                        $total_bayar = $subtotal;
                    ?>
                </tbody>
            </table>
            

            <table width="100%" style="margin-top: 10px;font-size:14px;border-top: 2px solid #000;" cellpadding="1">
                <tr>
                    <td style="padding-top: 10px;padding-left: 20px;">
                        <strong>Terbilang:</strong>
                        <br>
                        <em><?php echo terbilang($total_bayar)." rupiah"; ?></em>
                    </td>
                    
                    <td style="padding-top: 10px;" width="100px" class="text-right"><strong>Total Bayar</strong></td>
                    <td style="padding-top: 10px;" width="10px" class="text-center">:</td>
                    <td style="padding-top: 10px;" width="150px" class="text-right"><strong><?php echo rupiah($subtotal); ?></strong></td>
                    <td style="padding-top: 10px;" width="50px">&nbsp;</td>
                </tr>
                <!--
                <tr>
                    <td></td>
                    
                    <td width="100px" class="text-right"><strong>Diskon</strong></td>
                    <td width="10px" class="text-center">:</td>
                    <td width="150px" class="text-right"><?php echo rupiah($diskon["nominal_bayar"]); ?></td>
                    <td width="50px"><input class="no-print" type="checkbox" name="kode_id[]" value="<?php echo $diskon["rincian_id"]; ?>" id="checbox_id"/></td>
                </tr>
                <tr>
                    <td></td>
                    
                    <td width="100px" class="text-right"><strong>Total Bayar</strong></td>
                    <td width="10px" class="text-center">:</td>
                    <td width="150px" class="text-right"><?php echo rupiah($total_bayar); ?></td>
                    <td width="50px">&nbsp;</td>
                </tr>
                -->
                <tr>
                    <td colspan="5" ><input name="filter_delete" type="submit" class="btn btn-default btm-sm no-print" value="Hapus" onclick="return confirm('[WARNING] Data centang yang dipilih akan dihapus permanen. Segala data (transaksi pembayaran) yang berhubungan juga akan ikut terhapus permanen dan menyebabkan laporan atau rekapitulasi keuangan mengalami perubahan, pastikan keputusan anda benar, lanjutkan?');" id="deleted_checkbox" style="display: none;border: 1px solid #DDD;margin-top: 10px;float: right;margin-right:30px;"></td>
                </tr>
            </table>

            <?php echo form_close(); ?>

            <table width="100%" style="margin-top: 10px;font-size:14px;border-top: 2px solid #000;">
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
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
