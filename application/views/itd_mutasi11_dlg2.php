<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { 
$arr_bln = array( 1 => 'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juni',8=>'Juli',
                9=>'Agustus',10=>'September',11=>'Oktober',12=>'Desember');
$tday= getdate();   ?>
<input type="hidden" id="i_mutasi11_dlg2_c_code" name="c_code" />
<input type="hidden" id="i_mutasi11_dlg2_c_name" name="c_code" />
<input type="hidden" id="i_mutasi11_dlg2_acc_no" name="acc_no" />
<input type="hidden" id="i_mutasi11_dlg2_c_dt" name="c_dt" />

<table border="0">
<tr>
<td>
<div style="border: 1px solid #7C3C10; width: 100%;">
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="margin:10px;">
<tr>
    <td width="8%">Kepada</td>
    <td width="1%">:</td>
    <td width="49%">Bag. Fund Accounting</td>
    <td width="8%">Dari</td>
    <td width="1%">:</td>
    <td>Fund Account Support</td>
</tr>
<tr>
    <td></td>
    <td>:</td>
    <td>Bag. Portfolio Accounting</td>
    <td></td>
    <td>:</td>
    <td>Custody Account Support</td>
</tr>
<tr><td colspan="6">&nbsp;</td></tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td>Date</td>
    <td>:</td>
    <td><input type="text" id="i_mutasi11_dlg2_c_dt1" style="width: 80px; text-align: center;" readonly /></td>
</tr>
</table>
</div>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td width="1%">*</td>
    <td width="20%">Jenis Transaksi</td>
    <td width="1%">:</td>
    <td>Interest</td>
</tr>
<tr>
    <td>*</td>
    <td>Period</td>
    <td>:</td>
    <td><input type="text" id="i_mutasi11_dlg2_pdt" class="dtpick" style="width: 80px;" /></td>
</tr>                                     
<tr>
    <td>*</td>
    <td>Rate</td>
    <td>:</td>
    <td><input type="text" id="i_mutasi11_dlg2_rate" style="width: 60px; text-align: right;" /> %</td>
</tr>                                     
<tr>
    <td>*</td>
    <td>Tenor</td>
    <td>:</td>
    <td><input type="text" id="i_mutasi11_dlg2_tenor" style="width: 40px; text-align: center;" /></td>
</tr>   
<tr>
    <td>*</td>
    <td>Days in year</td>
    <td>:</td>
    <td>
        <select id="i_mutasi11_dlg2_year">
            <option value="360">360</option>
            <option value="365" selected>365</option>
            <option value="366">366</option>
        </select>
    </td>
</tr>                                     
                                  
</table>
<br />
<table border="0" bgcolor="#580000">
<tr bgcolor="#F0F0F0">
    <td align="center"><b>Nama Client</b></td>
    <td align="center"><b>No. Rekening</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Nominal</b></td>
    <td align="center"><b>Interest</b></td>
    <td align="center"><b>Tax</b></td>
    <td align="center"><b>Net Interest</b></td>
</tr>
<tr bgcolor="#FFFFFF">
    <td><input type="text" id="i_mutasi11_dlg2_cname" style="width: 160px; font-size: 75%;" readonly /></td>
    <td><input type="text" id="i_mutasi11_dlg2_ano" style="width: 115px; font-size: 90%;" readonly /></td>
    <td><input type="text" id="i_mutasi11_dlg2_rate1" style="width: 40px;text-align: center;" readonly /></td>
    <td><input type="text" id="i_mutasi11_dlg2_nml1" style="width: 125px;text-align: right;" readonly /></td>
    <td><input type="text" id="i_mutasi11_dlg2_int" style="width: 95px;text-align: right;" /></td>
    <td><input type="text" id="i_mutasi11_dlg2_tax" style="width: 80px;text-align: right;" /></td>
    <td><input type="text" id="i_mutasi11_dlg2_netint" style="width: 95px;text-align: right;" /></td>
</tr>
<tr bgcolor="#FFFFFF">
    <td colspan="4"></td>
    <td><input type="text" id="i_mutasi11_dlg2_int1" style="width: 95px;text-align: right;" readonly /></td>
    <td><input type="text" id="i_mutasi11_dlg2_tax1" style="width: 80px;text-align: right;" readonly /></td>
    <td><input type="text" id="i_mutasi11_dlg2_netint1" style="width: 95px;text-align: right;" readonly /></td>
</tr>
<input type="hidden" id="i_mutasi11_dlg2_nml"  />
</table>
</td>
</tr>
</table>
<?php } ?>
<?php } ?>