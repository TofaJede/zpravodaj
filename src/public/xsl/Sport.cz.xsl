<xsl:stylesheet version="2.0"
                xmlns:szn="https://www.seznam.cz"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <rss>
            <title>Sport.cz</title>
            <link>https://www.sport.cz/</link>
            <desc>Sport.cz - sportovní zpravodajský server</desc>

            <items>
                <xsl:for-each select="rss/channel/item[position() &lt; 6]">
                    <item>
                        <title><xsl:value-of select="title" /></title>
                        <link><xsl:value-of select="guid" /></link>
                        <desc><xsl:value-of select="description" /></desc>
                        <image><xsl:value-of select="szn:image" /></image>
                        <pubDate><xsl:value-of select="pubDate" /></pubDate>
                    </item>
                </xsl:for-each>
            </items>
        </rss>
    </xsl:template>

</xsl:stylesheet>