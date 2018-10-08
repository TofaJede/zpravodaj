<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <rss>
            <title>Blesk.cz</title>
            <link>http://www.blesk.cz</link>
            <desc>Blesk.cz</desc>

            <items>
                <xsl:for-each select="rss/channel/item[position() &lt; 6]">
                    <item>
                        <title><xsl:value-of select="title" /></title>
                        <link><xsl:value-of select="link" /></link>
                        <desc><xsl:value-of select="description" /></desc>
                        <image></image>
                        <pubDate><xsl:value-of select="pubDate" /></pubDate>
                    </item>
                </xsl:for-each>
            </items>
        </rss>
    </xsl:template>

</xsl:stylesheet>