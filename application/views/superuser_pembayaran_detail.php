<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Daftar Tagihan Peserta
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('superuser/pembayaran'); ?>" class="btn btn-metal m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Kembali Ke Pencarian</span>
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
        <div class="form-group m-form__group row">
            <div class="col-lg-5" >
                <table width="100%" style="font-size: 14px;">
                    
                    <tr>
                        <td >No Identitas</td>
                        <td align="center">:</td>
                        <td><?php echo $peserta["no_identitas"]; ?></td>
                    </tr>

                    <tr>
                        <td>Nama Lengkap</td>
                        <td align="center">:</td>
                        <td><?php echo $peserta["nama_lengkap"]; ?></td>
                    </tr>

                    <tr>
                        <td>Jenis Kelamin</td>
                        <td align="center">:</td>
                        <td><?php echo jk($peserta["jenis_kelamin"]); ?></td>
                    </tr>

                    <tr>
                        <td>Kelas</td>
                        <td align="center">:</td>
                        <td><?php echo $peserta["tingkat"]."-".$peserta["kelas"]; ?></td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <?php //echo anchor('superuser/pembayaran_pemetaan/'.$peserta["peserta_id"], '<span class="badge badge-pill badge-primary" style="border-radius: 0px; padding: 5px 10px;">Tambah Tagihan Peserta Didik</span>'); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4" >&nbsp;</div>
            <div class="col-lg-3" >
                <?php echo anchor('superuser/pembayaran_tambah/'.$peserta["peserta_id"],'<button class="btn btn-success m-input btn-lg" style="width: 100% !important;">Bayar Tagihan</button>',''); ?>
                <?php echo anchor('superuser/pembayaran_cetak_riwayat/'.$peserta["peserta_id"],'<button class="btn btn-info m-input btn-sm " style="width: 100% !important; margin-top: 10px;">Cetak Riwayat Tagihan</button>',''); ?>
                <?php echo anchor('superuser/pembayaran_pemetaan/'.$peserta["peserta_id"],'<button class="btn btn-secondary m-input btn-sm " style="width: 100% !important; margin-top: 10px;">Tambah Tagihan</button>',''); ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-checkable m-datatable--brand" id="m_table_1" style="width:99.9%;">
                <thead class="btn-brand">
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th class="text-left">Nama Tagihan</th>
                        <th class="text-center" width="50px">Tipe</th>
                        <th class="text-right" width="140px">Nominal</th>
                        <th class="text-right" width="140px">Sudah Dibayar</th>
                        <th class="text-center" width="120px">Sisa Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_nominal = 0;
                        $total_bayar = 0;

                        if (count($tagihan) > 0) {

                            $status_total = "";
                            $status_tagihan = "";
                            $no=1;
                            foreach ($tagihan as $row_tagihan) {
                                $sudah_dibayar = $this->superuser_model->rincianCek($peserta["peserta_id"], $row_tagihan["tagihan_id"]);

                                if($row_tagihan["nominal"] == $sudah_dibayar){
                                    $status_tagihan = '<span class="m-badge m-badge--success m-badge--wide">sudah lunas</span>';
                                }else{
                                    $status_tagihan = '<span class="m-badge m-badge--danger m-badge--wide">belum lunas</span>';
                                }

                                echo '
                                    <tr>
                                        <td class="text-center">'.$no.'</td>
                                        <td class="text-left">'.$row_tagihan["nama_tagihan"].'</td>
                                        <td class="text-center">'.$row_tagihan["tipe_tagihan"].'</td>
                                        <td class="text-right">'.rupiah($row_tagihan["nominal"]).'</td>
                                        <td class="text-right">'.rupiah($sudah_dibayar).'</td>
                                        <td class="text-center">'.rupiah($row_tagihan["nominal"] - $sudah_dibayar).'</td>
                                    </tr>
                                ';

                                $total_nominal += $row_tagihan["nominal"];
                                $total_bayar += $sudah_dibayar;
                                $no++;
                            }

                            if($total_nominal == $total_bayar){
                                $status_total = '<span class="m-badge m-badge--success m-badge--wide">sudah lunas</span>';
                            }else{
                                $status_total = '<span class="m-badge m-badge--danger m-badge--wide">belum lunas</span>';
                            }
                        }else{
                            echo "<tr><td align='center' colspan='10'>Belum ada tagihan.</td></tr>";
                            $no = 0;
                        }
                    ?>

                </tbody>
                <?php $total_diskon = $this->superuser_model->getDiskon($peserta["peserta_id"]); ?>
                
                <thead style="border-top: 2px dashed #b2bec3;">
                    <tr>
                        <th class="text-center" colspan="3"><strong>TOTAL</strong></th>
                        <th class="text-right"><?php echo rupiah($total_nominal); ?></th>
                        <th class="text-right"><?php echo rupiah($total_bayar); ?></th>
                        <th class="text-center"><?php echo rupiah($total_nominal - $total_bayar); ?></th>
                    </tr>
                </thead>
                <!--
                <thead style="border-top: 2px dashed #b2bec3;">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-left" colspan="3">*Catatan Total Diskon yang pernah didapatkan : </th>
                        <th class="text-right text-warning">(<?php echo rupiah($total_diskon); ?>)</th>
                        <th class="text-center text-warning"><span class="m-badge m-badge--warning m-badge--wide">potongan</span></th>
                    </tr>
                </thead>
                -->
                <?php
                    /*
                    if (count($tagihan) > 0) {
                        $status_total = "";
                        if($total_nominal == $total_bayar){
                            $status_total = '<span class="m-badge m-badge--success m-badge--wide">lunas</span>';
                        }else{
                            $status_total = '<span class="m-badge m-badge--danger m-badge--wide">belum lunas</span>';
                        }
                        echo '
                            <thead class="btn-brand">
                                <tr>
                                    <th colspan="2" class="text-center">Total</th>
                                    <th class="text-right">'.rupiah($total_nominal).'</th>
                                    <th class="text-right">'.rupiah($total_bayar).'</th>
                                    <th class="text-center">'.$status_total.'</th>
                                </tr>
                            </thead>
                        ';
                    }
                    */
                ?>
            </table>

            
        </div>

    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Daftar Riwayat Pembayaran
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="table-responsive">
            <?php echo form_open('superuser/pembayaran_transaksi_hapus'); ?>
            <?php echo form_hidden('peserta_id', $peserta["peserta_id"]); ?>
            <table class="table table-striped table-bordered table-hover table-checkable m-datatable--brand table-valign" id="m_table_1" style="width:99.9%;">
                <thead class="btn-brand">
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th class="text-left" width="250px">Tanggal</th>
                        <th class="text-left">Petugas</th>
                        <!--
                        <th class="text-right" width="140px">Jumlah Tagihan</th>
                        <th class="text-right" width="140px">Diskon</th>
                        -->
                        <th class="text-right" width="140px">Total Bayar</th>
                        <th class="text-center" width="120px">Aksi</th>
                        <th class="text-center" width="40px"><input type="checkbox" name="select-all" id="select-all" /></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (count($transaksi) > 0) {
                            $no=1;
                            foreach ($transaksi as $row_transaksi) {
                                $sudah_dibayar = 0;
                                $jumlah_bayar = $this->superuser_model->getTagihanTransaksi($row_transaksi["transaksi_id"]);
                                $jumlah_diskon = $this->superuser_model->getTagihanDiskon_lama($row_transaksi["transaksi_id"]);
                                $bayar_asli = ($jumlah_bayar-$jumlah_diskon);

                                echo '
                                    <tr>
                                        <td class="text-center">'.$no.'</td>
                                        <td class="text-left">'.full_waktu($row_transaksi["waktu_transaksi"]).'</td>
                                        <td class="text-left">'.$row_transaksi["nama_petugas"].'</td>
                                        <td class="text-right"><strong>'.rupiah($jumlah_bayar).'</strong></td>
                                        <!--
                                        <td class="text-right">'.rupiah($jumlah_diskon).'</td>
                                        <td class="text-right"><strong>'.rupiah($bayar_asli).'</strong></td>
                                        -->
                                        <td class="text-center">
                                            '.anchor('superuser/pembayaran_cetak/'.$row_transaksi["transaksi_id"],'<span class="m-badge m-badge--info m-badge--wide" style="border-radius: 0px;">cetak bukti</span>').'
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="kode_id[]" value="'.$row_transaksi["transaksi_id"].'" id="checbox_id"/>
                                        </td>
                                    </tr>
                                ';

                                $no++;
                            }
                        }else{
                            echo "<tr><td align='center' colspan='10'>Belum ada riwayat pembayaran.</td></tr>";
                            $no = 0;
                        }
                    ?>
                </tbody>
            </table>

            <div class="form-group m-form__group row " >
                <div class="col-lg-10">
                    &nbsp;
                </div>

                <div class="col-lg-2">
                    <input name="filter_delete" type="submit" class="btn btn-default btm-sm" value="Hapus" onclick="return confirm('[WARNING] Data centang yang dipilih akan dihapus permanen. Segala data (transaksi pembayaran) yang berhubungan juga akan ikut terhapus permanen dan menyebabkan laporan atau rekapitulasi keuangan mengalami perubahan, pastikan keputusan anda benar, lanjutkan?');" id="deleted_checkbox" style="display: none;border: 1px solid #DDD;margin-top: 10px;float: right;">
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
