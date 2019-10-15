<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Instruksi Transaksi Deposito</title> 
</head> 
<body style="margin: 0; padding: 0; background-color: white;" onload="document.getElementById('ud').focus();"> 
<div id="header" style="background-color: #800000;padding:8px">
<img src="<?php echo $url . "img/cimbniaga.png";?>" border="0" />
</div> 

<div style="width: 270px; margin: 30px auto 0px auto; border: 1px solid #004080; background-color: #E0E0E0; padding: 0px; -moz-border-radius: 1em 0; ">
    <div style="padding: 5px; border-bottom: 1px solid #004080; margin: 0; background-color: #ACACAC; -moz-border-radius-topleft: 1em;">Form Login Applikasi</div>
    <div style="padding: 5px; margin: 0;">
        <form action="<?php echo $url;?>index.php/itd/do_login" method="post" id="frm_user" >
        <table width="100%" border="0">
            <tr>
                <td width="100">User ID</td>
                <td width="1">:</td>
                <td><input type="text" id="ud" name="ud" /></td>
            </tr>
            <tr>
                <td>User Password</td>
                <td>:</td>
                <td><input type="password" id="up" name="up" /></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" value="Login" /></td>
            </tr>
        </table>
        </form>
    </div>
</div>
<div align="center" style="color: #f00;">
<?php
if ($err_login==1 && $uid!='')
    echo "User doesn't exists.";
if ($err_login==2)
    echo "Wrong password {$err_pass_count} times, max {$err_period} times.";
if ($err_login==3)
    echo "User disabled.";
if ($err_login==4)
    echo "User locked.";
if ($err_login==5)
    echo "User locked due to no login equal or more than {$err_period} days.";
if ($err_login==6)
    echo "User Locked due to wrong password for {$err_period} times.";
?>
</div>
</body>
</html>