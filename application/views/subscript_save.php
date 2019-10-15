<html>
<head>
<title>Pending Subscription</title>
</head>
<body>
<?php if($lvl>-5) {
$tot_pending=0; 
$dt_update='';
$client_name ='';

if(isset($r_sdata1[0]["update_time_s"]))
   $dt_update= $r_sdata1[0]["update_time_s"];
if(isset($r_sdata[0]["client_name"]))
   $client_name = $r_sdata[0]["client_name"];

?>
<table>
<tr>
    <td colspan="3" align="left">&nbsp;<?php echo $dt_update;?></td>
</tr>
</table>
<table border="2">
<tr>
    <td colspan="3" align="center"><b>REKONSILIASI REKENING SUBSCRIPT</b></td>
</tr>
</table>
<table>
<tr>
    <td colspan="3" align="center"><b><?php echo "{$r_b_code}  {$r_b_accno} - {$client_name}";?></b></td>
</tr>
</table>

<table border="1" bgcolor="#580000" width="900">
<tr>
    <td align="center" colspan="3" bgcolor="#FF80FF"><b>Dana Pending</b></td>
    <!--
    <td align="center" colspan="2" bgcolor="#80FFFF"><b>Dana Dibukukan</b></td>
    -->
</tr>
<tr bgcolor="#F0F0F0">
    <td align="center" bgcolor="#FF80FF"><b>Tanggal</b></td>
    <td align="center" bgcolor="#FF80FF"><b>Keterangan</b></td>
    <td align="center" bgcolor="#FF80FF"><b>Nominal</b></td>
    <!--
    <td align="center" bgcolor="#80FFFF"><b>Nominal</b></td>
    <td align="center" bgcolor="#80FFFF"><b>Tanggal</b></td>
    -->
</tr>
<?php
if($r_num_rows>0)
{
    $irow=0;
    foreach($r_sdata as $item1)
    {            if($item1["subs_status"]==1)
                    continue;
        ?>
<tr bgcolor="#FFFFFF">
    <td align="center">&nbsp;<?php echo $item1["pending_dt_s"];?></td>
    <td align="left"><?php echo $item1["subs_desc"];?></td>
    <td align="right"><?php echo $item1["subs_status"]==1?'':number_format($item1["subs_nominal"],2,'.',',');?></td>
    <!--
    <td align="right"><?php echo $item1["subs_status"]==1?number_format($item1["subs_nominal"],2,'.',','):'';?></td>
    <td align="center">&nbsp;<?php echo$item1["subs_status"]==1?$item1["buku_dt_s"]:'';?></td>
    -->
</tr>
        
<?php $irow++;$tot_pending+=$item1["subs_status"]==1?0:$item1["subs_nominal"];}
}
?>
</table>
<table><tr><td>&nbsp;</td></tr></table>
<table>
<tr>
    <td></td>
    <td align="right"><b>Total Dana Pending :</b></td>
    <td><div style="border:1px solid #000" align="right"><?php echo number_format($tot_pending,2,'.',',');?></div></td>
</tr>
</table>
<table><tr><td>&nbsp;</td></tr></table>
<table>
<tr>
    <td></td>
    <td>
        <table border="1">
            <tr>
                <td align="right">Total Dana di Hiport:</td>
                <td align="right"><?php echo $r_num_rows1>0?number_format($r_sdata1[0]["hiport"],2,'.',','):'&nbsp;';?></td>
            </tr>
            <tr>
                <td align="right">Total Dana di Hiport+Dana Pending:</td>
                <td align="right"><?php echo $r_num_rows1>0?number_format($r_sdata1[0]["hiport"]+$tot_pending,2,'.',','):'&nbsp;';?></td>
            </tr>
            <tr>
                <td align="right">Saldo di rekening:</td>
                <td align="right"><?php echo $r_num_rows1>0?number_format($r_sdata1[0]["saldo_rek"],2,'.',','):'&nbsp;';?></td>
            </tr>
            <tr>
                <td align="right">Selisih:</td>
                <td align="right"><?php echo $r_num_rows1>0?number_format($r_sdata1[0]["hiport"]+$tot_pending-$r_sdata1[0]["saldo_rek"],2,'.',','):'&nbsp;';?></td>
            </tr>
        </table>
    </td>
</tr>
</table>   
<?php } ?>
</body>