<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Subscription Reksadana</title>  
    <style type="text/css">
body {
 background-color: #ffffff;
 font-family: Arial, Verdana, Sans-serif;
 font-size: 10pt;
 color: #000000;
 margin:0px;
 padding:0px;      brder: 1px solid #000;                                       
}
</style>
</head>
<body>
<?php
if(count($r_sdata)>0)
{
?>
<div style="width: 800px; margin: 0;padding:0; background-color: #FFFFFF;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">.</td>
        <td align="right">.</td>
    </tr>
</table>
</div>

<div style="position: absolute; left: 305px; top:16px;width: 460px;"><?php echo date_format($r_sdata[0]["txn_date"],"d M Y");?></div>
<div style="position: absolute; left: 305px; top:36px;width: 460px;"><?php echo $r_sdata[0]["ref_to"];?></div>
<div style="position: absolute; left: 282px; top:65px;width: 200px;"><?php echo $r_sdata[0]["acc_src_no"];?></div>
<div style="position: absolute; left: 558px; top:65px;width: 180px;font-size: 8pt;"><?php echo $r_sdata[0]["acc_src_name"];?></div>
<div style="position: absolute; left: 150px; top:96px;width: 190px;"><?php echo number_format($r_sdata[0]["nominal"],2,'.',',');?></div>
<div style="position: absolute; left: 334px; top:96px;width: 430px;font-size: 8pt;"><?php echo $r_sdata[0]["nominal_terbilang"];?></div>
<div style="position: absolute; left: 58px; top:234px;width: 180px;"><?php echo $r_sdata[0]["acc_dst_bank"];?></div>
<div style="position: absolute; left: 236px; top:234px;width: 180px;"><?php echo $r_sdata[0]["acc_dst_no"];?></div>
<div style="position: absolute; left: 380px; top:234px;width: 260px;"><?php echo $r_sdata[0]["acc_dst_name"];?></div>
<div style="position: absolute; left: 632px; top:234px;width: 145px;">Rp. <?php echo number_format($r_sdata[0]["nominal"],2,'.',',');?></div>
<div style="position: absolute; left: 632px; top:859px;width: 145px;">Rp. <?php echo number_format($r_sdata[0]["nominal"],2,'.',',');?></div>

<div style="position: absolute; left: 18px; top:1006px;width: 400px;">Berita: Pengakuan Subscription tanggal <?php echo date_format($r_sdata[0]["subsrd_date"],"d M Y");?></div>
<div style="position: absolute; left: 456px; top:1006px;">Jakarta</div>
<div style="position: absolute; left: 624px; top:1006px;"><?php echo date_format($r_sdata[0]["inst_date"],"d M");?></div>
<div style="position: absolute; left: 732px; top:1006px;"><?php echo date_format($r_sdata[0]["inst_date"],"y");?></div>
<div style="position: absolute; left: 18px; top:1020px;width: 400px;">*  
<?php 
    if( trim($r_sdata[0]["add_info"])!='')
        echo $r_sdata[0]["add_info"]; 
    else
        echo "Biaya transfer debet nominal";
?>
</div>

<?php }?>   
</html>