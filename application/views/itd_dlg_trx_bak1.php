<div style="border: 1px solid #7C3C10;">
<input type="hidden" id="i_trx_id" name="i_trx_id" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="margin:10px;">
<tr>
    <td width="8%">Kepada</td>
    <td width="1%">:</td>
    <td width="49%"><input type="text" maxlength="50" name="i_trx_to" style="width:300px;" id="i_trx_to" /></td>
    <td width="8%">Dari</td>
    <td width="1%">:</td>
    <td>CUSTODY BANK CIMB NIAGA</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td><input type="text" maxlength="50" name="i_trx_remark1" style="width:300px;" id="i_trx_remark1" /></td>
    <td>Fax.</td>
    <td>:</td>
    <td>250-5206 / 250-5189 / 527-6051</td>
</tr>
<tr>
    <td>U.P.</td>
    <td>:</td>
    <td><input type="text" name="i_trx_up" style="width:240px;"   id="i_trx_up" /></td>
    <td>Ref</td>
    <td>:</td>
    <td><input type="hidden" name="i_trx_ref" style="width:150px;"  /><span id="s_trx_ref"></span></td>
</tr>

<tr>
    <td>No. Telp.</td>
    <td>:</td>
    <td><input type="text" name="i_trx_telp"  id="i_trx_telp"  /></td>
    <td>Tgl.</td>
    <td>:</td>
    <td><input type="text" id="i_trx_dt" name="i_trx_dt" style="width:80px;text-align: center;"   class="dtpick" /> (dd-mm-yyyy)</td>
</tr>

<tr>
    <td>No. Fax.</td>
    <td>:</td>
    <td><input type="text" name="i_trx_fax"  id="i_trx_fax" /></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

</table>
</div>

<div style="margin-top:5px;"> 
Mohon dilakukan transaksi untuk kepentingan klien kami, dengan detail sebagai berikut :
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td width="2%">*</td>
    <td width="35%">JENIS TRANSAKSI</td>
    <td width="2%">:</td>
    <td>
    <select name="i_trx_type" id="i_trx_type">
<?php foreach ($trx_type as $item):?>
        <option value="<?php echo $item["type_id"];?>"><?php echo $item["type_desc"];?></option>
<?php endforeach;?> 
    </select>
    <span id="s_trx_tgl_break"><input type="text" id="i_trx_break_dt" name="i_trx_break_dt" style="width:80px;text-align: center;" class="dtpick"  /> (dd-mm-yyyy)</span>
    </td>
</tr>
<tr>
    <td>*</td>
    <td>TIPE DEPOSITO</td>
    <td>:</td>
    <td>
    <select name="i_trx_deposit_type" id="i_trx_deposit_type">
<?php foreach ($deposit_type as $item):?>
        <option value="<?php echo $item["type_id"];?>" ><?php echo $item["type_desc"];?></option>
<?php endforeach;?>     
    </select>
    <input type="text" id="i_trx_deposit_tenor" name="i_trx_deposit_tenor"  style="width:40px;text-align: right;" class="data_entry"  />  Hari
    <span id="s_trx_deposit_tenor"></span>    <span id="s_trx_cek_tipe" style="color: red;" ></span>
    </td>
</tr>                                     
<tr>
    <td>*</td>
    <td>TANGGAL VALUTA</td>
    <td>:</td>
    <td><input type="text" id="i_trx_valuta_dt" name="i_trx_valuta_dt" style="width:80px;text-align: center;" class="dtpick"  /> (dd-mm-yyyy)</td>
</tr>
<tr>
    <td>*</td>
    <td>TANGGAL JATUH TEMPO</td>
    <td>:</td>
    <td><input type="text" id="i_trx_due_dt" name="i_trx_due_dt" style="width:80px;text-align: center;" class="dtpick"  /> (dd-mm-yyyy) </td>
</tr>                     
<tr>
    <td>*</td>
    <td>CLIENT CODE</td>
    <td>:</td>
    <td><input type="text" id="i_trx_client_code" /> <span id="s_trx_client_code" style="color:#FF0000"></span></td>
</tr>                      
</table>     
</div>          
<input type="hidden" id="i_trx_client_id" />
<div style="margin-top:5px;">
<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#7C3C10">
<tr bgcolor="#ffffff">
    <td align="center">NAMA KLIEN</td>
    <td align="center" width="25%" colspan="2">NOMINAL</td>
    <td align="center" width="15%">BUNGA</td>
</tr>
<tr bgcolor="#ffffff">
    <td align="center" valign="bottom">
    <span id="s_trx_client_name"></span>
    <input type="hidden" name="i_trx_client_name" id="i_trx_client_name"  />    <br />
    C/O Custodial Services
    </td>
    <td align="center" width="1%" valign="bottom">
    <select name="i_trx_curr" id="i_trx_curr">
        <?php foreach ($curr as $item):?>
        <option value="<?php echo $item["curr_code"];?>" ><?php echo $item["curr_desc"];?></option>
        <?php endforeach;?> 
    </select>
    </td>
    <td align="center" valign="bottom">
    <div id="trx_nominal" style="margin-bottom: 2px; font-weight: bold; text-align: right; padding: 1px 3px;">0</div>
    <input type="text" name="i_trx_nominal" id="i_trx_nominal" style="width: 170px;text-align: right;" /> 
    </td>
    <td align="center" valign="bottom"><div style="width:70px;"><input type="text" name="i_trx_rate" id="i_trx_rate" style="width: 35px;text-align: right;;"    /> %  pa</div></td>
</tr>
</table>    
</div>

<div style="margin-top:5px;"> 
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td width="2%">*</td>
    <td width="25%">STATUS PERPAJAKAN</td>
    <td width="2%">:</td>
    <td>
    <select name="i_trx_tax_status" id="i_trx_tax_status">
<?php foreach ($tax_status as $item):?>
        <option value="<?php echo $item["status_id"];?>" ><?php echo $item["status_desc"];?></option>
<?php endforeach;?> 
    </select>
    </td>
</tr>
<tr>
    <td>*</td>
    <td>PEMBAYARAN BUNGA</td>
    <td>:</td>
    <td>
    <select name="i_trx_payment_type" id="i_trx_payment_type">
<?php foreach ($rate_payment as $item):?>
        <option value="<?php echo $item["payment_id"];?>"  ><?php echo $item["payment_desc"];?></option>
<?php endforeach;?> 
    </select>
    ke Rekening Berikut :                        
    </td>
</tr>                                      
</table>                                                   
</div>               
        
<div style="margin-top:5px;">
<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#7C3C10">
<tr bgcolor="#ffffff">
    <td align="center" width="30%">NO. REKENING</td>
    <td align="center" width="30%">BANK</td>
    <td align="center" >ATAS NAMA</td>
</tr>
<tr bgcolor="#ffffff">
    <td align="center"><span id="s_trx_client_acc_no"></span><input type="hidden" name="i_trx_client_acc_no" id="i_trx_client_acc_no"  /></td>
    <td align="center"><span id="s_trx_client_bank_name"></span><input type="hidden" name="i_trx_client_bank_name" id="i_trx_client_bank_name"  /></td>
    <td align="center"><span id="s_trx_client_acc_name"></span><input type="hidden" name="i_trx_client_acc_name" id="i_trx_client_acc_name"  /></td>
</tr>
</table>    
</div>

<div style="margin-top:5px;"> 
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td width="2%">*</td>
    <td width="25%">SAAT JATUH TEMPO</td>
    <td width="2%">:</td>
    <td>
    <select id="i_trx_due_dt_status" name="i_trx_due_dt_status" >
<?php foreach ($due_date_status as $item):?>
        <option value="<?php echo $item["status_id"];?>"  ><?php echo $item["status_desc"];?></option>
<?php endforeach;?> 
    </select>
    </td>
</tr>
<tr>
    <td width="2%" valign="top">*</td>
    <td width="25%" valign="top">LAIN - LAIN</td>
    <td width="2%" valign="top">:</td>
    <td><textarea cols="50" rows="3" name="i_trx_other" id="i_trx_other"></textarea></td>
</tr>           
<tr id="dlg_trx_note" style="display: none;">
    <td width="2%" valign="top"></td>
    <td width="25%" valign="top">NOTE</td>
    <td width="2%" valign="top">:</td>
    <td><textarea cols="50" rows="3" name="i_trx_note" id="i_trx_note"></textarea></td>
</tr>           
<tr id="dlg_trx_key" style="display: none;">
    <td width="2%" valign="top"></td>
    <td width="25%" valign="top">INSTRUKSI DEPOSITO KEY</td>
    <td width="2%" valign="top">:</td>
    <td><span id="s_trx_key"></span></td>
</tr> 
</table>  
</div> 
