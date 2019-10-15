<html>
<head>
<title>Pending Subscription</title>
</head>
<body>
<?php if($lvl>-5) {?>
<table border="1" bgcolor="#580000" width="900">
 <tr bgcolor="#F0F0F0">
    <td align="center"><b>No.</b></td>
    <td align="center"><b>Kode Klien</b></td>
    <td align="center"><b>Nama Klien</b></td>
    <td align="center"><b>Kode Bank</b></td>
    <td align="center"><b>Nama Bank</b></td>
    <td align="center"><b>No Rekening</b></td>
    <td align="center"><b>Enable</b></td>
</tr>
<?php
if($r_num_rows>0)
{
    $irow=1;
    foreach($r_sdata as $item1)
    {
        ?>
<tr bgcolor="#FFFFFF">
    <td align="center"><?php echo $irow++;?></td>
    <td align="left"><?php echo $item1["client_code"];?></td>
    <td align="left"><?php echo $item1["client_name"];?></td>
    <td align="left"><?php echo $item1["bank_code"];?></td>
    <td align="left"><?php echo $item1["bank_desc"];?></td>
    <td align="left"><?php echo $item1["acc_no"];?></td>
    <td align="left"><?php echo $item1["rek_enable"];?></td>
</tr>
        
<?php } }?>
</table>
<?php  } ?>
</body>