<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Entri Pembayaran Tagihan Peserta
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo base_url('operator/pembayaran_detail/'.$peserta["peserta_id"]); ?>" class="btn btn-metal m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Kembali Detail</span>
                        </span>
                    </a>
                </li>
            </ul>    
        </div>
    </div>
    <div class="m-portlet__body">
        <?php echo form_open('operator/pembayaran_proses'); ?>
        <?php echo form_hidden('peserta_id', $peserta["peserta_id"]); ?>
        <div class="form-group m-form__group row">
            <div class="col-lg-2" >&nbsp;</div>
            <div class="col-lg-8" >
                <table width="100%" style="font-size: 14px;">
                    <tr>
                        <td width="110px">&nbsp;</td>
                        <td width="30px" align="center"></td>
                        <td>&nbsp;</td>

                        <td>&nbsp;</td>

                        <td width="110px">Tanggal Entri</td>
                        <td width="30px" align="center">:</td>
                        <td><?php echo tgl_lengkap(date('Y-m-d')); ?></td>
                    </tr>
                    <tr>
                        <td >No Identitas</td>
                        <td align="center">:</td>
                        <td><?php echo $peserta["no_identitas"]; ?></td>

                        <td>&nbsp;</td>

                        <td width="110px">Nama Petugas</td>
                        <td width="30px" align="center">:</td>
                        <td><?php echo $this->session->userdata("session_petugas_nama"); ?></td>
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
                </table>
                <hr/>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-checkable m-datatable--brand table-pembayaran" id="m_table_1" style="width:99.9%;">
                        <thead class="btn-brand">
                            <tr>
                                <th class="text-left">Nama Tagihan</th>
                                <th class="text-right" width="150px">Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $lunas = 0;
                                $no_tagihan = 0; 
                                $form_angsur = 0;
                                $form_sekali = 0;

                                $total_nominal = 0;
                                $total_bayar = 0;

                                if (count($tagihan) > 0) {

                                    $status_tagihan = "";
                                    $no=1;
                                    $data="";
                                    foreach ($tagihan as $row_tagihan) {
                                        $no_tagihan++;
                                        $sudah_dibayar = 0;

                                        if($row_tagihan["nominal"] == $sudah_dibayar){
                                            $status_tagihan = '<span class="m-badge m-badge--success m-badge--wide">lunas</span>';
                                        }else{
                                            $status_tagihan = '<span class="m-badge m-badge--danger m-badge--wide">belum lunas</span>';
                                        }

                                        $form = '';
                                        $nominal = rupiah($row_tagihan['nominal']);
                                        if($row_tagihan["tipe_tagihan"] == "angsur"){
                                            $form_angsur++;

                                            $dibayar = $this->superuser_model->rincianCek($peserta["peserta_id"], $row_tagihan["tagihan_id"]);
                                            $sisa = ($row_tagihan['nominal'] - $dibayar);
                                            if($sisa == 0){
                                                $lunas++;
                                                $form = '<span class="m-badge m-badge--success m-badge--wide">sudah lunas</span>';
                                            }else{
                                                $nominal = 'sisa tagihan: '.rupiah($sisa);
                                                echo form_hidden('id_angsur[]', $row_tagihan['tagihan_id']);
                                                $form = '<input name="input_angsur[]" type="text" value="0" required id="input_angsur" class="rupiah_format" data-v-max="'.$sisa.'" data-a-sep="." data-a-dec="," data-m-dec="0" style="text-align: right; width: 100%; padding: 5px 10px; border: 3px solid #999; border-radius: 5px; margin-right: 10px;" placeholder="-"/>';
                                            }
                                            $data .= '
                                                <tr>
                                                    <td class="text-left">'.$row_tagihan["nama_tagihan"].'<br><small>['.$row_tagihan['tipe_tagihan'].'] <strong>'.$nominal.'</strong></small></td>
                                                    <td class="text-right">
                                                        '.$form.'
                                                    </td>
                                                </tr>
                                            ';
                                        }else if($row_tagihan["tipe_tagihan"] == "sekali"){
                                            $form_sekali++;
                                            
                                            $dibayar = $this->superuser_model->rincianCek($peserta["peserta_id"], $row_tagihan["tagihan_id"]);
                                            $sisa = ($row_tagihan['nominal'] - $dibayar);
                                            if($sisa == 0){
                                                $lunas++;
                                                $form = '<span class="m-badge m-badge--success m-badge--wide">sudah lunas</span>';
                                            }else{
                                                $form = '<input name="input_sekali[]" type="checkbox"value="'.$row_tagihan["tagihan_id"].'-'.$row_tagihan["nominal"].'" id="input_sekali" style="transform: scale(2); margin-right: 10px;  border-radius: 50px;"/>';
                                            }
                                            $data .= '
                                                <tr>
                                                    <td class="text-left">'.$row_tagihan["nama_tagihan"].'<br><small>['.$row_tagihan['tipe_tagihan'].'] <strong>'.$nominal.'</strong></small></td>
                                                    <td class="text-right">
                                                        '.$form.'
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                        
                                        
                                        $total_nominal += $row_tagihan["nominal"];
                                        $total_bayar += $sudah_dibayar;
                                        $no++;
                                    }

                                    echo $data;
                                }else{
                                    echo "<tr><td align='center' colspan='10'>Belum ada tagihan.</td></tr>";
                                    $no = 0;
                                }
                            ?>

                        </tbody>
                        
                        <?php if($lunas != $no_tagihan && $no_tagihan != 0): ?>
                            <input type="hidden" type="text" id="input_diskon" value="0" />
                        <!--
                        <thead class="btn-brand">
                            <tr>
                                <th class="text-left">Subtotal :</th>
                                <th class="text-right" style="padding-right: 20px;"><div id="sub_total">-</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Diskon (Potongan):</td>
                                <td><input name="input_diskon[]" type="text" id="input_diskon" class="rupiah_format" value="0" required data-a-sep="." data-a-dec="," data-m-dec="0" style="text-align: right; width: 100%; padding: 5px 10px; border: 3px solid #999; border-radius: 5px; margin-right: 10px;" placeholder="-"/></td>
                            </tr>
                        </tbody>
                        -->
                        <thead class="btn-brand" style="font-size: 18px;">
                            <tr>
                                <th class="text-left">Total Bayar :</th>
                                <th class="text-right" style="padding-right: 20px;"><div id="total_bayar">-</div></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <th class="text-right">
                                <?php echo form_submit('bayar_submit', 'Proses', 'class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" style="width: 100%;"'); ?>
                                <br/>
                                <small class="keterangan text-light text-muted"></small>
                                </th>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <div class="col-lg-2" >&nbsp;</div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->