<xsl:stylesheet
        xmlns:atom="http://www.w3.org/2005/Atom"
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        version="2.0"
>

    <xsl:template match="/">
        <rss>
            <title>REFRESHER.cz | Hudba, Moda, Lifestyle | RSS</title>
            <link>https://refresher.cz/</link>
            <desc>
                Refresher.cz - novinky ze světa hudební scény, módní trendy, lifestyle, technika, filmy, seriály. Buď FRESH!
            </desc>
            <items>
                <xsl:for-each select="rss/channel/item[position() &lt; 6]">
                    <item>
                        <title><xsl:value-of select="title" /></title>
                        <link><xsl:value-of select="link" /></link>
                        <desc><xsl:value-of select="description" /></desc>
                        <image><xsl:value-of select="enclosure/@url" /></image>
                        <pubDate><xsl:value-of select="pubDate" /></pubDate>
                    </item>
                </xsl:for-each>
            </items>
        </rss>
    </xsl:template>

</xsl:stylesheet>