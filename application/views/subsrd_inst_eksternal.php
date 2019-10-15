<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Subscription Reksadana</title>  
    <style type="text/css">
body {
 background-color: #ffffff;
 margin: 10px;
 font-family: Arial, Verdana, Sans-serif;
 font-size: 12pt;
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
<?php
if(count($r_sdata)>0)
{
?>
.
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div style="width: 760px; margin: 0 auto;padding:0; background-color: #FFFFFF; margin-left: 80px;">
<div style="border: 1px solid #808080; font-size: 120%; background-color: #F0F0F0; text-align: center; padding: 3px; font-weight: bold; margin-bottom: 15px;">
<?php echo $r_sdata[0]["ref_par1"];?>
</div>

<table width="100%" bgcolor="#969696" cellpadding="2" cellspacing="1">
    <tr bgcolor="#ffffff">
        <td width="50%" valign="top">
            <table width="100%">
                <tr>
                    <td width="80" valign="top">Kepada<br />&nbsp;</td>
                    <td width="1" valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_to"];?></td>
                </tr>
                <tr>
                    <td valign="top">Up.</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_up"];?></td>
                </tr>
                <tr>
                    <td valign="top">No. Telp</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_telp"];?></td>
                </tr>
                <tr>
                    <td valign="top">No. Fax</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_fax"];?></td>
                </tr>
            </table>
        </td>
        <td width="50%" valign="top">
            <table width="100%">
                <tr>
                    <td width="80" valign="top">No. Ref</td>
                    <td width="1" valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_no"];?></td>
                </tr>
                <tr>
                    <td valign="top">Dari</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_from1"];?></td>
                </tr>
                <tr>
                    <td valign="top">No. Telp</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_telp1"];?></td>
                </tr>
                <tr>
                    <td valign="top">No. Fax</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $r_sdata[0]["ref_fax1"];?></td>
                </tr>
                <tr>
                    <td valign="top">Tanggal</td>
                    <td valign="top">:</td>
                    <td valign="top"><b><?php echo date_format($r_sdata[0]["inst_date"],"d M Y");?></b><td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />
<br />
<br />

Mohon untuk dilakukan Transfer Dana dari rekening : 
( via : 
<?php
    echo $r_sdata[0]["txn_via"]=="RTGS"?"<b>RTGS</b>":"RTGS";
    echo $r_sdata[0]["txn_via"]=="Kliring"?", <b>Kliring</b>":", Kliring";
    echo $r_sdata[0]["txn_via"]=="Pemindahbukuan"?", <b>Pemindahbukuan</b>":", Pemindahbukuan";
?>
)
<?php echo $r_sdata[0]["remark"];?>
<table width="100%"  cellpadding="2" style="border: 1px solid #969696;">
    <tr bgcolor="#ffffff">
        <td width="130">Nama Rekening</td>
        <td width="1">:</td>
        <td><b><?php echo $r_sdata[0]["acc_src_name"];?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>No. Rekening</td>
        <td>:</td>
        <td><b><?php echo $r_sdata[0]["acc_src_no"];?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Txn Date</td>
        <td>:</td>
        <td><b><?php echo date_format($r_sdata[0]["txn_date"],"d M Y");?></b></td>
    </tr>
</table> 
<br />
<br />
<br />
Ke :
<br />
<table width="100%" cellpadding="2" style="border: 1px solid #969696;">
    <tr bgcolor="#ffffff">
        <td width="120">Nama Rekening</td>
        <td width="1">:</td>
        <td><b><?php echo $r_sdata[0]["acc_dst_name"];?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>No. Rekening</td>
        <td>:</td>
        <td><b><?php echo $r_sdata[0]["acc_dst_no"];?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Nama Bank</td>
        <td>:</td>
        <td><b><?php echo $r_sdata[0]["acc_dst_bank"];?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Jumlah</td>
        <td>:</td>
        <td>Rp. <b><?php echo number_format($r_sdata[0]["nominal"],2,'.',',');?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td valign="top">Terbilang</td>
        <td valign="top">:</td>
        <td><b><?php echo $r_sdata[0]["nominal_terbilang"];?></b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Keterangan</td>
        <td>:</td>
        <td><b>PENGAKUAN SUBS TGL <?php echo date_format($r_sdata[0]["subsrd_date"],"d M Y");?></b></td>
    </tr>
</table>
<br />
<?php if(trim($r_sdata[0]["add_info"])!='') {?>
<table width="100%" cellpadding="2" style="border: 1px solid #969696;">
    <tr bgcolor="#ffffff">
        <td align="center"><?php echo $r_sdata[0]["add_info"]; ?></td>
    </tr>
</table>
<?php }?>
<br /> <br />
Atas kerjasamanya kami ucapkan terima kasih.
<br /> <br />
Hormat kami,
<br /><br /><br /><br /><br /><br /><br /><br />
<table width="100%">
    <tr>
        <td width="50%">...........................</td>
        <td >........................... &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
    </tr>
</table>
</div>
<br />
<br />
<br />
<br />
<div style="width: 760px; margin: 0 auto; font-size: 90%;" align="right">
Approved by <?php echo  $r_sdata[0]["close_by"]?>, on <?php echo  date_format($r_sdata[0]["close_date"],"d-m-Y");?>
<br />
Printed by <?php echo  $r_sdata[0]["printed_by"]?>
</div>
<?php }?>
</div>
<div style="width: 920px; margin: 0 auto;" align="right">.</body>
</html>