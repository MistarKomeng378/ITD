<html>
<head>
<title></title>
<style type="text/css">    
body {
 background-color: #ffffff;
 font-family: Arial, Verdana, Sans-serif;
 font-size: 11pt;
 color: #000000;
 margin:0;
 padding:0;                                             
} 
table, tr , td {
    font-family: Arial, Verdana, Sans-serif;
 font-size: 11pt;
}
</style>
</head>
<body>
<div style="position: absolute; left: 900px; top: 0px;">.</div>
<div style="position: absolute; left: 0px; top: 0px;"><?php echo  $r_sdata[0]["tc5_no"]?></div>
<div style="position: absolute; left: 160px; top: 0px;  border: 2px ridge #000000; font-size: 30pt; vertical-align: middle; padding: 2px 2px;" align="center"><b>RTGS</b></div>
<div style="position: absolute; left: 745px; top: 22px;" ><?php echo  $r_sdata[0]["trx_valuta_date_s"]?></div>
<div style="position: absolute; left: 725px; top: 59px;" ><b>XX</b></div>
<div style="position: absolute; left: 0px; top: 130px; width: 350px;" ><?php echo  $r_sdata[0]["beneficiary_name"]?></div>
<div style="position: absolute; left: 520px; top: 152px;" >
    <span style="font-size: 14pt; font-weight: bold;"><?php echo  $r_sdata[0]["src_acc_no"]?></span>
</div>
<div style="position: absolute; left: 0px; top: 205px;" >
    A/C NO : <span style="font-size: 14pt; font-weight: bold;"><?php echo  $r_sdata[0]["beneficiary_acc_no"]?></span>
</div>
<div style="position: absolute; left: 660px; top: 195px;" >Rp.</div>
<div style="position: absolute; left: 700px; top: 195px;" ><?php echo  number_format($r_sdata[0]["amount"],2,'.',',');?></div>
<div style="position: absolute; left: 415px; top: 225px;  width: 460px; font-size: 9pt;" ><?php echo  $r_sdata[0]["amount_said"]?></div>
<div style="position: absolute; left: 0px; top:245px; width: 350px;" ><?php echo  $r_sdata[0]["beneficiary_bank"]?></div>
<div style="position: absolute; left: 145px; top: 300px;" ><?php echo  number_format($r_sdata[0]["charges"],2,',','.');?></div>
<div style="position: absolute; left: 500px; top: 302px; width: 370px;" ><?php echo  $r_sdata[0]["msg"];?></div>
<div style="position: absolute; left: 500px; top: 410px; width: 370px;" ><?php echo  nl2br($r_sdata[0]["sender_name"]);?></div>
<div style="position: absolute; left: 500px; top: 500px; width: 370px; font-size: 8pt; "  align="right">
<?php echo  $r_sdata[0]["printed_by"]?>
</div>
<div style="position: absolute; left: 0px; top: 540px;" >.</div>
</body>
</html>