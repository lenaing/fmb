function fmb_code(debut, fin, form) {
    var input = document.getElementById(form);
    input.focus();

    if(typeof document.selection != 'undefined')
    {
        var range = document.selection.createRange();
        var insText = range.text;
        range.text = debut + insText + fin;
        range = document.selection.createRange();
        if (insText.length == 0)
            range.move('character', -fin.length);
        else
            range.moveStart('character', debut.length + insText.length + fin.length);
        range.select();
    }
    else if (typeof input.selectionStart != 'undefined')
    {
        var start = input.selectionStart;
        var end = input.selectionEnd;
        var insText = input.value.substring(start, end);
        input.value = input.value.substr(0, start) + debut + insText + fin + input.value.substr(end);
        var pos;
        pos = (insText.length == 0) ? (start + debut.length) : (start + debut.length + insText.length + fin.length);
        input.selectionStart = pos;
        input.selectionEnd = pos;
    }
    else
    {
        var pos;
        var re = new RegExp('^[0-9]{0,3}$');
        while(!re.test(pos))
            pos = prompt("insertion (0.." + input.value.length + "):", "0");
        if (pos > input.value.length)
            pos = input.value.length;
        var insText = prompt("Veuillez taper le texte");
        input.value = input.value.substr(0, pos) + debut + insText + fin + input.value.substr(pos);
    }
}

