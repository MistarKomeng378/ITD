<html>
<head>
<title>Rekap Balance</title>
</head>
<body>
<?php if($lvl>-5) { ?>
<table border="1" bgcolor="#580000">
<tr bgcolor="#F0F0F0">
    <td align="center"><b>User</b></td>
    <td align="center"><b>Client Code</b></td>
    <td align="center"><b>Client Name</b></td>
    <td align="center"><b>No. Rekening</b></td>
    <td align="center"><b><?php echo $r_sdt1;?></b></td>
    <td align="center"><b><?php echo $r_sdt2;?></b></td>
    <td align="center"><b>Selisih</b></td>
</tr>
<?php
if($r_num_rows>0)
{
    $irow=0;
    foreach($r_sdata as $item1)
    {
        ?>
<tr bgcolor="<?php echo ($irow%2==1?'#F8F8F8':'#FFFFFF');?>">
    <td align="center"><?php echo $item1["client_user"];?></td>
    <td align="center"><?php echo $item1["client_code"];?></td>
    <td><?php echo $item1["client_name"];?></td>
    <td align="center">'<?php echo $item1["acc_no"];?></td>
    <td align="right"><?php echo number_format($item1["dt1"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["dt2"],2,'.',',');?></td>
    <td align="right"><?php echo number_format($item1["change"],2,'.',',');?></td>
</tr>
        
<?php $irow++;}
}
?>
</table>
<?php } ?>
</body>