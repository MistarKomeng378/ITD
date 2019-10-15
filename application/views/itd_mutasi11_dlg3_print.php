<html>
<head>
<title>Rekap Jasa Giro</title>
</head>
<body>
<?php if($lvl>-5) { ?>
<?php if($unit!=2) { ?>
<?php if ($r_num_rows>0) { ?>
<div style="width: 860px;">
<div style="border: 1px solid #585858;">
<table width="100%" border="0">
    <tr>
        <td align="center"><span style="font-weight: bolder; font-size: 125%;">INSTRUKSI JASA GIRO ISTIMEWA</span></td>
    </tr>
</table>
</div>
<br />
<div style="border: 1px solid #585858;">
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="margin:10px;">
<tr>
    <td width="8%">Kepada</td>
    <td width="1%">:</td>
    <td width="49%"><?php echo $r_sdata1[0]["param1"];?></td>
    <td width="8%">Dari</td>
    <td width="1%">:</td>
    <td><?php echo $r_sdata1[0]["param6"];?></td>
</tr>
<tr>
    <td valign="top">Up</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $r_sdata1[0]["param2"];?><br /><?php echo $r_sdata1[0]["param3"];?></td>
    <td valign="top">Telp</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $r_sdata1[0]["param7"];?><br /><?php echo $r_sdata1[0]["param8"];?></td>
</tr>
<tr>
    <td>No.Fax</td>
    <td>:</td>
    <td><?php echo $r_sdata1[0]["param4"];?></td>
    <td>No.Fax</td>
    <td>:</td>
    <td><?php echo $r_sdata1[0]["param9"];?></td>
</tr>
<tr>
    <td>No.Telp</td>
    <td>:</td>
    <td><?php echo $r_sdata1[0]["param5"];?></td>
    <td>Date</td>
    <td>:</td>
    <td><?php echo $dt;?></td>
</tr>
</table>
</div>
<br />
<?php 
$str_detail='';          // print_r($incl);      echo $incl_sign;
$irow=0;
$total_giro=0;
$total_tax=0;
$total_net=0;
$no_row=3;
$field_no=$no_row;
foreach($r_sdata as $items) 
{ 
    if (trim($items['acc_no'])!='')
    {    
        if( ($incl_sign!='a' && $incl_sign!='-') || ($incl_sign=='a' && in_array($field_no,$incl)) || ($incl_sign=='-' && !in_array($field_no,$incl)))
        {
            $str_detail.="
        <tr bgcolor=\"" . ($irow%2==0?"#ffffff":"#F0F0F0") . "\">
            <td align=\"center\">" .  $no_row++ . "</td>
            <td align=\"center\">{$items['acc_no']}</td>
            <td>{$items['client_name']}</td>
            <td>&nbsp;</td>
            <td align=\"right\">" . number_format($items['giro_interest_net'],2,'.',',') . "</td>
        </tr>\n";
            $irow++;
            $total_giro+=$items["giro_interest"];
            $total_tax+=$items["giro_interest_tax"];
            $total_net+=$items["giro_interest_net"];
        }
        $field_no++;
    } 
} 
$str_total= ($total_net==''?'':"
    <tr bgcolor=\"" . ($irow%2==0?"#ffffff":"#F0F0F0") . "\">
        <td align=\"right\" colspan=\"2\"><b>TOTAL</b></td>
        <td align=\"right\">" . number_format($total_net,2,'.',',') . "</td>
    </tr>\n");

?>

Mohon bantuannya untuk melakukan pembayaran Jasa Giro dengan jurnal transaksi sbb :
<br />
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#585858" style="font-size: 95%;">
    <tr bgcolor="#D0D0D0" align="center">
        <td width="1%" align="center"><b>No.</b></td>
        <td width="10%" align="center"><b>No. Rekening</b></td>
        <td align="center"><b>Nama</b></td>
        <td width="12%" align="center"><b>Debet (IDR)</b></td>
        <td width="12%" align="center"><b>Kredit (IDR)</td>
    </tr>
    <tr bgcolor="#ffffff">
        <td align="center">1</td>
        <td align="center">079328065010100</td>
        <td>Bunga dibayar Jasa Giro</td>
        <td align="right"><?php echo number_format($total_giro,2,'.',',');?></td>
        <td align="right"></td>
    </tr>
    <tr bgcolor="#F0F0F0">
        <td align="center">2</td>
        <td align="center">079512220000000</td>
        <td>MMU Pajak Jasa Giro</td>
        <td align="right"></td>
        <td align="right"><?php echo number_format($total_tax,2,'.',',');?></td>
    </tr>
<?php 
    echo $str_detail;
    $total_net+=$total_tax;
    echo "<tr bgcolor=\"" . ($irow%2==0?"#ffffff":"#F0F0F0") . "\">
        <td align=\"right\" colspan=\"3\"><b>TOTAL</b></td>
        <td align=\"right\"><b>" . number_format($total_giro,2,'.',',') . "</b></td>
        <td align=\"right\"><b>" . number_format($total_net,2,'.',',') . "</b></td>
    </tr>\n";
?>
</table>
 <br />
Demikian dan terimakasih atas bantuan dan kerjasamanya.
<br />
<table width="100%" border="0">
    <tr>
        <td width="90%" colspan="9">&nbsp;</td>
        <td align="center" colspan="3">Mengetahui,</td>
    </tr>
    <tr>
        <td colspan="9" >&nbsp;</td>
        <td align="center" valign="bottom" colspan="3"><br /><br /><br /><br />(..............................................)</td>
    </tr>
</table>

</div>
<?php } ?>
<?php } ?>
<?php } ?>
</body>
</html>
