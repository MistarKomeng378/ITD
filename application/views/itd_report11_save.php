<html>
<head>
<title>Rekap Instruksi</title>

</head>
<body>
<?php if($lvl>-5) { ?>
<?php if($r_success!=0) { ?>
<table>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">LAMPIRAN V C</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3">PERATURAN DIREKTUR JENDERAL PAJAK</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">NOMOR : 160/PJ/2005</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">TANGGAL : 09 NOVEMBER 2005</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20"></td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">Yth. Kepala Dana Pensiun</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20"><b><?php if(count($r_sdata)>0) {echo $r_sdata[0]["trx_client_name"];}?></b></td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">di Jakarta</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20"></td>
    </tr>
</table>
<?php } ?>
<?php if($r_success==0) { ?>
<div align="center"><b>DAFTAR DEPOSITO</b></div>
<?php } elseif(count($r_sdata)>0) { ?>
<div align="center"><b>DAFTAR DEPOSITO <?php echo strtoupper($r_sdata[0]["trx_client_name"]);?></b></div>
<?php }else{?>
<div align="center"><b>DAFTAR DEPOSITO</b></div>
<?php };?>
<?php if(count($r_sdata)>0) {?>
<table border="0" width="700">
    <tr>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2">NAMA DANA PENSIUN</td>
        <td colspan="4">: <?php echo $r_sdata[0]["trx_client_name"];?></td>
    </tr>
    <tr>
        <td colspan="2">NPWP</td>
        <td colspan="4">: </td>
    </tr>
    <tr>
        <td valign="top" colspan="2">ALAMAT</td>
        <td colspan="4">: </td>
    </tr>
    <tr>
        <td valign="top" colspan="2">PERIODE</td>
        <td colspan="4">: <?php echo $s_dt . ' s/d ' .$e_dt;?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
</table>
<?php }else{?>
<table border="0" width="700">
    <tr>
        <td width="200">NAMA DANA PENSIUN</td>
        <td width="2">:</td>
        <td></td>
    </tr>
    <tr>
        <td>NPWP</td>
        <td>:
        <td></td>
    </tr>
    <tr>
        <td valign="top">ALAMAT</td>
        <td valign="top">:
        <td></td>
    </tr>
    <tr>
        <td valign="top">PERIODE</td>
        <td valign="top">:
        <td></td>
    </tr>
</table>
<?php }?>
<table border="1" bgcolor="#000000" width="100%" cellpadding="2" cellspacing="1">
    <tr bgcolor="#eeeeee">
        <td rowspan="2" align="center"><b>NO</b></td>
        <td rowspan="2" align="center"><b>NOMOR BILYET</b></td>
        <td colspan="2" align="center"><b>TANGGAL</b></td>
        <td rowspan="2" align="center"><b>JUMLAH INVESTASI</b></td>
        <td rowspan="2" align="center"><b>JUMLAH BUNGA</b></td>
        <td rowspan="2" align="center" width="200"><b>KET</b></td>
    </tr>
    <tr bgcolor="#eeeeee">
        <td align="center"><b>PENEMPATAN</b></td>
        <td align="center"><b>PENCAIRAN</b></td>
    </tr>
<?php 
$j_inv =0;
$j_rate=0;
$i_no=1;
foreach ($r_sdata as $item1) { 
    $j_inv+=$item1["trx_nominal"];
    $j_rate+=$item1["trx_nominal"]*$item1["trx_rate"]/100*$item1["trx_deposit_tenor_hr"]/$th;
?>
    <tr bgcolor="ffffff">
        <td><?php echo $i_no++;?></td>
        <td align="center"><?php echo $item1["bilyet_no_s"];?></td>
        <td align="center"><?php echo date_format($item1["trx_valuta_date"],"y/m/d");?></td>
        <td align="center"><?php echo date_format($item1["trx_due_date"],"y/m/d");?></td>
        <td><div align="right"><?php echo number_format($item1["trx_nominal"],2,'.',',');?></div></td>
        <td><div align="right"><?php echo number_format($item1["trx_nominal"]*$item1["trx_rate"]/100*$item1["trx_deposit_tenor_hr"]/$th,2,'.',',');?></div></td>
        <td></td>
    </tr>
<?php }?>
    <tr bgcolor="ffffff">
        <td colspan="4" align="right"><b>JUMLAH</b></td>
        <td><div align="right"><?php echo number_format($j_inv,2,'.',',');?></div></td>
        <td><div align="right"><?php echo number_format($j_rate,2,'.',',');?></div></td>
        <td></td>
    </tr>
</table>
<?php } ?>

<?php if($r_success!=0) { ?>
<table>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr> 
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">JAKARTA, <?php if(count($r_sdata)>0) {echo date_format($r_sdata[0]["trx_valuta_date"],'M Y');}?></td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">Bank / Pemotong Pajak ...............</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20"></td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20"></td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20"></td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">.....................................</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">&nbsp; &nbsp; &nbsp; Bank CIMB Niaga</td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
        <td colspan="3" height="20">NPWP : 01.310.668.7-091-000</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
</table>
<table border="1">
    <tr>
        <td colspan="6">
        <table>
            <tr>
                <td colspan="6">Lembar ke-1 : untuk Kepala KPP tempat Bank Pemotong Pajak terdaftar</td>
            </tr>
            <tr>
                <td colspan="6">Lembar ke-2 : arsip bank yang bersangkutan</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">D.1.1.33.82</td>
    </tr>
</table>
<?php } ?>
</body>
</html>