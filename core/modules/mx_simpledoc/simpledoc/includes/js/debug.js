var debugWindow = null;

function debug(s, name) {
    if (!debugWindow) {
        debugWindow = window.open("", "debugWindow", "width=400,height=500,scrollbars=yes,resizable=yes");
        debugWindow.document.write("<pre>");
    }
    if (name) {
        debugWindow.document.write('<div style="font: 12px sans-serif; font-weight: bold;">'+name+'</div>');
    }
    debugWindow.document.write(s + "\n");
}

function debugObject(obj, name) {
    var s = '';
    for (var i in obj) {
        if (obj[i] && (typeof obj[i] == "object" || typeof obj[i] == "function") && obj[i].toString) {
            s += "Object." + i + "=" + obj[i].toString().replace(/\n/g, "") + "\n";
        } else {
            s += "Object." + i + "=" + obj[i] + "\n";
        }
    }
    debug(s, name);
}

function debugArray(arr, name) {
    var s = '';
    for (var i = 0; i < arr.length; ++i) {
        s += "Array[" + i + "]=" + arr[i] + "\n";
    }
    debug(s, name);
}