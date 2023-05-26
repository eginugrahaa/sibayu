<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Daftar Tahun Masuk
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('superuser/tahun_masuk_tambah'); ?>" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
                        <span>
                            <i class="la la-plus"></i>
                            <span>Tambah</span>
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

        <?php echo form_open('superuser/tahun_masuk_filter'); ?>
        <div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label>Nama Tahun Masuk:</label>
                <?php echo form_input('filter_nama', $value_nama, 'class="form-control m-input" placeholder="..."'); ?>
            </div>
            <div class="col-lg-2">
                <label class="">&nbsp;</label>
                <input name="filter_submit" type="submit" class="btn form-control btn-brand m-input" value="Filter">
            </div>

            <?php
                if(!$this->session->userdata('filter_nama') OR ! $this->session->userdata('filter_kelas')){
                    echo '
                    <div class="col-lg-1">
                        <label class="">&nbsp;</label>
                        '.anchor('superuser/tahun_masuk','<i class="la la-refresh"></i>','title="Reset Filter" class="btn form-control btn-default m-input"').'
                    </div>
                    ';
                }
            ?>
        </div>
        <?php echo form_close(); ?>
        <!--begin: Datatable -->
        <?php echo form_open('superuser/tahun_masuk_hapus'); ?>
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-checkable m-datatable--brand" id="m_table_1" style="width:99.9%;">
            <thead class="btn-brand">
                <tr>
                    <th class="text-center" width="60px">#</th>
                    <th class="text-left">Nama Tahun Masuk</th>
                    <th class="text-right" width="200px">Jumlah Tagihan</th>
                    <th class="text-center" width="200px">Waktu Entri</th>
                    <th class="text-center" width="100px">Status Akun</th>
                    <th class="text-center" width="75px">Aksi</th>
                    <th class="text-center" width="40px"><input type="checkbox" name="select-all" id="select-all" /></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (count($query) > 0) {
                    $no=$nomor+1;
                    $countPeserta = 0;
                    $countTagihan = 0;
                    foreach ($query as $row) {
                        
                        $countPeserta = $this->superuser_model->countTahunMasukPeserta($row["tahun_masuk_id"]);
                        $countTagihan = $this->superuser_model->countTahunMasukTagihan($row["tahun_masuk_id"]);

                        echo"
                            <tr>
                                <td align='center'>".$no."</td>
                                <td align='left'>".$row["nama_tahun_masuk"]."</td>
                                <td align='right'>".$countTagihan."</td>
                                <td align='center'>".full_datetime($row["waktu_entri"])."</td>
                                <td align='center'>".getActive($row["aktif_tahun_masuk"])."</td>
                                <td align='center'>
                                    ".anchor('superuser/tahun_masuk_edit/'.$row['tahun_masuk_id'],'<i class="la la-edit"></i> Edit')." 
                                </td>
                                <td class='text-center'>
                                    <input type='checkbox' name='kode_id[]' value='".$row["tahun_masuk_id"]."' id='checbox_id'/>
                                </td>
                            </tr>
                        ";
                        $no++;
                    }
                    $nomor_baru = $nomor+1;
                }else{
                    echo "<td align='center' colspan='7'>Data tidak ditemukan.</td>";
                    $nomor_baru = 0;
                }
            ?>
            </tbody>
        </table>
        
        <div class="paginate pull-left">
            <?php
                echo $this->pagination->create_links();
            ?>
        </div>

        <span class="pull-right">Menampilkan <?php echo $nomor_baru;?>&nbsp;-&nbsp;<?php echo count($query)+$nomor;?> dari <?php echo $total;?> hasil.</span>
        </div>

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
<!-- END EXAMPLE TABLE PORTLET-->