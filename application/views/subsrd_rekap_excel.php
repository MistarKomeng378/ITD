<table border="1" bgcolor="#000000" width="100%" cellpadding="2" cellspacing="1">
    <tr bgcolor="#cccccc">
        <td align="center"><b>No</b></td>
        <td align="center"><b>Date</b></td>
        <td align="center"><b>Status<b></td>
        <td align="left"><b>MI</b></td>
        <td align="left"><b>Client</b></td>
        <td align="left"><b>Client Name</b></td>
        <td align="right"><b>Jumlah</b></td>
        <td align="left"><b>Source Bank</b></td>
        <td align="left"><b>Source Acc</b></td>
        <td align="left"><b>Dest Bank</b></td>
        <td align="left"><b>Dest Acc</b></td>
    </tr>

<?php                               
$irow=0;
foreach ($r_sdata as $item1){
?>
<tr bgcolor="<?php echo ($irow%2==0?'#ffffff':'efefef');?>">
    <td align="center"><?php echo ++$irow;?></td>
    <td align="center"><?php echo date_format($item1["subsrd_date"],'m/d/Y');?> </td>
    <td align="center"><?php echo ($item1["subsrd_status"]==1?'Closed':'Opened');?></td>
    <td align="left"><?php echo $item1["mi_name"];?></td>
    <td align="left"><?php echo $item1["client_code"];?></td>
    <td align="left"><?php echo $item1["client_name"];?></td>
    <td align="right"><?php echo number_format($item1["subsrd_nominal"],2,'.',',');?></td>
    <td align="left"><?php echo $item1["bank_src"];?></td>
    <td align="left"><?php echo "'" . $item1["acc_no_src"];?></td>
    <td align="left"><?php echo $item1["bank_dst"];?></td>
    <td align="left"><?php echo "'" . $item1["acc_no_dst"];?></td>
</tr>

<?php } ?>
    
</table>