<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Instruksi Transaksi Deposito</title> 
    <script type="text/javascript" src="<?php echo $url;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/change.js"></script>
    <script type="text/javascript">
    var i_pass_min = <?php echo $r_pass[0]["user_pass_min"];?>;
    var i_pass_max = <?php echo $r_pass[0]["user_pass_max"];?>;
    var i_pass_an = <?php echo $r_pass[0]["user_pass_alpha_numeric"];?>;
    var i_pass_c = <?php echo $r_pass[0]["user_pass_first_cap"];?>;
    function to_login()
    {
        window.location='<?php echo $url; ?>';
    }
    function check_n_submit()
    { 
        var err_arr=["Password doesn't match",'Min password: <?php echo $r_pass[0]["user_pass_min"];?>  chars','Max password: <?php echo $r_pass[0]["user_pass_max"];?> chars','<?php if ($r_pass[0]["user_pass_alpha_numeric"]==1) echo "Password must contain alpha numeric"; ?>','<?php if($r_pass[0]["user_pass_first_cap"]==1) echo 'First digit of password must be capitalize'; ?>'];
        if($("#up").val()!=$("#up1").val())
        {
            alert(err_arr[0]);
            return false;
        }
        var err_no =0;
        err_no = cek_pass_rule($("#up").val(),i_pass_min,i_pass_max,i_pass_an,i_pass_c);
        if(err_no>0)
        {
            alert(err_arr[err_no]);
            return false;
        }
        if(confirm('Change password?'))
            return true;
        return false;
    }
    </script>    
</head> 
<body style="margin: 0; padding: 0; background-color: white;"> 
<div id="header" style="background-color: #800000;padding:8px">
<img src="<?php echo $url . "img/cimbniaga.png";?>" border="0" />
</div> 
<div style="width: 435px; margin: 30px auto 0px auto; border: 1px solid #004080; background-color: #E0E0E0; padding: 0px; -moz-border-radius: 1em 0; ">
    <div style="padding: 5px; border-bottom: 1px solid #004080; margin: 0; background-color: #ACACAC; -moz-border-radius-topleft: 1em;">Form Change Password</div>
    <div style="padding: 5px; margin: 0;">
        <form action="<?php echo $url."index.php/itd/change_pass"; ?>" onsubmit="return check_n_submit();" method="post" id="frm_change">
        <table width="100%" border="0">
            <tr>
                <td width="150">Old Password</td>
                <td width="1">:</td>
                <td><input type="password" id="upo" name="upo" style="width: 240px;" /></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td>:</td>
                <td><input type="password" id="up" name="up"  style="width: 240px;"  /></td>
            </tr>
            <tr>
                <td>New Password Confirm</td>
                <td>:</td>
                <td><input type="password" id="up1" name="up1"  style="width: 240px;"  /></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" value="Change Password" /><input type="button" value="Back to System" onclick="to_login();" /></td>
            </tr>
        </table>
        </form>
    </div>
</div>

<?php
if(isset($r_change))
{
    if($r_change["err_no"]==0)
    {
        echo "<div style=\"margin-top: 3px; color: #005800;\" align=\"center\">
        {$r_change["err_desc"]}\n<br /> Back to previous page in 3 seconds...
</div>";
    }
    else
    { 
        echo "<div style=\"margin-top: 3px; color: #FF0000;\" align=\"center\">
        {$r_change["err_desc"]}
</div>";
    }
}
?>
</body>
</html>