<?php

class SimplePie_First_Item_Title_Test_RSS_20_Title_1 extends SimplePie_First_Item_Title_Test
{
    function data()
    {
        $this->data = 
'<rss version="2.0">
    <channel>
        <item>
            <title>This &amp;amp; this</title>
        </item>
    </channel>
</rss>';
    }
    
    function expected()
    {
        $this->expected = 'This &amp; this';
    }
}

?>