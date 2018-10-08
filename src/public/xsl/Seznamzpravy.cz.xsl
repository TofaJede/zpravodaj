<xsl:stylesheet
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <xsl:template match="/">
        <rss>
        <title>Seznam Zprávy - nejnovější články</title>
        <link>https://www.seznamzpravy.cz</link>
        <desc>Seznam Zprávy - nejnovější články</desc>

        <items>
            <xsl:for-each select="rss/channel/item[position() &lt; 6]">
                <item>
                    <title><xsl:value-of select="g:title" /></title>
                    <link><xsl:value-of select="g:link" /></link>
                    <desc><xsl:value-of select="g:description" /></desc>
                    <image><xsl:value-of select="g:image_link" /></image>
                    <pubDate><xsl:value-of select="g:custom_label_0" /></pubDate>
                </item>
            </xsl:for-each>
        </items>
        </rss>
        
    </xsl:template>

</xsl:stylesheet>



