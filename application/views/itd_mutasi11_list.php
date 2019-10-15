<html>
<head>
<title>Rekap Instruksi</title>

</head>
<body>
<?php if($lvl>-5) { ;?>
<?php $date="";if($r_success!=0 && $r_num_rows>0) { 
      
foreach($r_sdata as $items1)
{
$date="";
$c=0;
$d=0;     
$close=0;
$gs=0;
$selisih=0;
$no =1;
$remark='';

foreach($items1["data"] as $items)
{
    $d1= date_format($items["balance_date"],"d M Y");
    if ($d1!=$date)
    {
        $no=1;
        if($date!='')
{?>
    <tr>
        <td></td>
        <td><b>Total --></b></td>    
        <td align="right"><b><?php echo number_format($d,2,'.',',');?></b></td>
        <td align="right"><b><?php echo number_format($c,2,'.',',');?></b></td>
    </tr>
    
</table>
<table><tr><td></td></tr></table>
<table>
    <tr>
        <td></td>
        <td></td>
        <td colspan="2">
            <table border="1" bgcolor="#80FFFF">
                <tr>
                    <td><b>Saldo Akhir</b></td>
                    <td><b><?php echo number_format($close,2,'.',',');?></b></td>
                </tr>
                <tr bgcolor="#FFFF00">
                    <td><b>Saldo di Rekening</b></td>
                    <td><b><?php echo number_format($gs,2,'.',',');?></b></td>
                </tr>
                <tr>
                    <td><b>Selisih</b></td>
                    <td><b><?php echo number_format($close-$gs,2,'.',',');?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table><tr><td>Keterangan</td></tr></table>
<table border="1">
    <tr>
        <td colspan="4" rowspan="3"><?php echo $remark;?></td>
    </tr>
</table>
<?php }
        
        $date=$d1;
        $c=0;
        $d=0;     
        $close=0+$items["balance_close"];
        $gs=0+$items["balance_gs"];
        $remark=$items["balance_remark"];
        $selisih=$close-$gs;
        

?>
<table border="0">
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<table border="0">
    <tr>
        <td width="60"></td>
        <td width="320"></td>
        <td width="240"></td>
        <td width="240"><?php echo $date;?></td>
    </tr>
</table>
<table border="1" bgcolor="#80FFFF">
    <tr>
        <td colspan="4" align="center"><b><?php echo $items["client_code"] . ' - ' . $items['client_name'];?></b></td>
    </tr>
    <tr>
        <td colspan="4" align="center"><b><?php echo "'".$items["acc_no"];?></b></td>
    </tr>
</table>
<table>
    <tr><td></td></tr>
</table>
<table border="1">
    <tr>
        <td rowspan="2" align="center"><b>NO.</b></td>
        <td rowspan="2" align="center"><b>KET</b></td>
        <td colspan="2" align="center"><b>NOMINAL</b></td>
    </tr>
    <tr>
        <td align="center"><b>DEBET</b></td>
        <td align="center"><b>KREDIT</b></td>
    </tr>
<?php  } ?>
     <tr>
        <td align="center"><?php echo $no++;?></td>
        <td><?php echo $items["coa_desc"] . " " . $items["trx_desc"];?></td>
        <td align="right"><?php echo $items["trx_dc"]=='D'?number_format(0+$items["nominal"],2,'.',','):0 ;?></td>
        <td align="right"><?php echo $items["trx_dc"]=='C'?number_format(0+$items["nominal"],2,'.',','):0;?></td>
     </tr>
<?php    
$c += ($items["trx_dc"]=='C'?0+$items["nominal"]:0); 
$d+=($items["trx_dc"]=='D'?0+$items["nominal"]:0);
}
?>
<?php  
if($date!="")
{
?>

<tr>
        <td></td>
        <td><b>Total --></b></td>    
        <td align="right"><b><?php echo number_format($d,2,'.',',');?></b></td>
        <td align="right"><b><?php echo number_format($c,2,'.',',');?></b></td>
    </tr>
    
</table>
<table><tr><td></td></tr></table>
<table>
    <tr>
        <td></td>
        <td></td>
        <td colspan="2">
            <table border="1" bgcolor="#80FFFF">
                <tr>
                    <td><b>Saldo Akhir</b></td>
                    <td><b><?php echo number_format($close,2,'.',',');?></b></td>
                </tr>
                <tr bgcolor="#FFFF00">
                    <td><b>Saldo di Rekening</b></td>
                    <td><b><?php echo number_format($gs,2,'.',',');?></b></td>
                </tr>
                <tr>
                    <td><b>Selisih</b></td>
                    <td><b><?php echo number_format($close-$gs,2,'.',',');?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table><tr><td>Keterangan</td></tr></table>
<table border="1">
    <tr>
        <td colspan="4" rowspan="3" valign="top"><?php echo $remark;?></td>
    </tr>
</table>
<?php } } ?>
<?php }  }?>
</body>
</html>
