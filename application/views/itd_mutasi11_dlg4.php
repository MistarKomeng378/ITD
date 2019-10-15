<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { 
$arr_bln = array( 1 => 'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juni',8=>'Juli',
                9=>'Agustus',10=>'September',11=>'Oktober',12=>'Desember');
$tday= getdate();   ?>                                          

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
</table>
</div>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td width="1%">*</td>
    <td width="10%">Procesor</td>
    <td width="1%">:</td>
    <td><select id="i_mutasi11_dlg4_proc"></select></td>
    <!--
    <td>&nbsp;</td>
    <td width="1%">*</td>
    <td width="10%">Tanggal Balance</td>
    <td width="1%">:</td>
    <td><input type="text" id="i_mutasi11_dlg4_c_dt1" class="dpicker" style="width: 80px; text-align: center;" /></td>
    -->
    <td>&nbsp;</td>
    <td width="1%">*</td>
    <td width="10%">Tanggal</td>
    <td width="1%">:</td>
    <td><input type="text" id="i_mutasi11_dlg4_pdt" class="dtpick" style="width: 80px; text-align: center;" /></td>
    <td width="10%" align="right"><input type="button" value="View Jasa Giro" id="b_mutasi11_dlg4_getdata" /></td>
</tr>                             
</table>
<table width="760" border="0"><tr><td></td></tr></table>
<div id="i_mutasi11_dlg4_detail"></div>
</td>
</tr>
</table>
<?php } ?>
<?php } ?>