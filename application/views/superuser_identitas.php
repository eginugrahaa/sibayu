<!--begin::Portlet-->
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    Identitas Sekolah
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php echo form_open('superuser/identitas_proses','class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"'); ?>
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

                <!-- <div class="form-group m-form__group row">

                    <label class="col-lg-3 col-form-label">NPSN :</label>
                    <div class="col-lg-6">
                        <input name="iden_npsn" type="text" class="form-control m-input" placeholder="Enter NPSN" value="<?php echo $identitas[0]; ?>">
                    </div>
                </div> -->
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Nama Sekolah :</label>
                    <div class="col-lg-6">
                        <input name="iden_nama" type="text" class="form-control m-input" placeholder="Enter school name" value="<?php echo $identitas[1]; ?>" >
                    </div>
                </div>
                <!-- <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Nama Kepala Sekolah :</label>
                    <div class="col-lg-6">
                        <input name="iden_kepala" type="text" class="form-control m-input" placeholder="Enter headmaster name" value="<?php echo $identitas[2]; ?>" >
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">NIP Kepala Sekolah :</label>
                    <div class="col-lg-6">
                        <input name="iden_nip" type="text" class="form-control m-input" placeholder="Enter headmaster ID" value="<?php echo $identitas[3]; ?>" >
                    </div>
                </div> -->
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Alamat Sekolah :</label>
                    <div class="col-lg-6">
                        <input name="iden_alamat" type="text" class="form-control m-input" placeholder="Enter address name" value="<?php echo $identitas[4]; ?>" >
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Kota/Kabupaten :</label>
                    <div class="col-lg-6">
                        <input name="iden_kota" type="text" class="form-control m-input" placeholder="Enter contact" value="<?php echo $identitas[5]; ?>" >
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">Kontak Sekolah :</label>
                    <div class="col-lg-6">
                        <input name="iden_kontak" type="text" class="form-control m-input" placeholder="Enter contact" value="<?php echo $identitas[6]; ?>" >
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <?php echo form_submit('iden_submit', 'Simpan', 'class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"'); ?>
                        <br/>
                        <small class="keterangan text-light text-muted"></small>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
<!--end::Portlet-->