
<?php if($unit!=2) { ?> 
<input type="hidden" id="i_mutasi11_bf_ccode" />
<input type="hidden" id="i_mutasi11_bf_cname" />
<input type="hidden" id="i_mutasi11_bf_acc_no" />   
<input type="hidden" id="i_mutasi11_bf_coa_no" />   
<fieldset>
    <legend>Mutasi</legend>
<table width="100%" border="0">
    <tr>
        <td width="120">Kode Klien</td>
        <td width="1">:</td>
        <td><span id="s_mutasi11_bf_ccode"></span></td>
    </tr>
    <tr>
        <td>Rekening</td>
        <td>:</td>
        <td><span id="s_mutasi11_bf_accno"></span></td>
    </tr>
    <tr>
        <td>Atas Nama</td>
        <td>:</td>
        <td><span id="s_mutasi11_bf_cname"></span></td>
    </tr>
    <tr>
        <td>Tanggl Transaksi</td>
        <td>:</td>
        <td><span id="s_mutasi11_bf_dt"></span></td>
    </tr>
    <tr>
        <td>Tipe Transaksi</td>
        <td>:</td>
        <td><span id="s_mutasi11_bf_trx_type"></span></td>
    </tr>
    <tr>
        <td>Keterangan Transaksi</td>
        <td>:</td>
        <td><span id="s_mutasi11_bf_trx_desc"></span></td>
    </tr>
    <tr>
        <td>Nominal</td>
        <td>:</td>
        <td><span id="s_mutasi11_bf_trx_nominal"></span><input type="hidden" id="i_mutasi11_bf_trx_nominal" /></td>
    </tr>
</table>
</fieldset>
<fieldset>
    <legend>Broker Fee</legend>
<table width="100%" border="0">
    <tr>
        <td width="120">Nama Broker</td>
        <td width="1">:</td>
        <td><input type="text" id="i_mutasi11_bf_broker" style="width: 160px;" /></td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td><input type="text" id="i_mutasi11_bf_desc" style="width: 280px;" /></td>
    </tr>
    <tr>
        <td valign="top">Nominal</td>
        <td valign="top">:</td>
        <td><input type="text" id="i_mutasi11_bf_nominal" style="width: 180px; text-align: right;" />
        <input type="text" id="i_mutasi11_bf_nominal1" style="width: 180px; text-align: right;" readonly /></td>
    </tr>
    <tr>
        <td>Tanggal Settle</td>
        <td>:</td>
        <td><input type="text" id="i_mutasi11_bf_settle_dt" style="width: 80px;" /></td>
    </tr>
    <tr>
        <td valign="top">Dokumen</td>
        <td valign="top">:</td>
        <td>
        <select id="i_mutasi11_bf_doc">
            <option value="0">Belum Ada</option>
            <option value="1">Ada</option>
        </select>
    </tr>
    <tr>
        <td>Tanggal Dokumen</td>
        <td>:</td>
        <td><input type="text" id="i_mutasi11_bf_doc_dt" style="width: 80px;" /></td>
    </tr>
</table>
</fieldset>
<?php } ?>
