<html>
<head>
<title>Jasa Giro</title>
</head>
<body>
<?php if($lvl>-5) { ?>
<?php if($unit!=2) { ?>
<?php if ($r_num_rows>0) { ?>
<div style="width: 860px;">
<div style="border: 1px solid #7C3C10;">
<table width="100%" border="0">
    <tr>
        <td align="center"><span style="font-weight: bolder; font-size: 125%;">INSTRUKSI JASA GIRO</span></td>
    </tr>
</table>
</div>
<br />
<div style="border: 1px solid #7C3C10;">
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
<tr>
    <td colspan="6">&nbsp;</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td>Date</td>
    <td>:</td>
    <td><?php echo $r_sdata[0]["giro_val_date_s"];?></td>
</tr>
</table>
</div>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td width="2%">*</td>
    <td width="20%">Jenis Transaksi</td>
    <td width="1%">:</td>
    <td>Interest</td>
</tr>
<tr>
    <td>*</td>
    <td>Period</td>
    <td>:</td>
    <td><?php echo $r_sdata[0]["giro_asof_date_s"];?></td>
</tr>                                     
<tr>
    <td>*</td>
    <td>Rate</td>
    <td>:</td>
    <td><?php echo number_format($r_sdata[0]["giro_rate"],2,'.',',') . '%';?></td>
</tr>                                     
<tr>
    <td>*</td>
    <td>Tenor</td>
    <td>:</td>
    <td><?php echo $r_sdata[0]["giro_tenor"];?></td>
</tr>                                     
</table>
<br />
<table border="0" bgcolor="#580000" width="100%">
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
    <td><?php echo $r_sdata[0]["client_name"];?></td>
    <td align="center"><?php echo $r_sdata[0]["acc_no"];?></td>
    <td align="right"><?php echo number_format($r_sdata[0]["giro_rate"],2,'.',',') . '%';?></td>
    <td align="right"><?php echo number_format($r_sdata[0]["giro_nominal"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($r_sdata[0]["giro_interest"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($r_sdata[0]["giro_interest_tax"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($r_sdata[0]["giro_interest_net"],2,'.',',');?></td>
</tr>
</table>
<br />
Terima Kasih,
<br />
<table border="0" width="100%">
    <tr>
        <td width="30%"></td>
        <td>
            <table border="0" width="100%">
                <tr><td colspan="2" align="center">Hormat Kami,</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td align="center">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</td>
                    <td align="center">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
<?php } ?>
<?php } ?>
<?php } ?>
</body>
</html>
