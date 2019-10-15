<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>

<div style="width: 100%; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">Mutasi Jasa Giro</div>
<div style="width: 100%;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <input type="hidden" id="i_mutasi11_trx_id" value="0">
            <tr>
                <td colspan="3">
                    <table width="100%" border="0">
                        <tr>
                            <td width="1%">Klien</td>
                            <td width="1%">Rekening</td>
                            <td width="1%">Atas Nama</td>
                        </tr>
                        <tr>
                            <td><input type="text" id="i_mutasi11_mfb_client_code" style="width:60px;text-align: center;"  /></td>
                            <td><input type="text" id="i_mutasi11_mfb_rek" style="width:120px;text-align: center;" readonly /></td>
                            <td><input type="text" id="i_mutasi11_mfb_client_name" style="width:320px;text-align: left;" readonly  /></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="1%">Kategori</td>
                <td width="1%">:</td>
                <td>
                    <select id="i_mutasi11_mfb_desc">
                        <option value="C007">Jual Obligasi</option>
                        <option value="D005">Beli Obligasi</option>
                    </select>
                    <input type="text" id="i_mutasi11_mfb_desc"  style="width:320px;text-align: left;" />
                </td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><input type="text" id="i_mutasi11_mfb_dt"  style="width:60px;text-align: center;" class="dtpick" /></td>
            </tr>
            <tr>
                <td>Broker</td>
                <td>:</td>
                <td><input type="text" id="i_mutasi11_mfb_brok"  style="width:80px;text-align: left;" /></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="checkbox" id="i_mutasi11_mfb_doc" align="left"   title="Dokumen tersedia" /></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <input type="button" id="btn_mutasi11_mfb_add" value="Tambah" />
                    <input type="button" id="btn_mutasi11_mfb_edit" value="Ubah" />
                    <input type="button" id="btn_mutasi11_mfb_del" value="Hapus" />
                    <input type="button" id="btn_mutasi11_mfb_cancel" value="Batal" />
                </td>
            </tr>
        </table>
    </div>
    <div id="tbl_slick_mutasi11_mfb_dlg" style="height: 150px;"></div>
</div>

<?php } ?>
<?php } ?>