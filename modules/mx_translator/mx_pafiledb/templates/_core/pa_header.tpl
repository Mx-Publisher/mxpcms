<SCRIPT LANGUAGE="JavaScript">
<!--
	function mpFoto(img)
	{
		foto1= new Image();
		foto1.src=(img);
		mpControl(img);
	}

	function mpControl(img)
	{
		if((foto1.width!=0)&&(foto1.height!=0))
		{
			viewFoto(img);
		}
		else
		{
			mpFunc="mpControl('"+img+"')";
			intervallo=setTimeout(mpFunc,20);
		}
	}

	function viewFoto(img)
	{
		largh=foto1.width+20;
		altez=foto1.height+20;
		string="width="+largh+",height="+altez;
		finestra=window.open(img,"",string);
	}

	function MM_jumpMenu(targ,selObj,restore)
	{
		//v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore)
		{
			selObj.selectedIndex=0;
		}
	}

    function delete_file(theURL)
	{
       if (confirm('Are you sure you want to delete this file??'))
	   {
          window.location.href=theURL;
       }
       else
	   {
          alert ('No Action has been taken.');
       }
    }

//-->
</script>

<!-- <script type="text/javascript" src="{MX_ROOT_PATH}modules/mx_shared/ajax/ask.js"></script> -->

<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forumline" style="border-top:none;">
	<tr>
		<td align="center" class="row1">
			<!-- IF IS_AUTH_SEARCH -->
			{B_SEARCH_IMG}
			<!-- ENDIF -->
			<!-- IF IS_AUTH_STATS -->
			{B_STATS_IMG}
			<!-- ENDIF -->
			<!-- IF IS_AUTH_TOPLIST -->
			{B_TOPLIST_IMG}
			<!-- ENDIF -->
			<!-- IF IS_AUTH_UPLOAD -->
			{B_UPLOAD_IMG}
			<!-- ENDIF -->
			<!-- IF IS_AUTH_VIEWALL -->
			{B_VIEW_ALL_IMG}
			<!-- <b>&nbsp;<a href="{U_VIEW_ALL}" class="gensmall"><img src="{VIEW_ALL_IMG}" border="0" alt="{L_VIEW_ALL}" align="middle" /></a>&nbsp;</b> -->
			<!-- ENDIF -->
			<br />
			<!-- IF IS_AUTH_MCP -->
			{B_MCP_LINK}
			<!-- ENDIF -->
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
 <tr>
	<td align="center" width="100%" height="100%" valign="top">

		<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
		  <tr>
			<td width="100%" valign="top" colspan="2">