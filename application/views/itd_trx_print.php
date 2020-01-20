<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Instruksi Transaksi Deposito</title>  
    <style type="text/css">
body {
 background-color: #ffffff;
 margin: 10px;
 font-family: Arial, Verdana, Sans-serif;
 font-size: 10pt;
 color: #000000;
 margin:0;
 padding:0;                                             
}                                                          
.big1 { 
    font-size: 13pt;
    text-transform: capitalize;
    font-weight: bolder;
}
.big2 { 
    font-size: 17pt;
    text-transform: capitalize;
}
.small{
    font-size: 8pt;
}
.box{             
    border: 2px solid #000000 ;
    padding: 2px 8px;
    margin-bottom: 5px;;
}
.box_blank{             
    padding: 0px;
    margin-bottom: 5px;;
}
    </style>
</head>
<body>
<div style="width: 800px; margin: 0 auto;padding:0; background-color: #FFFFFF;">
<div style="color: #F0F0F0;" align="center">. <br /><br /><br /><br /><br /><br /></div>
<!--
<img src="<?php echo $url;?>img/cimb.png" style="margin: 0;" />         <br />
-->
<div class="box" align="center" style="margin-top:5px;margin-bottom:10px;"><span class="big1"><?php echo $r_sdata["param_title"];?></span></div>

<div class="box">
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
    <td width="10%">Kepada</td>
    <td width="2%">:</td>
    <td width="40%"><?php echo $r_sdata["trx_to"];?></td>
    <td width="4%">Dari</td>
    <td width="2%">:</td>
    <td><?php echo $r_sdata["trx_from"];?></td>
</tr>             
<tr>
    <td></td>
    <td></td>
    <td><?php echo $r_sdata["trx_remark1"];?></td>
    <td>Fax.</td>
    <td>:</td>
    <td><?php echo $r_sdata["param_fax"];?></td>
</tr>
<tr>
    <td>U.P.</td>
    <td>:</td>
    <td><?php echo $r_sdata["trx_up"];?></td>
    <td>Ref</td>
    <td>:</td>
    <td><?php echo $r_sdata["trx_ref"];?></td>
</tr>

<tr>
    <td>No. Telp.</td>
    <td>:</td>
    <td><?php echo $r_sdata["trx_telp"];?></td>
    <td>Tgl.</td>
    <td>:</td>
    <td><?php echo date_format($r_sdata["trx_date"],"d M Y");?></td>
</tr>

<tr>
    <td>No. Fax.</td>
    <td>:</td>
    <td><?php echo $r_sdata["trx_fax"];?></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

</table>                            
</div>
<div class="box_blank" style="margin-top: 15px;"> 
Mohon dilakukan transaksi untuk kepentingan klien kami, dengan detail sebagai berikut :
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
    <td width="2%">*</td>
    <td width="25%">JENIS TRANSAKSI</td>
    <td width="2%">:</td>
    <td><b><span style="font-size:11pt"><?php echo $r_sdata["type_desc"]  ; echo  ($r_sdata["trx_type"]==4)?" pada tanggal " . date_format($r_sdata["trx_break_dt"],"d M Y"):"";?></span></b></td>
</tr>
<tr>
    <td>*</td>
    <td>TIPE DEPOSITO</td>
    <td>:</td>
    <td><?php echo $r_sdata["deposit_desc"] . " " . $r_sdata["trx_deposit_tenor"] . " " . ($r_sdata["trx_deposit_type"]==1?"Hari":"Bulan");?></td>
</tr>                                     
<tr>
    <td>*</td>
    <td>TANGGAL VALUTA</td>
    <td>:</td>
    <td><?php echo date_format($r_sdata["trx_valuta_date"],"d M Y");?></td>
</tr>
<tr>
    <td>*</td>
    <td>TANGGAL JATUH TEMPO</td>
    <td>:</td>
    <td><?php echo date_format($r_sdata["trx_due_date"],"d M Y");?></td>
</tr>                     
</table>     
</div>                   
<p></p>
<div class="box_blank" style="margin-bottom: 15px;"> 
<table border="0" width="100%" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr bgcolor="#ffffff">
    <td align="center" ><b>NAMA KLIEN</b></td>
    <td align="center" width="30%"><b>NOMINAL</b></td>
    <td align="center" width="20%"><b>BUNGA / NISBAH</b></td>
    <?php if($r_sdata['trx_type']==4){ ?>
    <td align="center" width="10%"><b>BUNGA BREAK</b></td>
    <?php }?>
</tr>
<tr bgcolor="#ffffff">
    <td align="center">
    <b><span id="s_client_name"><?php echo $r_sdata["trx_client_name"];?></span></b><br />
    C/O Custodial Services
    </td>
    <td align="center">
    <b><?php echo $r_sdata["trx_curr"] . " " . number_format($r_sdata["trx_nominal"],2,",",".");?></b>
    </td>
    <td align="center">
    <b><?php echo $r_sdata["trx_rate"];?>%</b>
    </td>
    <?php if($r_sdata['trx_type']==4){ ?>
    <td align="center">
    <b><?php echo $r_sdata["trx_rate_break"];?>%</b>
    </td>
    <?php }?>
</tr>
</table>    
</div>
<div class="box_blank" style="margin-bottom: 15px;"> 
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
    <td width="2%">*</td>
    <td width="25%">STATUS PERPAJAKAN</td>
    <td width="2%">:</td>
    <td><?php echo $r_sdata["tax_desc"];?></td>
</tr>
<tr>
    <td>*</td>
    <td>PEMBAYARAN BUNGA</td>
    <td>:</td>
    <td><?php echo $r_sdata["payment_desc"];?>
    ke Rekening Berikut :                        
    </td>
</tr>                                      
</table>                                                   
</div>                       
<div class="box_blank" style="margin-bottom: 15px;">
<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#000000">

<!-- <tr bgcolor="#ffffff">
    <td align="center" width="30%"><b>NO. REKENING</b></td>
    <td align="center" width="30%"><b>BANK</b></td>
    <td align="center" ><b>ATAS NAMA</b></td>
</tr>


<tr bgcolor="#ffffff">
    <td align="center"><?php echo $r_sdata["trx_acc_no"];?></td>
    <td align="center"><?php echo $r_sdata["trx_bank_name"];?></td>
    <td align="center"><?php echo $r_sdata["trx_acc_name"];?></td>
</tr> -->

<tr bgcolor="#ffffff">
    <td align="center" width="30%"><b>NO. REKENING TUJUAN</b></td>
    <td align="center" width="30%"><b>BANK TUJUAN</b></td>
    <td align="center" ><b>ATAS NAMA</b></td>
</tr>

<tr bgcolor="#ffffff">
    <td align="center"><?php echo $r_sdata["bank_acc_no"];?></td>
    <td align="center"><?php echo $r_sdata["trx_to"];?></td>
    <td align="center"><?php echo $r_sdata["bank_acc_name"];?></td>
</tr>
</table>    
</div>

<div class="box_blank" style="margin-bottom: 15px;"> 
<table width="100%" border="0" cellspacing="1" cellpadding="2">
<tr>
    <td width="2%" valign="top">*</td>
    <td width="25%" valign="top">SAAT JATUH TEMPO</td>
    <td width="2%" valign="top">:</td>
    <td valign="top"><?php echo ($r_sdata['nfs_td']!=1?$r_sdata["due_desc"]:"Transfer ke Rekening Tersebut di atas<br />Perpanjang Otomatis /  ARO<br />Tunggu Instruksi<br />ARO + Bunga");?></td>
</tr>   
<tr>
    <td width="2%" valign="top">*</td>
    <td width="25%" valign="top">LAIN - LAIN</td>
    <td width="2%" valign="top">:</td>
    <td></td>
</tr>              
</table>                                                   
</div>                                     
<div class="box" style="margin-top:5px; height: 100px; padding: 10px;"><?php echo nl2br($r_sdata["trx_other"]);?></div>
<div style="text-align: right;">
<?php 
    echo $r_sdata["trx_type"] . $r_sdata["trx_deposit_type"] . $r_sdata["trx_validation_key"];
    echo "<br /><span style=\"font-size:80%;\"> <i>Approved by " . $r_sdata["trx_approved_by"] . ", on " . date_format($r_sdata["trx_approved_dt"],"d-m-Y") . "</i></span>";
?>
</div>
<br /> 
<table width="100%">
    <tr>                             
        <td width="25%" valign="top">Terima Kasih</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="3" align="center">Hormat Kami,</td>
                </tr>
                <tr><td colspan="3" align="center">&nbsp;</td></tr>
                <tr><td colspan="3" align="center">&nbsp;</td></tr>
                <tr><td colspan="3" align="center">&nbsp;</td></tr>
                <tr><td colspan="3" align="center">&nbsp;</td></tr>
                <tr><td colspan="3" align="center">&nbsp;</td></tr>
                <tr>
                    <td width="35%" align="center">(.........................)</td>
                    <td width="30%">&nbsp;</td>
                    <td width="35%" align="center">(.........................)</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--/> &nbsp;<br /> &nbsp;<br /> &nbsp;<br /> &nbsp;<br /> &nbsp;<br /> &nbsp;
<div class="small">
<?php echo $r_sdata["param_signature"];?>
</div>
-->
</div>
</body>
</html>
