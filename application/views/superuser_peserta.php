<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Daftar Peserta
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <!-- <li class="m-portlet__nav-item">
                    <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm"  data-toggle="modal" data-target="#modal_import">
                        <span>
                            <i class="la la-upload"></i>
                            <span>Import</span>
                        </span>
                    </a>
                </li> -->
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('superuser/peserta_tambah'); ?>" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
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

        <?php echo form_open('superuser/peserta_filter'); ?>
        <div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label>No&nbsp;Identitas / Nama&nbsp;Lengkap:</label>
                <?php echo form_input('filter_nama', $value_nama, 'class="form-control m-input" placeholder="..."'); ?>
            </div>
            <div class="col-lg-3">
                <label class="">Kelas:</label>
                <?php echo form_dropdown('filter_kelas', $kelas, $value_kelas, 'class="form-control m-input"'); ?>
            </div>
            <!-- <div class="col-lg-3">
                <label class="">Tahun Masuk:</label>
                <?php echo form_dropdown('filter_tahun', $tahun_masuk, $value_tahun, 'class="form-control m-input"'); ?>
            </div> -->
            <div class="col-lg-2">
                <label class="">&nbsp;</label>
                <input name="filter_submit" type="submit" class="btn form-control btn-brand m-input" value="Filter">
            </div>

            <?php
                if(!$this->session->userdata('filter_nama') OR ! $this->session->userdata('filter_kelas')){
                    echo '
                    <div class="col-lg-1">
                        <label class="">&nbsp;</label>
                        '.anchor('superuser/peserta','<i class="la la-refresh"></i>','title="Reset Filter" class="btn form-control btn-default m-input"').'
                    </div>
                    ';
                }
            ?>
        </div>
        <?php echo form_close(); ?>
        <!--begin: Datatable -->
        <?php echo form_open('superuser/peserta_hapus'); ?>
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-checkable m-datatable--brand" id="m_table_1" style="width:99.9%;">
            <thead class="btn-brand">
                <tr>
                    <th class="text-center" width="60px">#</th>
                    <th class="text-center" width="150px">Nomor Identitas</th>
                    <th class="text-left">Nama Lengkap</th>
                    <th class="text-center" width="10px">L/P</th>
                    <th class="text-left" width="100px">Kelas</th>
                    <th class="text-center" width="100px">Status Akun</th>
                    <th class="text-center" width="100px">Aksi</th>
                    <th class="text-center" width="40px"><input type="checkbox" name="select-all" id="select-all" /></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (count($query) > 0) {
                    $no=$nomor+1;
                    foreach ($query as $row) {
                        echo"
                            <tr>
                                <td align='center'>".$no."</td>
                                <td align='center'>".$row["no_identitas"]."</td>
                                <td align='left'>".$row["nama_lengkap"]."</td>
                                <td align='center'>".$row["jenis_kelamin"]."</td>
                                <td align='left'>".$row["tingkat"]."-".$row["kelas"]."</td>
                                <td align='center'>".getActive($row["aktif_peserta"])."</td>
                                <td align='center'>
                                    ".anchor('superuser/peserta_edit/'.$row['peserta_id'],'<i class="la la-edit"></i> Edit')."
                                </td>
                                <td class='text-center'>
                                    <input type='checkbox' name='peserta_id[]' value='".$row["peserta_id"]."' id='checbox_id'/>
                                </td>
                            </tr>
                        ";
                        $no++;
                    }
                    $nomor_baru = $nomor+1;
                }else{
                    echo "<td align='center' colspan='9'>Data tidak ditemukan.</td>";
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
            <div class="col-lg-11">
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

<!-- MODAL -->
<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import Data Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('superuser/peserta_import'); ?>
                <h5>Unduh Template</h5>
                <p>Melalui tombol berikut ini : 
                    <a href="<?php echo base_url('_uploads/excel/sibayu_peserta_template.xlsx'); ?>" class="btn btn-success btn-sm popover-test" title="Unduh template">sibayu_peserta_template.xlsx</a>
                </p>
                <hr>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group">
                        <h5>Tahun Masuk</h5>
                        <div></div>
                        <?php echo form_dropdown('peserta_tahun_masuk', $tahun_masuk, '', 'class="form-control m-input" required'); ?>
                    </div>

                    <div class="form-group m-form__group">
                        <h5>Upload File Excel</h5>
                        <div></div>
                        <input name="import_data" type="file" class="form-control m-input" multiple required>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <?php echo form_submit('import_submit','Upload','class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"'); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- END: MODAL -->