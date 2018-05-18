/*
 * DO NOT REMOVE THIS NOTICE
 *
 * PROJECT:   mygosuMenu
 * VERSION:   1.4.0
 * COPYRIGHT: (c) 2003,2004 Cezary Tomczak
 * LINK:      http://gosu.pl/dhtml/mygosumenu.html
 * LICENSE:   BSD (revised)
 */

/* This code has been modified a little to get it work with SimpleDoc the way I wanted */
function XulMenu(id) {

    this.type = "horizontal";
    this.position = {
        "level1": { "top": 0, "left": 0},
        "levelX": { "top": 0, "left": 0}
    }
    this.zIndex = {
        "visible": 1,
        "hidden": -1
    }
    this.arrow1 = null;
    this.arrow2 = null;

    /* Initialize the menu */
    this.init = function() {
        if (!document.getElementById(this.id)) alert("Element '"+ this.id +"' does not exist in this document. XulMenu cannot be initialized.");
        if (this.type != "horizontal" && this.type != "vertical") { return alert("XulMenu.init() failed. Unknown menu type: '"+this.type+"'"); }
        document.onmousedown = click;
        if (!document.all) {
            this.fixSections();
        }
        this.parse(document.getElementById(this.id).childNodes, this.tree, this.id);
    }

    /* Search for .section elements and set width for them */
    this.fixSections = function() {
        var arr = document.getElementById(this.id).getElementsByTagName("div");
        var sections = new Array();
        var widths = new Array();

        for (var i = 0; i < arr.length; i++) {
            if (arr[i].className == "section") {
                sections.push(arr[i]);
            }
        }
        for (var i = 0; i < sections.length; i++) {
            widths.push(this.getMaxWidth(sections[i].childNodes));
        }
        for (var i = 0; i < sections.length; i++) {
            sections[i].style.width = (widths[i]) + "px";
        }
    }

    /* Search for an element with highest width, return that width */
    this.getMaxWidth = function(nodes) {
        var maxWidth = 0;
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].nodeType != 1 || nodes[i].className == "section") { continue; }
            if (nodes[i].offsetWidth > maxWidth) maxWidth = nodes[i].offsetWidth;
        }
        return maxWidth;
    }

    /* Parse menu structure, create events, position elements */
    this.parse = function(nodes, tree, id) {
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].nodeType != 1) { continue };
            switch (nodes[i].className) {
                case "button":
                    nodes[i].id = id + "-" + tree.length;
                    tree.push(new Array());
                    nodes[i].onmouseover = buttonOver;
                    nodes[i].onclick = buttonClick;
                    break;
                case "item":
                    nodes[i].id = id + "-" + tree.length;
                    tree.push(new Array());
                    nodes[i].onmouseover = itemOver;
                    nodes[i].onmouseout = itemOut;
                    nodes[i].onclick = itemClick;
                    break;
                case "section":
                    nodes[i].id = id + "-" + (tree.length - 1) + "-section";
                    var box1 = document.getElementById(id + "-" + (tree.length - 1));
                    var box2 = document.getElementById(nodes[i].id);
                    var el = new Element(box1.id);
                    if (el.level == 1) {
                        if (this.type == "horizontal") {
                            box2.style.top = (box1.offsetTop + this.position.level1.top) + "px";
                            box2.style.left = (box1.offsetLeft + this.position.level1.left) + "px";
                        } else if (this.type == "vertical") {
                            box2.style.top = (box1.offsetTop + this.position.level1.top) + "px";
                            box2.style.left = (box1.offsetLeft + box1.offsetWidth + this.position.level1.left) + "px";
                        }
                    } else {
                        box2.style.top = (box1.offsetTop + this.position.levelX.top) + "px";
                        box2.style.left = (box1.offsetLeft + box1.offsetWidth + this.position.levelX.left) + "px";
                    }
                    break;
                case "arrow":
                    nodes[i].id = id + "-" + (tree.length - 1) + "-arrow";
                    break;
            }
            if (nodes[i].childNodes) {
                if (nodes[i].className == "section") {
                    this.parse(nodes[i].childNodes, tree[tree.length - 1], id + "-" + (tree.length - 1));
                } else {
                    this.parse(nodes[i].childNodes, tree, id);
                }
            }
        }
    }

    /* Hide all sections */
    this.hideAll = function() {
        for (var i = this.visible.length - 1; i >= 0; i--) {
            this.hide(this.visible[i]);
        }
    }

    /* Hide higher or equal levels */
    this.hideHigherOrEqualLevels = function(n) {
        for (var i = this.visible.length - 1; i >= 0; i--) {
            var el = new Element(this.visible[i]);
            if (el.level >= n) {
                this.hide(el.id);
            } else {
                return;
            }
        }
    }

    /* Hide a section */
    this.hide = function(id) {
        var el = new Element(id);
        document.getElementById(id).className = (el.level == 1 ? "button" : "item");
        if (el.level > 1 && this.arrow2) {
            document.getElementById(id + "-arrow").src = this.arrow1;
        }
        document.getElementById(id + "-section").style.visibility = "hidden";
        document.getElementById(id + "-section").style.zIndex = this.zIndex.hidden;
        if (this.visible.contains(id)) {
            if (this.visible.getLast() == id) {
                this.visible.pop();
            } else {
                throw "XulMenu.hide("+id+") failed, trying to hide element that is not deepest visible element";
            }
        } else {
            throw "XulMenu.hide("+id+") failed, cannot hide element that is not visible";
        }
    }

    /* Show a section */
    this.show = function(id) {
        var el = new Element(id);
        document.getElementById(id).className = (el.level == 1 ? "button-active" : "item-active");
        if (el.level > 1 && this.arrow2) {
            document.getElementById(id + "-arrow").src = this.arrow2;
        }
        document.getElementById(id + "-section").style.visibility = "visible";
        document.getElementById(id + "-section").style.zIndex = this.zIndex.visible;
        this.visible.push(id);
    }

    /* event, document.onmousedown */
    function click(e) {
        var el = null;
        if (e) {
            el = e.target.tagName ? e.target : e.target.parentNode;
        } else {
            el = window.event.srcElement;
        }
        if (!self.visible.length) { return };
        if (!el.onclick) { self.hideAll(); }
    }

    /* event, button.onmouseover */
    function buttonOver() {
        if (!self.visible.length) { return; }
        if (self.visible.contains(this.id)) { return };
        self.hideAll();
        var el = new Element(this.id);
        if (el.hasChilds()) {
            self.show(this.id);
        }
    }

    /* event, button.onclick */
    function buttonClick() {
        this.blur();
        if (self.visible.length) {
            self.hideAll();
        } else {
            var el = new Element(this.id);
            if (el.hasChilds()) {
                self.show(this.id);
            }
        }
    }

    /* event, item.onmouseover */
    function itemOver() {
        var el = new Element(this.id);
        self.hideHigherOrEqualLevels(el.level);
        if (el.hasChilds()) {
            self.show(this.id);
        }
    }

    /* event, item.onmouseout */
    function itemOut() {
        var el = new Element(this.id);
        if (!el.hasChilds()) {
            document.getElementById(this.id).className = "item";
        }
    }

    /* event, item.onclick */
    function itemClick() {
        this.blur();
        var el = new Element(this.id);
        self.hideHigherOrEqualLevels(el.level);
        if (el.hasChilds()) {
            self.show(this.id);
        }
    }

    function Element(id) {

        /* Get Level of given id
         * Examples: menu-1 (1 level), menu-1-4 (2 level) */
        this.getLevel = function() {
            var s = this.id.substr(this.menu.id.length);
            return s.substrCount("-");
        }

        /* Check whether an element has a sub-section */
        this.hasChilds = function() {
            return Boolean(document.getElementById(this.id + "-section"));
        }

        if (!id) { throw "XulMenu.Element(id) failed, id cannot be empty"; }
        this.menu = self;
        this.id = id;
        this.level = this.getLevel();
    }

    this.id = id;
    var self = this;

    this.tree = new Array(); /* Multidimensional array, structure of the menu */
    this.visible = new Array(); /* Example: Array("menu-0", "menu-0-4", ...), succession is important ! */
}