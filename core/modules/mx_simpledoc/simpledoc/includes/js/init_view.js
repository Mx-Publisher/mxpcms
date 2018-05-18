function treeGetId() {
    if (tree.active) {
        return tree.active.substr("tree-".length);
    }
    return "";
}

/** RSH must be initialized after the page is finished loading. */
window.onload = initialize;

// This updates docs whenever a node is clicked OR updateUI() is called
tree.textClickListener.add(function() {
	if (tree.getActiveNode().isDocument()) {
		documentView();
		dhtmlHistory.add( treeGetId(),  el(tree.active+"-text").innerHTML  );

		queryPath = tree.getActiveNode().id;
		tree.queryPath = queryPath.replace('tree-', "");
		tree.active = queryPath;
		tree.loadState();
		//tree.updateHtml(); // Fix for NOT folding categories
		document.title = el(tree.active+"-text").innerHTML;
	}
	else
	{
		el('tabs-data').innerHTML = "";
	}
});

// Activate first doc in the clicked folder
tree.textClickListener.add(function() {
	if (!tree.getActiveNode().isDocument()) {

		generateParentTOC('view');
		dhtmlHistory.add( treeGetId(),  el(tree.active+"-text").innerHTML  );

		//queryPath = tree.getActiveNode().id;
		//tree.queryPath = queryPath.replace('tree-', "");
		//tree.active = queryPath;
		//tree.loadState();
		//tree.updateHtml();

		//if (tree.getActiveNode().childNodes) {
			//for (var i = 0; i < tree.getActiveNode().childNodes.length; i++) {
				//if (tree.getActiveNode().childNodes[i].isDocument()) {
					//queryPath = tree.getActiveNode().childNodes[i].id;
					//tree.queryPath = queryPath.replace('tree-', "");
					//tree.active = queryPath;
				  	//tree.loadState();
				  	//tree.updateHtml();
				  	//break;
				//}
			//}
		//}
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