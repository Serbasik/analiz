// var color1 = 'FF0000';
// var color2 = '00FF00';
// var ratio = 0.5;
function hex(x) {
    x = x.toString(16);
    return (x.length == 1) ? '0' + x : x;
};


function gradColor(color1, color2, ratio) {
    var r = Math.ceil(parseInt(color1.substring(0, 2), 16) * ratio + parseInt(color2.substring(0, 2), 16) * (1 - ratio));
    var g = Math.ceil(parseInt(color1.substring(2, 4), 16) * ratio + parseInt(color2.substring(2, 4), 16) * (1 - ratio));
    var b = Math.ceil(parseInt(color1.substring(4, 6), 16) * ratio + parseInt(color2.substring(4, 6), 16) * (1 - ratio));

    return hex(r) + hex(g) + hex(b);
}