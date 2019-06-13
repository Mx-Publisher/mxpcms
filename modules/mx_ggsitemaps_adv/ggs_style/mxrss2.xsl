<!--
	Ultimate RSS XSLTransform
	(C) 2006 dcz - http://www.phpbb-seo.com/
-->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="utf-8" indent="yes"/>
<xsl:template match="/rss" >
<html xml:lang="{language}">
<xsl:variable name="rss_link">
	<xsl:value-of select="channel/item/source/@url" />
</xsl:variable>
<xsl:variable name="home_link">
	<xsl:value-of select="substring-before(substring-after(channel/link, 'http://'), '/')" />
</xsl:variable>
<xsl:variable name="browser">
	<xsl:choose><xsl:when test="system-property('xsl:vendor')='Transformiix'">mozilla</xsl:when>
		<xsl:otherwise>other</xsl:otherwise>
	</xsl:choose>
</xsl:variable>
<xsl:variable name="sorting">
	<xsl:choose><xsl:when test="$browser='mozilla'">descending</xsl:when>
		<xsl:otherwise>ascending</xsl:otherwise>
	</xsl:choose>
</xsl:variable>
<head>
	<title><xsl:value-of select="channel/title" /> -  RSS Feed</title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="alternate" type="application/rss+xml" title="{channel/title}" href="{$rss_link}" />
	<link rel="stylesheet" href="ggs_style/rss2.css" type="text/css"/>
	<xsl:if test="$browser='mozilla'">
		<!-- Mozilla ignores disable-output-escaping but we don't ;-) -->
		<script type="text/javascript">
		function onload_cb() {
			var elements = document.getElementsByTagName('div');
			for (var i = 0; i &lt; elements.length; i++) {
				var el = elements[i];
				if (el.className == 'description') {
					el.innerHTML = el.firstChild.data;
				}
			}
		}
	</script>
	</xsl:if>
</head>
<body>
<xsl:if test="$browser='mozilla'">
	<xsl:attribute name="onload">onload_cb()</xsl:attribute>
</xsl:if>
<table width="100%" cellspacing="10" cellpadding="10" class="bodytable">
	<tr>
		<td align="center" class="header">
			<table class="headertable" cellspacing="0" cellpadding="0">
  				<tr>
					<td  id="header_logo"></td>
  				</tr>
  				<tr>
					<td height="50" align="center" nowrap="nowrap"><h1><a href="{channel/link}" title="{channel/title}" class="channel_header"><xsl:value-of select="channel/title" /></a></h1></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left">
			<xsl:for-each select="channel">
				<p class="nav" align="left">
				<xsl:choose>
					<xsl:when test="string-length(substring-after(substring-after(link, 'http://'), '/')) &lt; 1"> 
						</xsl:when>
					<xsl:otherwise>
						<a href="http://{$home_link}" class="nav">Home</a> &#187;
					</xsl:otherwise>
				</xsl:choose>
					<a href="{link}" title="{title}" class="nav"><xsl:value-of select="title" /></a> &#187; <a href="{$rss_link}" class="nav">Source</a></p>
	<table width="90%" align="center" cellspacing="0" cellpadding="5" class="chantable">
		<tr>
			<td colspan="2" class="channel_header"><h1><a href="{link}" title="{title}" class="channel_header"><xsl:value-of select="title" /></a> - RSS Feed</h1></td>
		</tr>
		<tr>
			<td class="channel_desc"><h2><xsl:value-of select="title" /> :</h2><div class="chan_desc"><div class="description"><xsl:value-of select="description" disable-output-escaping="yes"/></div></div>
				<br/> Last update :
				<xsl:value-of select="lastBuildDate"/><hr/>
				Update : <xsl:value-of select="ttl"/> minutes.<hr/><br/>
			</td>
			<td class="podcatchers">
				<div class="podcatchers"><h2>Subscribe to this feed Now!</h2>Using web-based podcatchers.
				<a href="http://fusion.google.com/add?feedurl={$rss_link}" target="_google"><img src="ggs_style/addGoogle.gif" border="0" alt="Add to Google" title="Add to Google"/></a><br/>
				<a href="http://add.my.yahoo.com/rss?url={$rss_link}" target="_yahoo"><img src="ggs_style/addtomyyahoo.gif" border="0" alt="Add to My Yahoo" title="Add to My Yahoo"/></a><br/>
				<a href="http://my.msn.com/addtomymsn.armx?id=rss&#038;ut={$rss_link}&#038;ru={$rss_link}" target="_msn"><img src="ggs_style/MyMSN.gif" alt="Add to My MSN" title="Add to My MSN"/></a><br/>
				<a href="http://feeds.my.aol.com/index.jsp?url={$rss_link}" target="_aol"><img alt="Add to MY AOL" src="ggs_style/myaol.gif"  title="Add to My AOL" border="0"/></a><br/>
				<a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url={$rss_link}" target="_newsgator"><img src="ggs_style/newsgator.gif" alt="Subscribe in NewsGator Online" title="Subscribe in NewsGator Online" border="0"/></a><br/>
				<a href="http://www.netvibes.com/subscribe.php?url={$rss_link}" target="_netvibes"><img src="ggs_style/add2netvibes.gif" border="0" alt="Add to Netvibes" title="Add to Netvibes"/></a><br/>
				<a href="http://www.pageflakes.com/subscribe.aspx?url={$rss_link}" target="_pageflakes"><img src="ggs_style/pageflakes.gif" border="0" alt="Add to Page Flakes" title="Add to Page Flakes"/></a><br/></div>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="channel_desc" ><br/>To subscribe to this RSS feed manually, please use the following URL :
				<p>
					<form name="form" action="" method="get" >
						<label>RSS 2.0 feed link : </label>
						<input name="urlrss" type="text" value="{$rss_link}" size="80" maxlength="500" />
					</form>
				</p>
			</td>
		</tr>
		<tr >
			<td valign="bottom" class="channel_header" ><div class="chan_title">RSS Feed : <a href="{link}" title="{title}" class="chan_title"><xsl:value-of select="title" /></a></div>
			</td>
			<td valign="bottom" class="channel_header" >
				<div class="chan_title">
				<xsl:choose>
					<xsl:when test="count(item) = 1">
						One item listed.
						</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="count(item)"/> items listed.
					</xsl:otherwise>
				</xsl:choose>
				</div>
			</td>
		</tr>
		<tr>
			<td class="item_desc" width="75%">
				<table cellpadding="3" cellspacing="3" width="75%">
					<xsl:for-each select="item">
						<xsl:sort select="substring(pubDate,12,string-length(pubDate))" order="{$sorting}" data-type="number"/>  
					<tr>
						<td width="80%" class="item_header"><h2><xsl:value-of select="title" disable-output-escaping="yes"/></h2>
						</td>
					</tr>
					<tr>
						<td class="item_desc" ><div class="description"><xsl:value-of select="description" disable-output-escaping="yes"/></div></td>
					</tr>
					<tr>
						<td width="80%"><div class="item_detail">
						Link : <a href="{link}" ><xsl:value-of select="title"/></a><br/>
						Source : <a href="{source/@url}" title="{source}" target="_blank"><xsl:value-of select="source" /></a> &#45; <xsl:value-of select="pubDate" /></div>
						</td>
					</tr>
				</xsl:for-each>
				</table>
			</td>
			<td width="25%" class="chan_img" align="center" valign="top"><div class="postbody"><a href="{image/link}" target="_blank"><img src="{image/url}" border="0" title="{image/title}" alt="{image/title}" /></a></div></td>
		</tr>
		<tr >
			<td colspan="2" class="item_desc" ><br/></td>
		</tr>
	</table>
<hr />
</xsl:for-each>
              </td>
      </tr>
  <tr>

<!--
	We request you retain the full copyright notice below, as well as in all templates you may use,
	including the link to www.phpbb-seo.com.
	This not only gives respect to the large amount of time given freely by the developers
	but also helps build interest, traffic and use of www.phpBB-SEO.com
	If you cannot (for good reason) retain the full copyright we request you at least leave in place the
	"Copyright phpBB SEO" line, with "phpBB SEO" linked to www.phpbb-seo.com.
	If you refuse to include even this, then support and further development on our forums may be affected.
	The phpBB SEO Team : 2006.
-->
            <td nowrap="nowrap">
		    <div class="copyright">Powered by <a href="http://www.phpbb-seo.com/" title="Search Engine Optimization" class="copyright">phpBB Seo</a> © 2000 - 2008 phpBB Group</div>
            </td>
          </tr>
</table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
