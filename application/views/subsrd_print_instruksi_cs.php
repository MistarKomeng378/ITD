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
<?php 
if(count($r_sdata)>0) { 
    $rpt_count=0;
    foreach($r_sbank as $rec_bank) {
        if(count($r_sbank_data[($rec_bank["bank_code_src"].'_'.$rec_bank["acc_no_src"])])>0){
?>
<div style="width: 800px; margin: 0 auto;padding:0; background-color: #FFFFFF;page-break-after : always; ">
<img src="<?php echo $url;?>img/cimb.png" style="margin: 0;" />         <br />

<div class="box" align="center" style="margin-top:5px;margin-bottom:10px;"><span class="big1"><?php echo $r_sparam[0]["ref_par1"];?></span></div>
<div align="center" style="margin-top:5px;margin-bottom:10px;">
    <span class="big1"><?php echo $r_status[0]["client_name"];?></span><br />
    <span class="big1"><?php echo $rec_bank["bank_name_src"];?></span><br />
</div>
<div>
<table>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo date('d M Y');?></td>
    </tr>
    <tr>
        <td>Kepada Yth</td>
        <td>:</td>
        <td><?php echo $r_sparam[0]["ref_par2"];?></td>
    </tr>
</table>

<br /> Mohon untuk dilakukan pemindahbukuan pada tanggal <b><?php echo count($r_sdata)>0?date_format($r_sdata[0]["get_date"],'d M Y'):'';?></b>
untuk transaksi di bawah ini :
<br /> <br />
<table width="100%" bgcolor="#000000">
    <tr bgcolor="#E0E0E0">
        <td width="30" align="center"><b>No.</b></td>
        <td width="280" align="center"><b>Rekening Sumber Dana</b></td>
        <td width="280" align="center"><b>Rekening Tujuan Dana</b></td>
        <td align="center"><b>Nominal (IDR)</b></td>
    </tr>
<?php $irow=1;$total_p=0;foreach($r_sbank_data[($rec_bank["bank_code_src"].'_'.$rec_bank["acc_no_src"])] as $item1) { $total_p+=$item1["balance"];?>
    <tr bgcolor="#ffffff">
        <td align="center"><?php echo $irow++;?></td>
        <td><?php echo "{$item1["src_bank"]} <br />{$item1["src_no"]} <br /><b>{$item1["src_name"]}</b>";?></td>
        <td><?php echo "{$item1["dst_bank"]} <br />{$item1["dst_no"]} <br /><b>{$item1["dst_name"]}</b>";?></td>
        <td align="right"><?php echo number_format($item1["balance"],2,',','.');?>&nbsp; </td>
    </tr>
<?php }?>
    <tr bgcolor="#ffffff">
        <td align="right" colspan="3"><b>Total Penyertaan : </b></td>
        <td align="right"><b><?php echo number_format($total_p,2,',','.');?>&nbsp; </b></td>
    </tr>
</table>
<br />
<div class="box" align="center" style="margin-top:5px;margin-bottom:10px;">Pengakuan Subscription tanggal <b><?php echo date_format($r_sdata[0]["subsrd_date"],'d M Y');?></b></div>
<br />Note : Urgent...mohon diproses sebelum jam 10:00 WIB
<br /> <br /> <br />
<div align="right">
<table width="250" bgcolor="#000000">
    <tr bgcolor="#E0E0E0">
        <td width="50%" align="center"><b>Maker</b></td>
        <td align="center"><b>Approval</b></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td><br/><br/> &nbsp;</td>
        <td><br/><br/> &nbsp;</td>
    </tr>
</table>
</div>
</div>
</div>
<?php
        }
    }
}?>
</body>
</html>
