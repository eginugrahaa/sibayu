<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Tambah Tahun Masuk
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('superuser/tahun_masuk'); ?>" class="btn btn-metal m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Kembali</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php echo form_open('superuser/tahun_masuk_tambah','class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"'); ?>
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

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Nama Tahun Masuk:</label>
                    <div class="col-lg-6">
                        <input name="peserta_tahun_masuk" type="text" class="form-control m-input" placeholder="..." value="<?php echo $peserta_tahun_masuk; ?>" required>
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