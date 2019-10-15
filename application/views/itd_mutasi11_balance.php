<html>
<head>
<title>Rekap Balance</title>
</head>
<body>
<?php if($lvl>-5) { ?>
<table border="1" bgcolor="#580000" width="900">
<tr bgcolor="#F0F0F0">
    <td align="center"><b>Status</b></td>
    <td align="center"><b>Client Code</b></td>
    <td align="center"><b>Client Name</b></td>
    <td align="center"><b>No. Rekening</b></td>
    <td align="center"><b>Tanggal</b></td>
    <td align="center"><b>Opening</b></td>
    <td align="center"><b>Mutasi</b></td>
    <td align="center"><b>Closing</b></td>
    <td align="center"><b>GS</b></td>
    <td align="center"><b>Selisih</b></td>
    <td align="center"><b>Remark</b></td>
    <td align="center"><b>Created by</b></td>
    <td align="center"><b>Closed by</b></td>
</tr>
<?php
if($r_num_rows>0)
{
    $irow=0;
    foreach($r_sdata as $item1)
    {
        ?>
<tr bgcolor="<?php echo ($irow%2==1?'#F8F8F8':'#FFFFFF');?>">
    <td align="center"><?php echo ($item1["balance_status"]==2?"Closes":"Opened");?></td>
    <td align="center"><?php echo $item1["client_code"];?></td>
    <td><?php echo $item1["client_name"];?></td>
    <td align="center">'<?php echo $item1["acc_no"];?></td>
    <td align="center"><?php echo $item1["balance_date_s"];?></td>
    <td align="right"><?php echo number_format($item1["balance_open"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["balance_trx"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["balance_close"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["balance_gs"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["balance_close"]-$item1["balance_gs"],2,'.',',');?></td>
    <td><?php echo $item1["balance_remark"];?></td>
    <td><?php echo $item1["balance_open_by"];?></td>
    <td><?php echo $item1["balance_close_by"];?></td>
</tr>
        
<?php $irow++;}
}
?>
</table>
<?php } ?>
</body>