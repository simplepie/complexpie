<?php

class SimplePie_Feed_Image_Link_Test_RSS_090_Link extends SimplePie_Feed_Image_Link_Test
{
    function data()
    {
        $this->data = 
'<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/">
    <image>
        <link>http://example.com/</link>
    </image>
</rdf:RDF>';
    }
    
    function expected()
    {
        $this->expected = 'http://example.com';
    }
}

?>