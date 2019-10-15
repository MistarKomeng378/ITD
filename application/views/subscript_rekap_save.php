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
    <td align="center"><b>Last Pending</b></td>
    <td align="center"><b>Last Buku</b></td>
    <td align="center"><b>Update dt</b></td>
    <td align="center"><b>Pending Upd</b></td>
    <td align="center"><b>Hiport Upd</b></td>
    <td align="center"><b>Pending+Hiport Upd</b></td>
    <td align="center"><b>Saldo Upd</b></td>
    <td align="center"><b>Selisih Upd</b></td>
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
    <td align="right"><?php echo number_format($item1["pending"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["buku"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["update_time_s"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["pending_upd"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["hiport_upd"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["hiport_upd"]+$item1["pending_upd"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["saldo_upd"],2,',','.');?></td>
    <td align="right"><?php echo number_format($item1["saldo_upd"]-$item1["pending_upd"]-$item1["hiport_upd"],2,',','.');?></td>
    
</tr>
        
<?php } }?>
</table>
<?php  } ?>
</body>