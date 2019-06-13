<!--
	Ultimate Google Sitmaps XSLTransform
	(C) 2006 dcz - http://www.phpbb-seo.com/
-->
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
  <xsl:output method="html" version="1.0" encoding="utf-8" indent="yes"/>
  <!-- Root template -->    
  <xsl:template match="/">
     <!-- Store in $fileType if we are in a sitemap or in a SitemapIndex -->
      <xsl:variable name="fileType">
        <xsl:choose>
		  <xsl:when test="//sitemap:url">Sitemap</xsl:when>
		  <xsl:otherwise>SitemapIndex</xsl:otherwise>
        </xsl:choose>      
</xsl:variable>
	<xsl:variable name="home_link">
		<xsl:choose><xsl:when test="$fileType='Sitemap'"><xsl:value-of select="substring-before(substring-after(sitemap:urlset/sitemap:url/sitemap:loc, 'http://'), '/')"/></xsl:when>
			<xsl:otherwise><xsl:value-of select="substring-before(substring-after(sitemap:sitemapindex/sitemap:sitemap/sitemap:loc, 'http://'), '/')"/></xsl:otherwise>
		</xsl:choose>
</xsl:variable>
    <html>     
      <head>  
	      <title>
		      <xsl:choose><xsl:when test="$fileType='Sitemap'">xml Sitemap : <xsl:value-of select="substring-after(sitemap:urlset/sitemap:url/sitemap:loc, 'http://')"/></xsl:when>
				<xsl:otherwise>xml SitemapIndex</xsl:otherwise>
  			</xsl:choose>
		</title>
		<link rel="stylesheet" href="ggs_style/mxgss.css" type="text/css"/>
      </head>
      <!-- Body -->
      <body>
<table class="bodytable" cellspacing="15">
  <tr>
	  <td>
	      <h1 id="mxgssLogo">xml <xsl:value-of select="$fileType"/></h1><br />
	<h3><a href="http://{$home_link}" title="Home" class="nav">Home</a></h3>
	<h1> <xsl:value-of select="$fileType"/> 
		<xsl:if test="$fileType='Sitemap'">  of : <a href="{sitemap:urlset/sitemap:url/sitemap:loc}" title="Visit source"> <xsl:value-of select="substring-after(sitemap:urlset/sitemap:url/sitemap:loc, 'http://')"/></a></xsl:if>
			</h1>
        <xsl:choose>
	      <xsl:when test="$fileType='Sitemap'"><xsl:call-template name="sitemapTable"/></xsl:when>
	      <xsl:otherwise><xsl:call-template name="siteindexTable"/></xsl:otherwise>
  		</xsl:choose>
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
	<br/>
	<div class="copyright">© 2006 <a href="http://www.phpbb-seo.com" title="Optimisation du r&#233;f&#233;rencement" class="copyright">phpBB SEO</a></div>
              </td>
          </tr>
  </table>
      </body>
    </html>
  </xsl:template>     
  <!-- siteindexTable template -->
  <xsl:template name="siteindexTable">
    <h2>Number of Sitemaps in this Google SitemapIndex : <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"></xsl:value-of></h2>          
    <br />
    <table border="1" width="100%" class="forumline">
      <tr class="header">
	<td class="header_cell" nowrap="nowrap">Sitemap URL</td>
        <td class="header_cell" nowrap="nowrap">Last modification date</td>
      </tr>
      <xsl:apply-templates select="sitemap:sitemapindex/sitemap:sitemap">
        <xsl:sort select="sitemap:lastmod" order="descending"/>              
      </xsl:apply-templates>  
    </table>            
  </xsl:template>  
  <!-- sitemapTable template -->  
  <xsl:template name="sitemapTable">
	  <h2>Number of URLs in this Google Sitemap : <xsl:value-of select="count(sitemap:urlset/sitemap:url)"></xsl:value-of></h2>  
    <br />
    <table width="100%" class="forumline">
	  <tr class="header">
	    	<td class="header_cell" nowrap="nowrap">Link</td>
		<td class="header_cell" nowrap="nowrap">Last modification date</td>
		<td class="header_cell" nowrap="nowrap">Change freq.</td>
		<td class="header_cell" nowrap="nowrap">Priority</td>
	  </tr>
	  <xsl:apply-templates select="sitemap:urlset/sitemap:url">
	<xsl:sort select="sitemap:lastmod" order="descending"/>       
	  </xsl:apply-templates>
	</table>  
  </xsl:template>
  <!-- sitemap:url template -->  
  <xsl:template match="sitemap:url">
    <tr>  
      <td class="row1">
        <xsl:variable name="sitemapURL"><xsl:value-of select="sitemap:loc"/></xsl:variable>  
        <a href="{$sitemapURL}" target="_blank"><xsl:value-of select="$sitemapURL"></xsl:value-of></a>
      </td>
      <td class="row2"><xsl:value-of select="sitemap:lastmod"/></td>
      <td class="row3"><xsl:value-of select="sitemap:changefreq"/></td>
      <td class="row4"><xsl:value-of select="sitemap:priority"/></td>
    </tr>  
  </xsl:template>
  <!-- sitemap:sitemap template -->
  <xsl:template match="sitemap:sitemap">
    <tr>  
      <td class="row1">        
        <xsl:variable name="sitemapURL"><xsl:value-of select="sitemap:loc"/></xsl:variable>  
        <a href="{$sitemapURL}"><xsl:value-of select="$sitemapURL"></xsl:value-of></a>
      </td>
      <td class="row2"><xsl:value-of select="sitemap:lastmod"/></td>
    </tr>  
  </xsl:template>
</xsl:stylesheet>
