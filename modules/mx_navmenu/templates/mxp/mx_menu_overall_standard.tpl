<link href="{U_PORTAL_ROOT_PATH}modules/mx_navmenu/templates/prosilver/prosilver.css" rel="stylesheet" type="text/css" media="screen" />
<div style="clear:left;float:left">
	<ul>
		<!-- BEGIN catrow -->
		<li class="button{catrow.CURRENT}" id="c_{catrow.CAT_ID}" onmouseover="showMenuRows('{catrow.CAT_ID}');" onmouseout="hideMenuRows('{catrow.CAT_ID}')">
			{catrow.CATEGORY}

			<ul id="cat_{catrow.CAT_ID}" onmouseover="showMenuRows('{catrow.CAT_ID}');" style="display:none;position:absolute;background-color:#FFFFFF;margin:0px;padding:0px;position:absolute;z-index:160;"><!-- BEGIN menurow -->
				<li class="mnu-ov{catrow.menurow.CURRENT}">
					<a href="{catrow.menurow.U_MENU_URL}" style="background-image: url({catrow.menurow.MENU_ICON})">
						{catrow.menurow.MENU_NAME}
					</a>
				</li>
<!-- END menurow --></ul>
		 </li>
	<!-- END catrow -->
	</ul>
</div>
<script type="text/javascript">
function getObj(obj)
{
	return ( document.getElementById ? document.getElementById(obj) : ( document.all ? document.all[obj] : null ) );
}

var qeuedMenuSteps = new Array();
var qeuedMenuCurrentStep = 0;
var qeuedMenuTime = 1000;

function objOffSet(){
	this.left = 0;
	this.top = 0;
}

function calOffset( obj, obj2){
	obj.left = obj.left + obj2.offsetLeft;
	obj.top = obj.left + obj2.offsetTop;
	if ( obj2.nodeName != 'HTML') {
		obj = calOffset( obj, obj2.parentNode);
	}
	return obj;
}

/**
 *
 * @access public
 * @return void
 **/
function proceedMenuSteps( proceed){

	if ( qeuedMenuCurrentStep < qeuedMenuSteps.length || proceed)
	{
		while( qeuedMenuCurrentStep < qeuedMenuSteps.length )
		{
			eval( qeuedMenuSteps[qeuedMenuCurrentStep]);
			qeuedMenuCurrentStep ++;
		}
	}
	setTimeout( 'proceedMenuSteps()', qeuedMenuTime);
}
setTimeout( 'proceedMenuSteps()', qeuedMenuTime);

/**
 *
 * @access public
 * @return void
 **/
function hideMenuRows( objID){
	qeuedMenuSteps[qeuedMenuSteps.length] = "getObj('"+ 'cat_' + objID + "').style.border='none';";
	qeuedMenuSteps[qeuedMenuSteps.length] = "getObj('"+ 'cat_' + objID + "').style.display='none';";
}

function showMenu( objID){
	cat_obj = getObj( 'cat_' + objID);
	if ( cat_obj.innerHTML.replace( '#^\s*|\s*$#', '') != '' )
	{
		cat_obj.style.display = 'block';
		cat_obj.style.border = 'solid 1px Black';
		cat_obj.style.borderTop = 'none';
	}
}
/**
 *
 * @access public
 * @return void
 **/
function showMenuRows( objID){
	qeuedMenuSteps[qeuedMenuSteps.length] = "showMenu( '" + objID + "');";
	proceedMenuSteps( true);
}
//alert(getObj( 'menu_rows'));
</script>
