<xsl:stylesheet
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        xmlns:szn="https://www.seznam.cz"  version="2.0">
    <xsl:template match="/">
        <rss>
            <title>Seznam Zprávy - nejnovější články</title>
            <link>https://www.seznamzpravy.cz</link>
            <desc>Seznam Zprávy - nejnovější články</desc>

            <items>
                <xsl:for-each select="rss/channel/item[position() &lt; 6]">
                    <item>
                        <title><xsl:value-of select="title" /></title>
                        <link><xsl:value-of select="link" /></link>
                        <desc><xsl:value-of select="description" /></desc>
                        <image><xsl:value-of select="szn:image/szn:url" /></image>
                        <pubDate><xsl:value-of select="pubDate" /></pubDate>
                    </item>
                </xsl:for-each>
            </items>
        </rss>

    </xsl:template>

</xsl:stylesheet>



