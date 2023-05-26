<!--begin:: Widgets/Stats-->
<div class="m-portlet ">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Dashboard
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body  m-portlet__body">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <p>SIBAYU (Sistem Informasi Pembayaran Keuangan Sekolah) adalah sistem pengelolaan yang mengatur administrasi keuangan, dimana memungkinkan sekolah melakukan pencatatan administrasi pembayaran peserta didik, aliran kas dan memantau kondisi pembayaran tagihan keuangan sekolah. Beberapa fitur ada sistem ini yakni sebagai berikut, pengelolaan data master yang berhubungan dengan peserta didik, manajemen tagihan sekolah, transaksi pembayaran peserta didik hingga mendapatkan bukti pembayaran dan terakhir cetak laporan, berita acara hingga rekapitulasi keuangan berdasarkan waktu yang dibutuhkan untuk pelaporan.</p>
        </div>
    </div>
</div>

<div class="m-portlet ">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-6 col-xl-3">
                <?php
                    $bulan_ini = date('m');
                    $tahun_ini = date('Y');

                    $total_bayar_bulan = $this->db->query("SELECT SUM(`rincian`.`nominal_bayar`) AS `total_nominal_bayar` FROM (((`transaksi` JOIN `peserta` ON ((`peserta`.`peserta_id` = `transaksi`.`peserta_id` ) ) ) JOIN `rincian` ON ((`rincian`.`transaksi_id` = `transaksi`.`transaksi_id` ) ) ) JOIN `tagihan` ON ((`tagihan`.`tagihan_id` = `rincian`.`tagihan_id` ) ) ) WHERE MONTH(rincian.waktu_entri) = '".$bulan_ini."' AND YEAR(rincian.waktu_entri) = '".$tahun_ini."';");
                ?>

                <!--begin::Total Profit-->
                <div class="m-widget24">
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Pemasukan [<?php echo bulan($bulan_ini)." ".$tahun_ini;?>]
                        </h4><br>
                        <span class="m-widget24__desc">
                            Bulan Ini
                        </span>
                        <span class="m-widget24__stats m--font-brand" style="margin-top: 10px;width: 85%;text-align: left;">
                            <?php echo rupiah($total_bayar_bulan->row()->total_nominal_bayar); ?>
                        </span>
                        <div class="m--space-10" style="padding-bottom: 75px;"></div>
                    </div>
                </div>

                <!--end::Total Profit-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-3">
                <?php
                    $total_bayar = $this->db->query("SELECT SUM(`rincian`.`nominal_bayar`) AS `total_nominal_bayar` FROM (((`transaksi` JOIN `peserta` ON ((`peserta`.`peserta_id` = `transaksi`.`peserta_id` ) ) ) JOIN `rincian` ON ((`rincian`.`transaksi_id` = `transaksi`.`transaksi_id` ) ) ) JOIN `tagihan` ON ((`tagihan`.`tagihan_id` = `rincian`.`tagihan_id` ) ) );");
                ?>
                <!--begin::New Feedbacks-->
                <div class="m-widget24">
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Total Pemasukan
                        </h4><br>
                        <span class="m-widget24__desc">
                            Semua Transaksi
                        </span>
                        <span class="m-widget24__stats m--font-info" style="margin-top: 10px;width: 85%;text-align: left;">
                            <?php echo rupiah($total_bayar->row()->total_nominal_bayar); ?>
                        </span>
                        <div class="m--space-10" style="padding-bottom: 75px;"></div>
                    </div>
                </div>

                <!--end::New Feedbacks-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-3">
                <?php
                    $total_tagihan = $this->db->query("SELECT SUM(`tagihan`.`nominal`) AS `total_nominal` FROM ((`tagihan_peserta` JOIN `peserta` ON ((`tagihan_peserta`.`peserta_id` = `peserta`.`peserta_id` ) ) ) JOIN `tagihan` ON ((`tagihan_peserta`.`tagihan_id` = `tagihan`.`tagihan_id` ) ) );");
                ?>
                <!--begin::New Orders-->
                <div class="m-widget24">
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Total Tagihan
                        </h4><br>
                        <span class="m-widget24__desc">
                            Semua Tagihan
                        </span>
                        <span class="m-widget24__stats m--font-danger" style="margin-top: 10px;width: 85%;text-align: left;">
                            <?php echo rupiah($total_tagihan->row()->total_nominal); ?>
                        </span>
                        <div class="m--space-10" style="padding-bottom: 75px;"></div>
                    </div>
                </div>

                <!--end::New Orders-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-3">
                <?php
                    $jumlah_peserta = $this->db->query("
                        SELECT COUNT(peserta_id) AS jumlah_peserta FROM peserta
                    ");
                ?>
                <!--begin::New Users-->
                <div class="m-widget24">
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Jumlah Peserta Didik 
                        </h4><br>
                        <span class="m-widget24__desc">
                            Semua Status
                        </span>
                        <span class="m-widget24__stats m--font-success" style="margin-top: 10px;width: 85%;text-align: left;">
                        <?php echo toNumberFormat($jumlah_peserta->row()->jumlah_peserta); ?>
                        </span>
                        <div class="m--space-10" style="padding-bottom: 75px;"></div>
                    </div>
                </div>

                <!--end::New Users-->
            </div>
        </div>
    </div>
</div>