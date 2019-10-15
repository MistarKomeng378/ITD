<?php if($lvl<=5) { ?>

<div style="width: 300px; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">
User Parameter
</div>
<div style="width: 300px;  padding: 3px; border:1px solid #000058;" align="left">
    <table border="0">
        <tr>
            <td width="200">Password Expired Days</td>
            <td width="1">:</td>
            <td><input type="text" style="width: 40px; text-align: right;" value="30" id="upar_ex_pass" /></td>
        </tr>
        <tr>
            <td>User Expire Days not Login</td>
            <td>:</td>
            <td><input type="text" style="width: 40px; text-align: right;" value="30" id="upar_ex_log" /></td>
        </tr>
        <tr>
            <td>Max Chars</td>
            <td>:</td>
            <td><input type="text" style="width: 40px; text-align: right;" value="15" id="upar_max" /></td>
        </tr>
        <tr>
            <td>Min Chars</td>
            <td>:</td>
            <td><input type="text" style="width: 40px; text-align: right;" value="8" id="upar_min" /></td>
        </tr>
        <tr>
            <td>Contains Aplhanumeric</td>
            <td>:</td>
            <td><select id="upar_alpha_num"><option value="1">Yes</option><option value="0">No</option></select></td>
        </tr>
        <tr>
            <td>First Char is Capital</td>
            <td>:</td>
            <td><select id="upar_cap"><option value="1">Yes</option><option value="0">No</option></select></td>
        </tr>
        <tr>
            <td>Wrong Password Max Count</td>
            <td>:</td>
            <td><input type="text" style="width: 40px; text-align: right;" value="3" id="upar_wrong" /></td>
        </tr>
        <tr>
            <td>Cycle Count</td>
            <td>:</td>
            <td><input type="text" style="width: 40px; text-align: right;" value="12" id="upar_cycle" /></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type="button" value="Update" id="upar_upd" /></td>
        </tr>
    </table>
</div>

<?php } ?>