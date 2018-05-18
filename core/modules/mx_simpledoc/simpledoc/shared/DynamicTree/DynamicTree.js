// +--------------------------------------------------------------------+
// | DO NOT REMOVE THIS                                                 |
// +--------------------------------------------------------------------+
// | DynamicTree.js                                                     |
// | Dynamic tree editing and displaying.                               |
// +--------------------------------------------------------------------+
// | Author:  Cezary Tomczak [www.gosu.pl]                              |
// | Project: SimpleDoc                                                 |
// | URL:     http://gosu.pl/php/simpledoc.html                         |
// | License: GPL                                                       |
// +--------------------------------------------------------------------+

/* See also: http://gosu.pl/dhtml/mygosumenu.html */
/* The code has been modified for SimpleDoc specific needs */

/* Object name must be the same as id, ex. var tree = new DynamicTree("tree"); */
function DynamicTree(id) {
    this.path = "DynamicTree/images/";
    this.cookiePath = "";
    this.cookieDomain = "";
    this.img = {
        "branch": "tree-branch.gif",
        "doc": "tree-doc.gif",
        "folder": "tree-folder.gif",
        "folderOpen": "tree-folder-open.gif",
        "leaf": "tree-leaf.gif",
        "leafEnd": "tree-leaf-end.gif",
        "node": "tree-node.gif",
        "nodeEnd": "tree-node-end.gif",
        "nodeOpen": "tree-node-open.gif",
        "nodeOpenEnd": "tree-node-open-end.gif" };
    this.imgObjects = [];
    this.init = function() {
        var img;
        for (var i in this.img) {
            img = new Image();
            img.src = this.path + this.img[i];
            this.imgObjects.push(img);
        }
        this.parse(document.getElementById(this.id).childNodes, this.tree, 1);
        this.loadState();
        if (window.addEventListener) { window.addEventListener("unload", function(e) { self.saveState(); }, false); }
        else if (window.attachEvent) { window.attachEvent("onunload", function(e) { self.saveState(); }); }
        this.updateHtml();
    };
    this.parse = function(nodes, tree) {
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].nodeType == 1) {
                if (!nodes[i].id) { throw "DynamicTree.parse() failed, el.id is empty, el.innerText = '"+(nodes[i].firstChild ? nodes[i].firstChild.nodeValue : "undefined")+"'"; }
                if (!nodes[i].className) { throw "DynamicTree.parse() failed, el.className is empty, el.innerText = '"+(nodes[i].firstChild ? nodes[i].firstChild.nodeValue : "undefined")+"'"; }
                var node = new Node();
                node.id         = nodes[i].id;
                node.text       = (nodes[i].firstChild ? nodes[i].firstChild.nodeValue.trim() : "");
                node.parentNode = tree;
                node.childNodes = (nodes[i].className == "folder" ? new Array() : null);
                node.isDoc      = (nodes[i].className == "doc");
                node.isFolder   = (nodes[i].className == "folder");
                tree.childNodes.push(node);
                this.allNodes.push(node);
            }
            if (nodes[i].nodeType == 1 && nodes[i].childNodes) {
                this.parse(nodes[i].childNodes, tree.childNodes.getLast());
            }
        }
    };
    this.nodeClick = function(id) {
        var el = document.getElementById(id+"-section");
        var node = document.getElementById(id+"-node");
        //var icon = document.getElementById(id+"-icon");
        if (el.style.display == "block") {
            el.style.display = "none";
            if (findNode(id).isLast()) { node.src = this.path+"tree-node-end.gif"; }
            else { node.src = this.path+"tree-node.gif"; }
            //icon.src = this.path+"tree-folder.gif";
            this.opened.removeByValue(id);
        } else {
            el.style.display = "block";
            if (findNode(id).isLast()) { node.src = this.path+"tree-node-open-end.gif"; }
            else { node.src = this.path+"tree-node-open.gif"; }
            //icon.src = this.path+"tree-folder-open.gif";
            this.opened.push(id);
        }
        if (document.all) setTimeout(this.id+".fixImages('"+id+"')", 50);
    };
    // ie fix, icon & node images disappearing
    this.fixImages = function(id) {
        var node = document.getElementById(id+"-node");
        //var icon = document.getElementById(id+"-icon");
        if (node.outerHTML) node.outerHTML = node.outerHTML;
        //if (icon.outerHTML) icon.outerHTML = icon.outerHTML;
    };
    this.textClick = function(id) {
        // bad design !
        checkContentSaved();
        if (this.active) {
            document.getElementById(this.active+"-text").className = "text";
        }
        document.getElementById(id+"-text").className = "text-active";
        this.active = id;
        this.textClickListener.call();
    };
    this.toHtml = function() {
        var s = "";
        var nodes = this.tree.childNodes;
        for (var i = 0; i < nodes.length; i++) {
            s += nodes[i].toHtml();
        }
        return s;
    };
    this.updateHtml = function() {
        document.getElementById(this.id).innerHTML = this.toHtml();
    };
    this.loadState = function() {
        var opened = this.getStatesUrl();
        if (opened) {
            this.opened = opened.split("|");
            var i, invalid = [];
            for (i = 0; i < this.opened.length; i++) {
                if (findNode(this.opened[i])) {
                    var node = findNode(this.opened[i]);
                    if (!node.isFolder || (node.isFolder && !node.childNodes.length)) {
                        invalid.push(node.id);
                    }
                } else {
                    invalid.push(this.opened[i]);
                }
            }
            for (i = 0; i < invalid.length; i++) {
                this.opened.removeByValue(invalid[i]);
            }
        }
    };

    //
    // Simulate the loadState cookie behaviour
    //
    this.getStatesUrl = function() {
        if (this.queryPath) {
        	var openedTMP = '';
        	for (i = 0; i < this.queryPath.split("/").length - 1; i++) {
 				if(i > 0) {
					openedTMP = openedTMP + "|" + 'tree-' + this.queryPath.split("/")[i-1] + '/' + this.queryPath.split("/")[i];
				}else{
					openedTMP = 'tree-' + this.queryPath.split("/")[i];
				}
        	}
        	return openedTMP;
        }
    };

    this.saveState = function() {
        if (this.opened.length) {
            this.cookie.set("opened", this.opened.join("|"), 3600*24*30);
        } else {
            this.clearState();
        }
    };
    this.clearState = function() {
        this.cookie.del("opened");
    };
    this.mayMoveUp = function() {
        return this.active && !findNode(this.active).isFirst();
    };
    this.mayMoveDown = function() {
        return this.active && !findNode(this.active).isLast();
    };
    this.mayMoveLeft = function() {
        return this.active && (findNode(this.active).getLevel() > 1);
    };
    this.mayMoveRight = function() {
        if (this.active) {
            var node = findNode(this.active).getNextSibling();
            while (node) {
                if (node.isFolder) { return true; }
                node = node.getNextSibling();
            }
        }
        return false;
    };
    this.mayInsertBefore = function() {
        return Boolean(this.active);
    };
    this.mayInsertAfter = function() {
        return Boolean(this.active);
    };
    this.mayInsertInside = function() {
        return this.active && findNode(this.active).isFolder;
    };
    this.mayRemove = function() {
        if (this.active) {
            var node = findNode(this.active);
            if (node.isDoc) { return true; }
            if (node.isFolder && !node.childNodes.length) { return true; }
        }
        return false;
    };
    this.moveUp = function() {
        var node = findNode(this.active);
        var index = node.getIndex();
        var parent = node.parentNode;
        parent.removeChild(node);
        parent.appendChildAtIndex(node, index-1);
        this.updateHtml();
    };
    this.moveDown = function() {
        var node = findNode(this.active);
        var index = node.getIndex();
        var parent = node.parentNode;
        parent.removeChild(node);
        parent.appendChildAtIndex(node, index+1);
        this.updateHtml();
    };
    this.moveLeft = function() {
        opened1();
        var node = findNode(this.active);
        var left = node.parentNode;
        left.removeChild(node);
        left.parentNode.appendChildAtIndex(node, left.getIndex());
        this.active = node.id;
        opened2();
        this.updateHtml();
    };
    this.moveRight = function() {
        opened1();
        var node = findNode(this.active);
        var next = node.getNextSibling();
        var rightId = null;
        while (next) {
            if (next.isFolder) {
                rightId = next.id;
                break;
            }
            next = next.getNextSibling();
        }
        var right = findNode(rightId);
        node.parentNode.removeChild(node);
        if (right.childNodes.length) {
            right.appendChildAtIndex(node, 0);
        } else {
            right.appendChild(node);
        }
        this.active = node.id;
        opened2();
        this.updateHtml();
    };
    this.createNode = function(id, text, type) {
    	id = unescape(id);
        if (!id || findNode(id) || !text || (type != "doc" && type != "folder")) {
            throw this.id+'.createNode("'+id+'", "'+text+'", "'+type+'") failed, illegal action';
        }
        var node;
        if (type == "doc") {
            node = new Node(id, text, null, null, true, false);
        } else {
            node = new Node(id, text, null, new Array(), false, true);
        }
        this.allNodes.push(node);
        return node;
    };
    this.insert = function(name, text, type) {
        var node = this.createNode("tree-"+name, text, type);
        if (this.tree.childNodes.length) {
            this.tree.appendChildAtIndex(node, 0);
        } else {
            this.tree.appendChild(node);
        }
        this.updateHtml();
    };
    this.insertBefore = function(name, text, type) {
        if (!this.mayInsertBefore()) {
            throw this.id+'.insertBefore() failed, illegal action';
        }
        var active = findNode(this.active);
        var id = active.parentNode.getRealId() ? active.parentNode.getRealId()+"/"+name : "tree-"+name;
        var node = this.createNode(id, text, type);
        active.parentNode.appendChildAtIndex(node, active.getIndex());
        this.updateHtml();
    };
    this.insertAfter = function(name, text, type) {
        if (!this.mayInsertAfter()) {
            throw this.id+'.insertAfter() failed, illegal action';
        }
        var active = findNode(this.active);
        var id = active.parentNode.getRealId() ? active.parentNode.getRealId()+"/"+name : "tree-"+name;
        var node = this.createNode(id, text, type);
        if (active.parentNode.childNodes[active.getIndex()+1]) {
            active.parentNode.appendChildAtIndex(node, active.getIndex()+1);
        } else {
            active.parentNode.appendChild(node);
        }
        this.updateHtml();
    };
    this.insertInsideAtStart = function(name, text, type) {
        if (!this.mayInsertInside()) {
            throw this.id+'.insertInsideAtStart() failed, illegal action';
        }
        var active = findNode(this.active);
        var id = active.getRealId() ? active.getRealId()+"/"+name : "tree-"+name;
        var node = this.createNode(id, text, type);
        if (active.childNodes.length) {
            active.appendChildAtIndex(node, 0);
        } else {
            active.appendChild(node);
        }
        this.updateHtml();
    };
    this.insertInsideAtEnd = function(name, text, type) {
        if (!this.mayInsertInside()) {
            throw this.id+'.insertInsideAtEnd() failed, illegal action';
        }
        var active = findNode(this.active);
        var id = active.getRealId() ? active.getRealId()+"/"+name : "tree-"+name;
        var node = this.createNode(id, text, type);
        active.appendChild(node);
        this.updateHtml();
    };
    this.renameThis = function(text, type) {
    	var node = findNode(this.active);
    	var id = node.getRealId();
   		id = (id.substr(0, id.lastIndexOf("/")+1) == '' ? "tree-" : id.substr(0, id.lastIndexOf("/")+1)) + (type == "folder" ? text : text + ".html")
		node.id = id;
		node.text = text;
		this.active = id;
		node.fixIds();
        this.updateHtml();
    };
    this.remove = function() {
        var node = findNode(this.active);
        node.parentNode.removeChild(node);
        removeNode(this.active);
        this.active = "";
        this.updateHtml();
    };
    this.rename = function(product_data) {
    	build_name = product_data.substr(product_data.lastIndexOf(";")+1);
    	product_data = product_data.substr(0,product_data.lastIndexOf(";"));

    	edition_name = product_data.substr(product_data.lastIndexOf(";")+1);
    	product_data = product_data.substr(0,product_data.lastIndexOf(";"));

    	product_name = product_data.substr(product_data.lastIndexOf(";")+1);

    	var build = findNode(this.active);
        build.text = product_name;

        if (build.getLevel() > 1)
        {
        	var edition = build.parentNode;
        	edition.text = edition_name;

	        if (edition.getLevel() > 1)
	        {
	        	var product = edition.parentNode;
	        	product.text = build_name;
	        }
        }
        this.updateHtml();
    };
    function Node(id, text, parentNode, childNodes, isDoc, isFolder) {
        this.id = id;
        this.text = text;
        this.parentNode = parentNode;
        this.childNodes = childNodes;
        this.isDoc = isDoc;
        this.isFolder = isFolder;
        this.isDocument = function() { return this.isDoc; }
        this.isFirst = function() {
            if (this.parentNode) {
                return this.parentNode.childNodes[0].id == this.id;
            }
            throw "DynamicTree.Node.isFirst() failed, this func cannot be called for the root element";
        };
        this.isLast = function() {
            if (this.parentNode) {
                return this.parentNode.childNodes.getLast().id == this.id;
            }
            throw "DynamicTree.Node.isLast() failed, this func cannot be called for the root element";
        };
        this.getName = function() {
            if (this.id == "tree") { return ""; }
            if (this.id.lastIndexOf("/") == -1) { return this.id.substr("tree-".length); }
            return this.id.substr(this.id.lastIndexOf("/")+1);
        };
        this.getRealId = function() {
            var ret = this.getName();
            var parent = this.parentNode;
            while (parent) {
                if (parent.parentNode) {
                    ret = parent.getName() +'/'+ ret;
                } else {
                    ret = "tree-" + ret;
                }
                parent = parent.parentNode;
            }
            return ret;
        };
        this.fixIds = function() {
            this.id = this.getRealId();
            if (this.isFolder) {
                for (var i = 0; i < this.childNodes.length; ++i) {
                    this.childNodes[i].fixIds();
                }
            }
        };
        this.getLevel = function() {
            var level = 0;
            var node = this;
            while (node.parentNode) {
                level++;
                node = node.parentNode;
            }
            return level;
        };
        this.getNextSibling = function() {
            if (this.parentNode) {
                var nodes = this.parentNode.childNodes;
                var start = false;
                for (var i = 0; i < nodes.length; i++) {
                    if (start) { return nodes[i]; }
                    if (!start && this.id != nodes[i].id) { continue; }
                    start = true;
                }
                return false;
            }
            throw "DynamicTree.Node.getNextSibling() failed, this func cannot be called for the root element";
        };
        this.getPreviousSibling = function() {
            if (this.parentNode) {
                var nodes = this.parentNode.childNodes;
                for (var i = 0; i < nodes.length; i++) {
                    if (nodes[i].id == this.id) {
                        if (i) { return nodes[i-1]; }
                        else { return false; }
                    }
                }
                throw "DynamicTree.Node.getPreviousSibling() failed, unknown error";
            }
            throw "DynamicTree.Node.getPreviousSibling() failed, this func cannot be called for the root element";
        };
        this.getIndex = function() {
            if (this.parentNode) {
                var nodes = this.parentNode.childNodes;
                for (var i = 0; i < nodes.length; i++) {
                    if (nodes[i].id == this.id) { return i; }
                }
                throw "DynamicTree.Node.getIndex() failed, unknown error";
            }
            throw "DynamicTree.Node.getIndex() failed, this func cannot be called for the root element";
        };
        this.removeChild = function(node) {
            this.childNodes.removeByIndex(node.getIndex());
            node.parentNode = null;
        };
        this.appendChild = function(node) {
            this.childNodes.push(node);
            node.parentNode = this;
            node.fixIds();
        };
        this.appendChildAtIndex = function(node, index) {
            this.childNodes.pushAtIndex(node, index);
            node.parentNode = this;
            node.fixIds();
        };
        this.toHtml = function() {
            var s = '<div onselectstart="return false" class="'+(this.isFolder ? "folder" : "doc")+'" id="'+this.id+'">';
            if (this.isFolder) {
                var nodeIcon;
                if (this.childNodes.length) {
                    nodeIcon = (self.opened.contains(this.id) ? (this.isLast() ? "tree-node-open-end.gif" : "tree-node-open.gif") : (this.isLast() ? "tree-node-end.gif" : "tree-node.gif"));
                } else {
                    nodeIcon = (this.isLast() ? "tree-leaf-end.gif" : "tree-leaf.gif");
                }
                var icon = ((self.opened.contains(this.id) && this.childNodes.length) ? "tree-folder-open.gif" : "tree-folder.gif");
                if (this.childNodes.length) { s += '<a href="javascript:void(0)" onclick="'+self.id+'.nodeClick(\''+this.id+'\'); this.blur();">'; }
                s += '<img id="'+this.id+'-node" src="'+self.path+nodeIcon+'" width="18" height="18" alt="" />';
                if (this.childNodes.length) { s += '</a>'; }
                //s += '<img id="'+this.id+'-icon" src="'+self.path+icon+'" width="18" height="18" alt="" />';
                s += '<span id="'+this.id+'-text" class="text'+(self.active == this.id ? '-active' : '')+'" '+(this.childNodes.length ? 'ondblclick="'+self.id+'.nodeClick(\''+this.id+'\'); this.blur();"' : "")+' onclick="'+self.id+'.textClick(\''+this.id+'\')">'+this.text+'</span>';
                if (this.childNodes.length) {
                    s += '<div class="section'+(this.isLast() ? " last" : "")+'" id="'+this.id+'-section"';
                    if (self.opened.contains(this.id)) {
                        s += '  style="display: block;"'; }
                    s += '>';
                    for (var i = 0; i < this.childNodes.length; i++) {
                        s += this.childNodes[i].toHtml();
                    }
                    s += '</div>';
                }
            }
            if (this.isDoc) {
                s += '<img src="'+self.path+(this.isLast() ? "tree-leaf-end.gif" : "tree-leaf.gif")+'" width="18" height="18" alt="" />'; //<img src="'+self.path+'tree-doc.gif" />';
                s += '<span id="'+this.id+'-text" class="text'+(self.active == this.id ? '-active' : '')+'" onclick="'+self.id+'.textClick(\''+this.id+'\')">'+this.text+'</span>';
            }
            s += '</div>';
            return s;
        };

        this.toToc = function(parentNode) {
        	var s = '';
        	s += '<ul>';

            if (this.isFolder) {
                s += '<li><a href="javascript:void(0)"><span id="'+this.id+'-text" class="text'+(self.active == this.id ? '-active' : '')+'" '+(this.childNodes.length ? 'ondblclick="tree.nodeClick(\''+this.id+'\'); this.blur();"' : "")+' onclick="tree.textClick(\''+this.id+'\')">'+this.text+'</span></a></li>';

                if (this.childNodes.length) {
                    for (var i = 0; i < this.childNodes.length; i++) {
                        s += this.childNodes[i].toToc(this.parentNode.id);
                    }
                }
            }
            if (this.isDoc) {
                s += '<li><a href="javascript:void(0)"><span id="'+this.id+'-text" class="text'+(self.active == this.id ? '-active' : '')+'" onclick="tree.textClick(\''+this.id+'\')">'+this.text+'</span></a></li>';
            }

            if (s != '') {
            }

            s += '</ul>';
            return s;
        };
    }

    function Listener() {
        this.funcs = [];
        this.add = function(func) {
            this.funcs.push(func);
        };
        this.call = function() {
            for (var i = 0; i < this.funcs.length; ++i) {
                this.funcs[i]();
            }
        };
    }

    function findNode(id) {
        for (var i = 0; i < self.allNodes.length; ++i) {
            if (self.allNodes[i].id == id) {
                return self.allNodes[i];
            }
        }
        return false;
    }
    function removeNode(id) {
        for (var i = 0; i < self.allNodes.length; ++i) {
            if (self.allNodes[i].id == id) {
                self.allNodes.splice(i, 1);
                return true;
            }
        }
        return false;
    }

    function opened1() {
        self.openedNodes = [];
        for (var i = 0; i < self.opened.length; ++i) {
            self.openedNodes.push(findNode(self.opened[i]));
        }
    }
    function opened2() {
        self.opened = [];
        for (var j = 0; j < self.openedNodes.length; ++j) {
            self.opened.push(self.openedNodes[j].id);
        }
    }

    this.getActiveNode = function() {
        if (this.active) {
            return findNode(this.active);
        }
    };

    //
    // Fix for initializing the active entry
    //
    this.setActive = function() {
        // bad design !
        checkContentSaved();
        if (this.active) {
            document.getElementById(this.active+"-text").className = "text";
        }
        document.getElementById('tree-' + this.queryPath+"-text").className = "text-active";
        this.active = 'tree-' + this.queryPath;
        this.textClickListener.call();
    };

    var self = this;
    this.id = id;
    this.tree = new Node("tree", "", null, new Array(), false, true);
    this.allNodes = [];
    this.opened = []; // opened folders
    this.openedNodes = [];
    this.active = ""; // active node, text clicked
    this.cookie = new Cookie();
    this.textClickListener = new Listener(); // other modules also need to know when user clicks on text
    this.queryPath = '';
}