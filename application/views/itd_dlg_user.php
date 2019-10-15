
<?php if(0+$lvl<=0) { ?>
    <?php if($no==0) { ?>
    <input type="hidden" name="dlgU_uid" id="dlgU_uid" />
    <table>
        <tr>
            <td width="25%">User Login</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgU_login"  name="dlgU_login" style="width:100px;" /></td>
        </tr>
        <tr>
            <td>Nama User</td>
            <td>:</td>
            <td><input type="text" id="dlgU_name"  name="dlgU_name" style="width:200px;" /></td>
        </tr>
        <tr class="pwd">
            <td width="25%">Password</td>
            <td width="1%">:</td>
            <td><input type="password" id="dlgU_pass"  name="dlgU_pass" style="width:150px;" /></td>
        </tr>
        <tr  class="pwd">
            <td width="25%">Password*</td>
            <td width="1%">:</td>
            <td><input type="password" id="dlgU_pass1"  name="dlgU_pass1" style="width:150px;" /></td>
        </tr>
        <tr>
            <td>Level</td>
            <td>:</td>
            <td>
            <select name="dlgU_lvl" id="dlgU_lvl">
                <option value="10">User</option>
                <option value="5">Checker</option>
                <option value="0">Administrator</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Groups</td>
            <td>:</td>
            <td>
            <select name="dlgU_group" id="dlgU_group">
                <option value="1">CS</option>
                <option value="2">SAFEKEEPING</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Aktif</td>
            <td>:</td>
            <td>
            <select name="dlgU_aktif" id="dlgU_aktif">
                <option value="1">Enable</option>
                <option value="0">Disable</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Locked</td>
            <td>:</td>
            <td>
            <select name="dlgU_lock" id="dlgU_lock">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            </td>
        </tr>
    </table>
    <?php } ?>
    <?php if($no==1) { ?>
    <table>
        <input type="hidden" name="dlgU_uid_1" id="dlgU_uid_1" />
        <tr>
            <td width="32%">User ID</td>
            <td width="1%">:</td>
            <td><span id="user_name1"></span></td>
        </tr>
        <tr>
            <td width="32%">Password Baru</td>
            <td width="1%">:</td>
            <td><input type="password" id="dlgU_pass_1"  name="dlgU_pass_1" style="width:150px;" /></td>
        </tr>
        <tr>
            <td>Password Baru*</td>
            <td>:</td>
            <td><input type="password" id="dlgU_pass1_1"  name="dlgU_pass1_1" style="width:150px;" /></td>
        </tr>
    </table>
    <?php } ?>
<?php } ?> 
    <?php if($no==2) { ?>
    <table>
        <input type="hidden" name="dlgU_uid_2" id="dlgU_uid_2" />
        <tr>
            <td width="32%">Password Lama</td>
            <td width="1%">:</td>
            <td><input type="password" id="dlgU_pass_old"  name="dlgU_pass_old" style="width:150px;" /></td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td width="32%">Password Baru</td>
            <td width="1%">:</td>
            <td><input type="password" id="dlgU_pass_2"  name="dlgU_pass_2" style="width:150px;" /></td>
        </tr>
        <tr>
            <td>Password Baru*</td>
            <td>:</td>
            <td><input type="password" id="dlgU_pass1_2"  name="dlgU_pass1_2" style="width:150px;" /></td>
        </tr>
    </table>
    <?php } ?>

