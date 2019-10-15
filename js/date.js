function parseDate(str,delim,no) {
    var mdy = str.split(delim)
    if (no == 1)
        return new Date(mdy[2], mdy[1]-1, mdy[0]);
    else if(no==2)
        return new Date(mdy[2], mdy[0]-1, mdy[1]);
    else
        return new Date(mdy[0], mdy[1]-1, mdy[2]);
}

function daydiff(first, second) {
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    return math.floor((second-first)/(day));
}

//alert(daydiff(parseDate($('#first').val()), parseDate($('#second').val())));

