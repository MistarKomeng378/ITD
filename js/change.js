function cek_pass_rule(p_pass,p_min,p_max,p_alpha_num,p_first_cap)
{
    if (p_pass.length<p_min)
        return 1;
    if (p_pass.length>p_max)
        return 2;
    var reg_alpha = /[a-zA-Z]/;
    var reg_numeric = /[0-9]/;
    var reg_first_cap= /^[A-Z]/;
    if(p_alpha_num==1 && !(reg_alpha.test(p_pass) && reg_numeric.test(p_pass)))
        return 3;
    if(p_first_cap==1 && !reg_first_cap.test(p_pass))
        return 4;
    return 0;
}