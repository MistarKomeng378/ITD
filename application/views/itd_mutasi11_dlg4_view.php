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
        <td align="center"><span style="font-weight: bolder; font-size: 125%;">INSTRUKSI JASA GIRO</span></td>
    </tr>
</table>
<b>Tanggal: <?php echo ($r_num_rows>0?$r_sdata[0]["giro_asof_date_s"]:"");?></b>
<table border="0" bgcolor="#580000" width="100%" style="font-size: 80%;">
<tr bgcolor="#F0F0F0">
    <td align="center"><b>No</b></td>
    <td align="center"><b>Kode</b></td>
    <td align="center"><b>Nama</b></td>
    <td align="center"><b>No. Rekening</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Nominal</b></td>
    <td align="center"><b>Interest</b></td>
    <td align="center"><b>Tax</b></td>
    <td align="center"><b>Net Interest</b></td>
</tr>
<?php
if($r_num_rows>0)
{
    $irow=1;
    foreach($r_sdata as $item1)
    {
        ?>
<tr bgcolor="<?php echo ($irow%2==1?'#D6D6EB':'#FFFFFF');?>">
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
</tr>
        
<?php }
}
?>
</table>

<?php } ?>
</body>
