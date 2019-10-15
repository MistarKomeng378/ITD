<html>
<head>
<title>Rekap Jasa Giro</title>
</head>
<body>
<?php if($lvl>-5) { ?>                                          
<table border="0">
<tr>
<td>
<table width="100%" border="0">
    <tr>
        <td align="center"><span style="font-weight: bolder; font-size: 125%;">INSTRUKSI JASA GIRO
<?php
    echo $r_ctype==1?"<br />(REKSADANA)":"";
    echo $r_ctype==2?"<br />UNITLINK":"";
    echo $r_ctype==3?"<br />DISKRE":"";
?> </span></td>
    </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="margin:10px;">
<tr>
    <td width="20%">Kepada</td>
    <td width="1%">:</td>
    <td>Bag. Accounting</td>
</tr>
<tr>
    <td>Tanggal</td>
    <td>:</td>
    <td><?php echo ($r_num_rows>0?$r_sdata[0]["giro_asof_date_s"]:"");?></td>
</tr>
</table>

<br />
<br />
<table border="0" bgcolor="#580000" width="900" style="font-size: 80%;">
<tr bgcolor="#F0F0F0">
    <td align="center"><b>No</b></td>
    <td align="center"><b>Kode</b></td>
    <td align="center"><b>Nama</b></td>
    <td align="center"><b>No. Rekening</b></td>
    <td align="center"><b>tnr</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Nominal</b></td>
    <td align="center"><b>Interest</b></td>
    <td align="center"><b>Tax</b></td>
    <td align="center"><b>Net Interest</b></td>
    <td align="center"><b><font color="#ffffff">...</font>ID<font color="#ffffff">...</font></b></td>
</tr>
<?php
if($r_num_rows>0)
{
    $irow=1;
    foreach($r_sdata as $item1)
    {
        ?>
<tr bgcolor="<?php echo ($irow%2==1?'#F8F8F8':'#FFFFFF');?>">
    <td align="center"><?php echo $irow++;?></td>
    <td align="center"><?php echo $item1["client_code"];?></td>
    <td><?php echo $item1["client_name"];?></td>
    <td align="center"><?php echo $item1["acc_no"];?></td>
    <td align="right"><?php echo number_format($item1["giro_tenor"],0,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["giro_rate"],2,'.',',');?>%</td>
    <td align="right"><?php echo number_format($item1["giro_nominal"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["giro_interest"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["giro_interest_tax"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["giro_interest_net"],2,'.',',');?></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
        
<?php }
}
?>
</table>
<br />
Demikian dan terimakasih atas bantuan dan kerjasamanya.
<table width="100%" border="0">
    <tr>
        <td width="90%" colspan="9">&nbsp;</td>
        <td align="center" colspan="3">Mengetahui,</td>
    </tr>
    <tr>
        <td colspan="9" >&nbsp;</td>
        <td align="center" valign="bottom" colspan="3"><br /><br /><br /><br />(...........................................)</td>
    </tr>
</table>
<?php } ?>
</body>
