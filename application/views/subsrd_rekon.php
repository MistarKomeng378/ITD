
<b>Date : <?php echo date_format(date_create($dt),'F d, Y');?></b> ,
<b><?php echo $t=='0'?'After Posting':'Before Posting';?></b>
<table width="100%" bgcolor="#585858">
    <tr bgcolor="#F0F0F0">
        <th rowspan="2" valign="middle">Client Code</th>
        <th rowspan="2" valign="middle">Client Name</th>
        <th rowspan="2" valign="middle" align="right">ITD Amount</th>
        <?php if($t=='0') {?>
        <th colspan="2">URS Net Proceed</th>
        <?php }?>
        <th colspan="2">URS Gross Proceed</th>
    </tr>
    <tr bgcolor="#F0F0F0">
        <?php if($t=='0') {?>
        <th align="right">Amount</th>
        <th align="right">Diff</th>
        <?php }?>
        <th align="right">Amount</th>
        <th align="right">Diff</th> 
    </tr>
<?php foreach($r_data as $xitem1){?>
    <tr bgcolor="#ffffff">
        <td><?php echo $xitem1['client_code'];?></td>
        <td><?php echo $xitem1['client_name'];?></td>
        <td align="right"><?php echo  number_format($xitem1['subsrd_nominal'],2,'.',',');?></td>
        <?php if($t=='0') {?>
        <td align="right"><?php echo number_format($xitem1['bal_net'],2,'.',',');?></td>
        <td align="right"><?php echo number_format($xitem1['diff_net'],2,'.',',');?></td>
        <?php }?>
        <td align="right"><?php echo number_format($xitem1['bal_gross'],2,'.',',');?></td>
        <td align="right"><?php echo number_format($xitem1['diff_gross'],2,'.',',');?></td> 
    </tr>
<?php }?>
</table>
