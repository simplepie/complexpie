<?php

class SimplePie_First_Item_Title_Test_RSS_091_Netscape_Atom_10_Title extends SimplePie_First_Item_Title_Test
{
    function data()
    {
        $this->data = 
'<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
    <channel>
        <item>
            <a:title>Item Title</a:title>
        </item>
    </channel>
</rss>';
    }
    
    function expected()
    {
        $this->expected = 'Item Title';
    }
}

?>