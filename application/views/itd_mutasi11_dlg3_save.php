<html>
<head>
<title>Rekap Jasa Giro</title>
</head>
<body>
<?php if($lvl>-5) { ?>
<?php if ($r_num_rows>0) { ?>
<?php 
$str_detail='';
$irow=0;
$total_giro=0;
$total_tax=0;
$total_net=0;
$field_no=3;   
foreach($r_sdata as $items) 
{ 
    if (trim($items['acc_no'])!='')
    { 
        if( ($incl_sign!='a' && $incl_sign!='-') || ($incl_sign=='a' && in_array($field_no,$incl)) || ($incl_sign=='-' && !in_array($field_no,$incl)))
        {
            $str_detail.="
        <tr bgcolor=\"" . ($irow%2==0?"#ffffff":"#F0F0F0") . "\">
            <td align=\"center\">'{$items['acc_no']}</td>
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
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#585858">
    <tr bgcolor="#D0D0D0" align="center">
        <td width="25%" align="center"><b>No. Rekening</b></td>
        <td align="center"><b>Nama</b></td>
        <td width="15%" align="center"><b>Debet (IDR)</b></td>
        <td width="15%" align="center"><b>Kredit (IDR)</td>
    </tr>
    <tr bgcolor="#ffffff">
        <td align="center">'079328065010100</td>
        <td>Bunga dibayar Jasa Giro</td>
        <td align="right"><?php echo number_format($total_giro,2,'.',',');?></td>
        <td align="right"></td>
    </tr>
    <tr bgcolor="#F0F0F0">
        <td align="center">'079512220000000</td>
        <td>MMU Pajak Jasa Giro</td>
        <td align="right"></td>
        <td align="right"><?php echo number_format($total_tax,2,'.',',');?></td>
    </tr>
<?php 
    echo $str_detail;
    $total_net+=$total_tax;
    echo "<tr bgcolor=\"" . ($irow%2==0?"#ffffff":"#F0F0F0") . "\">
        <td align=\"right\" colspan=\"2\"><b>TOTAL</b></td>
        <td align=\"right\"><b>" . number_format($total_giro,2,'.',',') . "</b></td>
        <td align=\"right\"><b>" . number_format($total_net,2,'.',',') . "</b></td>
    </tr>\n";
?>
</table>
<?php } ?>
<?php } ?>
</body>
</html>
