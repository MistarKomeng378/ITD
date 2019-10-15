<html>
<head>
<title>Tiket instruksi</title>
<style type="text/css">    
body {
 background-color: #ffffff;
 font-family: Arial, Verdana, Sans-serif;
 font-size: 10pt;
 color: #000000;
 margin:0;
 padding:0;                                             
} 
table, tr , td {
    font-family: Arial, Verdana, Sans-serif;
 font-size: 10pt;
}
</style>
</head>
<body>                                   
<div style="margin-bottom: 4px;">
<img src="<?php echo $url;?>img/iso.jpg" style="margin: 0; float: right;" />
<img src="<?php echo $url;?>img/cimb.png" style="margin: 0;" />
</div>
<div align="center" style="font-size: 1.5em; font-weight: bold;margin-bottom: 4px;">MONEY MARKET</div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#000000">
<tr bgcolor="#ffffff" valign="top" align="center">
    <td width="20%" colspan="4"><b>Client Code</b><br /><?php echo $c_code;?></td>
    <td width="30%" colspan="6"><b>Client Name</b><br /><?php echo $c_name;?></td>
    <td width="40%" colspan="8"><b>Type of Transaction</b><br />
    <table width="100%" border="0">
        <tr>
            <td width="1%">[<?php echo $c_type==1?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td width="49%">Placement</td>
            <td width="1%">[<?php echo $c_type==2?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td>Renegotiation</td>
        </tr>
        <tr>
            <td>[<?php echo $c_type==3?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td>Redemption</td>
            <td>[<?php echo $c_type==4?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td>Interest</td>
        </tr>
        <tr>
            <td>[<?php echo $c_type==5?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td colspan="3"></td>
        </tr>
    </table>
    </td>
    <td width="10%" colspan="2"><b>Bank Placed</b><br /><?php echo $c_bank;?></td>
</tr>
<tr bgcolor="#ffffff" align="center">
    <td width="20%" colspan="4"><b>Settlement Date</b><br /><?php echo $c_setdate;?></td>
    <td width="10%" colspan="2"><b>Term</b><br /><?php echo $c_term;?> hari</td>
    <td width="20%" colspan="4"><b>Interest Rate</b><br /><?php echo number_format($c_rate,2,'.',',');?>  %
    </td>
    <td width="30%" colspan="6"><b>Amount</b><br /><?php echo number_format($c_amount,2,'.',',');?></td>
    <td width="20%" colspan="4"><b>Instruction Reference</b><br /><?php echo $c_ref;?></td>
</tr>                         
<tr bgcolor="#ffffff" align="center">
    <td width="20%" colspan="4" valign="top"><b>Interest Before Tax</b><br /><?php echo number_format($c_intamount,2,'.',',');?></td>
    <td width="20%" colspan="4" valign="top"><b>Tax</b><br /><?php echo number_format($c_tax,2,'.',',');?> %</td>
    <td width="20%" colspan="4" align="left">
    <table width="100%" border="0">
        <tr>
            <td width="1%">[<?php echo $c_type==1?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td>Stamp Duty</td>
        </tr>
        <tr>
            <td>[<?php echo $c_type==2?'&nbsp;X&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;';?>]</td>
            <td><?php echo $c_stamp;?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $c_stampamount;?></td>
        </tr>
    </table>
    <td width="40%" colspan="8"><b>Net Settlement Received</b><br /><?php echo number_format($c_net,2,'.',',');?></td>
    <!--
    <td width="10%" colspan="2">ID<br /><?php /*echo $c_id;*/?></td>
    -->
</tr>                         
<tr bgcolor="#ffffff">
    <td width="5%" colspan="20">
        <table width="100%" cellpadding="0" cellspacing="0">
            <td width="5%" valign="top"><b>Notes:</b></td>
            <td valign="top"><?php echo $c_note;?></td>
        </table>
    </td>
</tr>
<tr bgcolor="#ffffff" align="center">
    <td width="25%" colspan="5">Prepared by :<br /><br /><br /><br />Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </td>
    <td width="25%" colspan="5">Checked by :<br /><br /><br /><br />Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </td>
    <td width="25%" colspan="5">Approved by :<br /><br /><br /><br />Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </td>
    <td width="25%" colspan="5">Settled by :<br /><br /><br /><br />Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  </td>
</tr>
</table>                                   
</body>
</html>