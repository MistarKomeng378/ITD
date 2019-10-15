
<table border="0" bgcolor="#000000" width="100%" cellpadding="2" cellspacing="1">
    <tr bgcolor="#eeeeee">
<?php foreach($r_sdata_h as $item1){ ?>
        <td align="center"><b><?php echo $item1["sa_name"];?></b></td>
<?php }?>
    </tr>
<?php 
$total_all=0;
$total_sub = array();
foreach($r_sdata_h as $item1)
    $total_sub[$item1["sa_id"]]=0;
                            
foreach ($r_sdata as $item1){
?>
    <tr bgcolor="ffffff">
    <?php                 
    foreach($r_sdata_h as $item2) { 
        $total_all+=$item1[$item2["sa_id"]];         
        $total_sub[$item2["sa_id"]]+=$item1[$item2["sa_id"]];     
    ?>
        <td align="right"><?php echo $item1[$item2["sa_id"]]==0?'':number_format($item1[$item2["sa_id"]],2,'.',',');?></td>
    <?php }?>
    </tr>
<?php } ?>
    
    <tr bgcolor="#C0C0FF">
    <?php  foreach($r_sdata_h as $item2) {  ?> 
        <td align="right"><b><?php echo number_format($total_sub[$item2["sa_id"]],2,'.',',');?></b></td>
    <?php }?>
    </tr>
</table> 
<br />
<table border="0" bgcolor="#000000" width="100%" cellpadding="2" cellspacing="1"> 
    <tr bgcolor="#eeeeee">
        <td align="right"><b><span style="font-size: 110%">Total : <?php echo number_format($total_all,2,'.',',');?></span></b></td>
    </tr>
</table>