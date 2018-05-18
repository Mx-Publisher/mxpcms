// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | XulTabs.js                                                         |
// | Automatic tabs creation.                                           |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

function XulTabs(id) {
    this.init = function() {
        this.parse(document.getElementById(this.id).childNodes);
        if (this.tabs != this.data) { alert("XulTabs.init() failed, tabs="+this.tabs+", data="+this.data); }
    };
    this.parse = function(nodes) {
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].nodeType != 1) { continue; }
            if (/tab/.test(nodes[i].className)) {
                nodes[i].id = this.id+"-"+this.tabs;
                nodes[i].onclick = click;
                this.tabs++;
            }
            if (/data/.test(nodes[i].className)) {
                nodes[i].id = this.id+"-"+this.data+"-data";
                this.data++;
            }
            if (nodes[i].childNodes) {
                this.parse(nodes[i].childNodes);
            }
        }
    };
    this.show = function(id) {
        this.hide();
        document.getElementById(id).className = document.getElementById(id).className.replace(/tab/, "tab-active");
        document.getElementById(id+"-data").style.display = "block";
        this.active = id;
    };
    this.hide = function() {
        if (this.active) {
            document.getElementById(this.active).className = document.getElementById(this.active).className.replace(/tab-active/, "tab");
            document.getElementById(this.active+"-data").style.display = "none";
            this.active = "";
        }
    };
    function click() {
        self.show(this.id);
        this.blur();
    }
    var self = this;
    this.id = id;
    this.active = "";
    this.tabs = 0;
    this.data = 0;
}