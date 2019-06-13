<xsl:stylesheet xmlns:xsl = "http://www.w3.org/1999/XSL/Transform" version = "1.0" >
<xsl:output omit-xml-declaration="no" method="xml" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" indent="yes" encoding="UTF-8" />
<xsl:template match = "/icestats" >
_START_
<xsl:for-each select="source">
<xsl:value-of select="@mount" />|
<xsl:value-of select="server_name" />|
<xsl:value-of select="server_description" />|
<xsl:value-of select="server_type" />|
<xsl:value-of select="bitrate" />|
<xsl:value-of select="quality" />|
<xsl:value-of select="video_quality" />|
<xsl:value-of select="frame_size" />|
<xsl:value-of select="frame_rate" />|
<xsl:value-of select="listeners" />|
<xsl:value-of select="listener_peak" />|
<xsl:value-of select="genre" />|
<xsl:value-of select="server_url" />|
<xsl:value-of select="artist" />|
<xsl:value-of select="title" />|
_END_
</xsl:for-each>
</xsl:template>
</xsl:stylesheet> 