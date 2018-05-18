function mx_toggle(in_buttonSwitch, in_listID, img_expand, img_contract)
{
    if (document.getElementById) {
        listID = document.getElementById(in_listID);
    }
    else {
        return;
    }

    if (listID.style.display == '') {
        listID.style.display = 'none';
        in_buttonSwitch.innerHTML = '<img src="' + img_expand + '" border="0" />';
        rollup_record_state(in_listID, 0);
    }
    else {
        listID.style.display = '';
        in_buttonSwitch.innerHTML = '<img src="' + img_contract + '" border="0" />';
        rollup_record_state(in_listID, 1);
    }

    if (window.event) {
        window.event.cancelBubble=true;
    }
}

function mx_toggle_editCP(in_buttonSwitch, in_listID, img_expand, img_contract)
{
	var in_listID;
	var inc = 0;
	var listID = document.all ? document.all : document.getElementsByTagName("*");

	if (listID == null){
		return;
	}
	
	for (var i=0;i<listID.length;i++){
		if (listID[i].className==in_listID){
	    	if (listID[i].style.display == '') {
	        	listID[i].style.display = 'none';
	       	 	in_buttonSwitch.innerHTML = '<img src="' + img_expand + '" border="0" />';
				var send_cookie = 0;
	    	}
	    	else {
	        	listID[i].style.display = '';
	        	in_buttonSwitch.innerHTML = '<img src="' + img_contract + '" border="0" />';
				var send_cookie = 1;
	    	}
	
	    	if (window.event) {
	        	window.event.cancelBubble=true;
	    	}
		}
	}
    
	if (send_cookie == 1) {
     	rollup_record_state(in_listID, 1);
    }
    else {
       	rollup_record_state(in_listID, 0);
    }
}

function rollup_record_state(in_listID, status) 
{
    var expDate = new Date();
    // expires in 1 year
    expDate.setTime(expDate.getTime() + 31536000000);
    document.cookie = in_listID + "=" + escape(status) + "; expires=" + expDate.toGMTString();
}

function ref(object)
{
	if (document.getElementById)
	{
		return document.getElementById(object);
	}
	else if (document.all)
	{
		return eval('document.all.' + object);
	}
	else
	{
		return false;
	}
}

function expand(object)
{
	object = ref(object);
	
	if( !object.style )
	{
		return false;
	}
	else
	{
		object.style.display = '';
	}

	if (window.event)
	{
		window.event.cancelBubble = true;
	}
}

function contract(object)
{
	object = ref(object);
	
	if( !object.style )
	{
		return false;
	}
	else
	{
		object.style.display = 'none';
	}

	if (window.event)
	{
		window.event.cancelBubble = true;
	}
}

function toggle(object, path)
{
	image = ref(object + '_img');
	object = ref(object);

	if( !object.style )
	{
		return false;
	}
	
	if( object.style.display == 'none' )
	{
		object.style.display = '';
		image.src = path + 'contract.gif';
	}
	else
	{
		object.style.display = 'none';
		image.src = path + 'expand.gif';
	}
}
