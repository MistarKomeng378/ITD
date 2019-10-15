<div align="center">
<h2>REKAP ACCOUNT BALANCE OF CLIENT</h2>
<h3><?php echo $dt;?></h3>
<table bgcolor="#585858">
    <tr bgcolor="#E0E0E0">
        <td>No.</td>
        <td>Code</td>
        <td>Nama</td>        
        <td>Account</td>     
        <td>Closed</td>
        <td>Status</td>
        <td align="right">Bal Open</td>
        <td align="right">Bal Trx</td>
        <td align="right">Bal Close</td>
    </tr>
<?php 
$irow=0;
if(isset($rdata)){
    foreach($rdata as $xitem1){
?>
    <tr bgcolor="#FFFFFF" <?php echo $xitem1['c_status']==0?"style=\"color:#800000\"":"";?> >
        <td><?php echo ++$irow;?></td>
        <td><?php echo $xitem1['client_code'];?></td>
        <td><?php echo $xitem1['client_name'];?></td>
        <td align="center"><?php echo $xitem1['c_acc'];?></td>
        <td align="center"><?php echo $xitem1['c_close'];?></td>
        <td align="center"><?php echo  $xitem1['c_status']==1?"Completed":"<span style=\"color:#800000\">Un-Completed</span>";?></td>
        <td align="right"><?php echo $xitem1['c_status']==0?'':number_format($xitem1['s_open'],2,'.',',');?></td>
        <td align="right"><?php echo $xitem1['c_status']==0?'':number_format($xitem1['s_trx'],2,'.',',');?></td>
        <td align="right"><?php echo $xitem1['c_status']==0?'':number_format($xitem1['s_close'],2,'.',',') ;?></td>
    </tr>
<?php
    }
}
?>
</table>

</div>