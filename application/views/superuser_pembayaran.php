<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Halaman Pembayaran Peserta Didik Aktif
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            
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

        <?php echo form_open('superuser/pembayaran_filter'); ?>
        <div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label>No-Identitas / Nama-Peserta:</label>
                <?php echo form_input('filter_nama', $value_nama, 'class="form-control m-input" placeholder="..." autofocus'); ?>
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
                        '.anchor('superuser/pembayaran','<i class="la la-refresh"></i>','title="Reset Filter" class="btn form-control btn-default m-input"').'
                    </div>
                    ';
                }
            ?>
        </div>
        <?php echo form_close(); ?>
        <!--begin: Datatable -->
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-checkable m-datatable--brand" id="m_table_1" style="width:99.9%;">
            <thead class="btn-brand">
                <tr>
                    <th class="text-center" width="60px">#</th>
                    <th class="text-center" width="150px">Nomor Identitas</th>
                    <th class="text-left">Nama Lengkap</th>
                    <th class="text-center" width="10px">L/P</th>
                    <th class="text-left" width="100px">Kelas</th>
                    <th class="text-center" width="100px">Jumlah Tagihan</th>
                    <!-- <th class="text-center" width="120px">Tahun Masuk</th> -->
                    <th class="text-center" width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (count($query) > 0) {
                    $no=$nomor+1;
                    foreach ($query as $row) {

                        $countTagihan = $this->superuser_model->countPesertaTagihan($row["peserta_id"]);

                        echo"
                            <tr>
                                <td align='center'>".$no."</td>
                                <td align='center'>".$row["no_identitas"]."</td>
                                <td align='left'>".$row["nama_lengkap"]."</td>
                                <td align='center'>".$row["jenis_kelamin"]."</td>
                                <td align='left'>".$row["tingkat"]."-".$row["kelas"]."</td>
                                <td align='center'>".toNumberFormat($countTagihan)."</td>
                                <td align='center'>
                                    ".anchor('superuser/pembayaran_detail/'.$row['peserta_id'],'<span class="badge badge-pill badge-success" style="border-radius: 0px; padding: 5px 10px;width: 100%;">Bayar</span>')." 
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

    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
