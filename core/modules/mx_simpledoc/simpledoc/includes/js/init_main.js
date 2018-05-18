function treeGetId() {
    if (tree.active) {
        return tree.active.substr("tree-".length);
    }
    return "";
}

/** RSH must be initialized after the page is finished loading. */
window.onload = initialize;

tree.textClickListener.add(function() {
	if (document.getElementById("tree-insert-form").style.display == "block") {
		treeInsert();
	}
});

tree.textClickListener.add(function() {
	if (!tree.getActiveNode().isDocument()) {
		if (tree.getActiveNode().childNodes) {
			for (var i = 0; i < tree.getActiveNode().childNodes.length; i++) {
				if (tree.getActiveNode().childNodes[i].isDocument()) {
					//queryPath = tree.getActiveNode().childNodes[i].id;
					//tree.queryPath = queryPath.replace('tree-', "");
					//tree.active = queryPath;
				  	//tree.loadState();
				  	//tree.updateHtml();
				  	//break;
				}
			}
		}
	}
});

tree.textClickListener.add(function() {
	if (tree.getActiveNode().isDocument()) {
	    if (getCookie('openEditContent')) editContent();
	    else documentInfo();
		document.title = el(tree.active+"-text").innerHTML;
	}
	else
	{
		clearTabs();
	}
});

function initialize() {
  // initialize RSH
  dhtmlHistory.initialize();

  // add ourselves as a listener for history change events
  dhtmlHistory.addListener(handleHistoryChange);

  if (dhtmlHistory.isFirstLoad())
  {
	  // determine our current location so we can initialize ourselves at startup
	  var initialLocation = dhtmlHistory.getCurrentLocation();

	  // if no location specified, use the default
	  if ((initialLocation == '' || initialLocation == null) && tree.allNodes[0])
	  {
	  	if (tree.allNodes[0].childNodes) {
	  		// First set default, then loop to find real document
	  		queryPath = tree.allNodes[0].id;
			for (var i = 0; i < tree.allNodes[0].childNodes.length; i++) {
				if (tree.allNodes[0].childNodes[i].isDocument()) {
					queryPath = tree.allNodes[0].childNodes[i].id;
				  	break;
				}
			}
	  	}
	  	else
	  	{
	  		queryPath = tree.allNodes[0].id;
	  	}

		initialLocation = queryPath.replace('tree-', "");
	  }

	  // now initialize our starting UI
	  if (tree.allNodes[0])
	  {
	  	updateUI(initialLocation, null);
	  }
  }
}

/** A function that is called whenever the user presses the back or forward buttons. This
    function will be passed the newLocation, as well as any history data we associated
    with the location. */
function handleHistoryChange(newLocation, historyData) {
  // use the history data to update our UI
  updateUI(newLocation, historyData);
}

/** A simple method that updates our user interface using the new location. */
function updateUI(newLocation, historyData) {
  //alert('updateUI');
  tree.queryPath = newLocation;
  tree.setActive();
  tree.loadState();
  tree.updateHtml();
}

var treeElements = ["tree-moveUp", "tree-moveDown", "tree-moveLeft", "tree-moveRight", "tree-insert", "tree-rename", "tree-remove"];
var treeTooltips = ["Move Up", "Move Down", "Move Left", "Move Right", "Insert", "Rename", "Delete"];

function treeTooltipOn() { document.getElementById("tree-tooltip").innerHTML = treeTooltips[treeElements.indexOf(this.id)]; }
function treeTooltipOff() { document.getElementById("tree-tooltip").innerHTML = ""; }

for (var i = 0; i < treeElements.length; i++) {
    document.getElementById(treeElements[i]).onmouseover = treeTooltipOn;
    document.getElementById(treeElements[i]).onmouseout = treeTooltipOff;
}

document.getElementById("tree-moveUp").onclick    = treeMoveUp;
document.getElementById("tree-moveDown").onclick  = treeMoveDown;
document.getElementById("tree-moveLeft").onclick  = treeMoveLeft;
document.getElementById("tree-moveRight").onclick = treeMoveRight;

if (document.all && !/opera/i.test(navigator.userAgent)) {
    document.getElementById("tree-moveUp").ondblclick    = treeMoveUp;
    document.getElementById("tree-moveDown").ondblclick  = treeMoveDown;
    document.getElementById("tree-moveLeft").ondblclick  = treeMoveLeft;
    document.getElementById("tree-moveRight").ondblclick = treeMoveRight;
}

document.getElementById("tree-insert").onclick    = treeInsert;
document.getElementById("tree-rename").onclick    = treeRename;
document.getElementById("tree-remove").onclick    = treeRemove;

document.getElementById("tree-insert-button").onclick = treeInsertExecute;
document.getElementById("tree-insert-cancel").onclick = treeHideInsert;

document.getElementById("tree-rename-button").onclick = treeRenameExecute;
document.getElementById("tree-rename-cancel").onclick = treeHideRename;

function treeMoveUp() {
    if (tree.mayMoveUp() && httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=moveUp&id="+escape(treeGetId())+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
        tree.moveUp();
    } else {
        alert('Cannot move up');
    }
}
function treeMoveDown() {
    if (tree.mayMoveDown() && httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=moveDown&id="+escape(treeGetId())+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
        tree.moveDown();
    } else {
        alert('Cannot move down');
    }
}
function treeMoveLeft() {
    if (tree.mayMoveLeft() && httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=moveLeft&id="+escape(treeGetId())+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
        tree.moveLeft();
    } else {
        alert('Cannot move left');
    }
}
function treeMoveRight() {
    if (tree.mayMoveRight() && httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=moveRight&id="+escape(treeGetId())+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
    	tree.moveRight();
    } else {
        alert('Cannot move right');
    }
}
function treeInsert() {
	document.getElementById("tree-rename-form").style.display = "none";
    document.getElementById("tree-insert-form").style.display = "block";
    document.getElementById("tree-insert-where-div").style.display = (tree.active ? "" : "none");
    if (tree.active) {
        var where = document.getElementById("tree-insert-where");
        if (tree.mayInsertInside()) {
            if (!where.options[2] && !where.options[3]) {
                where.options[2] = new Option("Inside at start", "inside_start");
                where.options[3] = new Option("Inside at end", "inside_end");
            }
        } else if (where.options[2] && where.options[3]) {
            where.options[2] = null;
            where.options[3] = null;
            where.options.length = 2;
        }
    }
}

/* only event - blur */
function treeInsertExecute() {
    var where = document.getElementById("tree-insert-where");
    var type = document.getElementById("tree-insert-type");
    var name = document.getElementById("tree-insert-name");

    name.value = name.value.trim();
    if (!name.value) {
        alert("Name is empty");
        return;
    }
    if (name.value.substr(-5) == ".html") {
        name.value = name.value.substr(0, name.value.length-5);
    }
    var id = escape(name.value);
    if (type.value != "folder") {
        id = escape(name.value + ".html");
    }
    if (tree.active) {
        switch (where.value) {
            case "before":
                if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=insertBefore&id="+escape(treeGetId())+"&name="+id+"&is_folder="+(type.value=="folder" ? 1 : 0)+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
                    tree.insertBefore(id, name.value, type.value);
                }
                break;
            case "after":
                if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=insertAfter&id="+escape(treeGetId())+"&name="+id+"&is_folder="+(type.value=="folder" ? 1 : 0)+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
                    tree.insertAfter(id, name.value, type.value);
                }
                break;
            case "inside_start":
                if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=insertInsideAtStart&id="+escape(treeGetId())+"&name="+id+"&is_folder="+(type.value=="folder" ? 1 : 0)+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
                    tree.insertInsideAtStart(id, name.value, type.value);
                }
                break;
            case "inside_end":
                if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=insertInsideAtEnd&id="+escape(treeGetId())+"&name="+id+"&is_folder="+(type.value=="folder" ? 1 : 0)+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
                    tree.insertInsideAtEnd(id, name.value, type.value);
                }
                break;
        }
    } else {
        if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=insert&id="+escape(treeGetId())+"&name="+id+"&is_folder="+(type.value=="folder" ? 1 : 0)+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
            tree.insert(id, name.value, type.value);
        }
    }
    name.value = "";
    this.blur();
    document.getElementById("tree-insert-form").style.display = "none";
}

function treeHideInsert() {
    var name = document.getElementById("tree-insert-name");
    name.value = "";
    document.getElementById("tree-insert-form").style.display = "none";
}

function treeRename() {
	document.getElementById("tree-insert-form").style.display = "none";
    document.getElementById("tree-rename-form").style.display = "block";
    if (tree.active) {
		el('tree-rename-name').value = el(tree.active+"-text").innerHTML;
    }
}

/* only event - blur */
function treeRenameExecute() {
    var type = tree.getActiveNode().isDocument() ? 'document' : 'folder';
    var name = document.getElementById("tree-rename-name");

    name.value = name.value.trim();
    if (!name.value) {
        alert("Name is empty");
        return;
    }
    if (name.value.substr(-5) == ".html") {
        name.value = name.value.substr(0, name.value.length-5);
    }
    var id = escape(name.value);
    if (type != "folder") {
        id = escape(name.value + ".html");
    }

    if (tree.active) {
       if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=rename&id="+escape(treeGetId())+"&name="+id+"&is_folder="+(type=="folder" ? 1 : 0)+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
          tree.renameThis(name.value, type);
       }
    }
    name.value = "";
    this.blur();
    document.getElementById("tree-rename-form").style.display = "none";
}

function treeHideRename() {
    var name = document.getElementById("tree-rename-name");
    name.value = "";
    document.getElementById("tree-rename-form").style.display = "none";
}

function treeRemove() {
    if (tree.mayRemove()) {
        if (confirm("Delete current node ?")) {
            if (httpSave("modules/mx_simpledoc/simpledoc/modules/simpledoc__node.php?do=remove&id="+escape(treeGetId())+'&block_id='+mxBlock.block_id+'&page_id='+mxBlock.page_id)) {
                tree.remove();
                if (document.getElementById("tree-insert-form").style.display == "block") {
                    treeInsert();
                }
                clearTabs();
            }
        }
    } else {
        alert('Cannot remove. You have not selected any node or the folder is not empty.');
    }
}