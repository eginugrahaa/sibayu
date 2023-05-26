<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Edit Petugas
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('superuser/petugas'); ?>" class="btn btn-metal m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Kembali</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php echo form_open('superuser/petugas_edit/'.$petugas_id,'class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"'); ?>
        <div class="m-portlet__body">	
            <div class="m-form__section m-form__section--first">
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

                <?php echo form_hidden('petugas_id', $petugas_id); ?>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Level Petugas:</label>
                    <div class="col-lg-6">
                        <?php
                            $level = [
                                "teller"=>"Teller",
                                "admin"=>"Administrator / Bendahara"
                            ]; 
                            echo form_dropdown('petugas_level', $level, $petugas_level, 'class="form-control m-input" required'); ?>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Nama Pengguna:</label>
                    <div class="col-lg-6">
                        <input name="petugas_username" type="text" class="form-control m-input" placeholder="..." value="<?php echo $petugas_username; ?>" required pattern="[a-z0-9]+" style="text-transform: lowercase;">
                        <span class="m-form__help">Nama Pengguna harus bersifat unik dan hanya mengandung <strong>(huruf, angka dan karakter non-kapital)</strong>.</span>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Nama Petugas:</label>
                    <div class="col-lg-6">
                        <input name="petugas_nama" type="text" class="form-control m-input" placeholder="..." value="<?php echo $petugas_nama; ?>" required>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Status Aktif:</label>
                    <div class="col-lg-6">
                        <?php
                            $active = [
                                ""=>"-Pilih Status Akun-",
                                "1"=>"Active",
                                "0"=>"Deactive"
                            ]; 
                            echo form_dropdown('petugas_active', $active, $petugas_active, 'class="form-control m-input" required'); ?>
                            <span class="m-form__help">[Active] = petugas masih aktif. [Deactive] = petugas tidak aktif.</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <?php echo form_submit('peserta_submit', 'Simpan', 'class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"'); ?>
                        <br/>
                        <small class="keterangan text-light text-muted"></small>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>

<!-- END EXAMPLE TABLE PORTLET-->