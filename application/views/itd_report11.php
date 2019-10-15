<?php if($lvl>-5) { ?>

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
        <td width="200">NAMA DANA PENSIUN</td>
        <td width="2">:</td>
        <td><?php echo $r_sdata[0]["trx_client_name"];?></td>
    </tr>
    <tr>
        <td>NPWP</td>
        <td>:</td> 
        <td></td>
    </tr>
    <tr>
        <td valign="top">ALAMAT</td>
        <td valign="top">:</td> 
        <td></td>
    </tr>
    <tr>
        <td valign="top">PERIODE</td>
        <td valign="top">:</td> 
        <td><?php echo $s_dt . ' s/d ' .$e_dt;?></td>
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
        <td>:</td> 
        <td></td>
    </tr>
    <tr>
        <td valign="top">ALAMAT</td>
        <td valign="top">:</td> 
        <td></td>
    </tr>
    <tr>
        <td valign="top">PERIODE</td>
        <td valign="top">:</td> 
        <td></td>
    </tr>
</table>
<?php }?>
<table border="0" bgcolor="#000000" width="100%" cellpadding="2" cellspacing="1">
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
        <td align="center"><?php echo $item1["trx_valuta_date_s"];?></td>
        <td align="center"><?php echo $item1["trx_due_date_s"];?></td>
        <td><div align="right" style="float: right;"><?php echo number_format($item1["trx_nominal"],2,'.',',');?></div><div>Rp.</div></td>
        <td><div align="right" style="float: right;"><?php echo number_format($item1["trx_nominal"]*$item1["trx_rate"]/100*$item1["trx_deposit_tenor_hr"]/$th,2,'.',',');?></div><div>Rp.</div></td>
        <td></td>
    </tr>
<?php }?>
    <tr bgcolor="ffffff">
        <td colspan="4" align="right"><b>JUMLAH</b></td>
        <td><div align="right" style="float: right;"><?php echo number_format($j_inv,2,'.',',');?></div><div>Rp.</div></td>
        <td><div align="right" style="float: right;"><?php echo number_format($j_rate,2,'.',',');?></div><div>Rp.</div></td>
        <td></td>
    </tr>
</table>
<?php } ?>