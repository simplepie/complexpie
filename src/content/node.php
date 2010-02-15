<?php
namespace ComplexPie\Content;

class Node extends \ComplexPie\Content
{
    public static $replaceURLAttributes = array(
        'a' => array('href'),
        'area' => array('href'),
        'blockquote' => array('cite'),
        'del' => array('cite'),
        'form' => array('action'),
        'img' => array('longdesc', 'src'),
        'input' => array('src'),
        'ins' => array('cite'),
        'q' => array('cite')
    );
    
    protected $nodes = array();
    protected $document;
    
    public function __construct($nodes)
    {
        foreach ($nodes as $node)
            $this->nodes[] = $node;
        
        $this->document = $this->nodes[0] instanceof \DOMDocument ? $this->nodes[0] : $this->nodes[0]->ownerDocument;
        $this->replaceURLs();
    }
    
    protected function replaceURLs()
    {
        $replaceURLAttributes = self::$replaceURLAttributes;
        $xpath = new \DOMXPath($this->document);
        foreach ($this->nodes as $node)
        {
            // Although this is implied by the XPath query, it's quicker to
            // check this explicitly here.
            if ($node->nodeType === XML_ELEMENT_NODE)
            {
                $children = $xpath->query('descendant-or-self::*', $node);
                foreach ($children as $child)
                {
                    if (isset($replaceURLAttributes[$child->tagName]))
                    {
                        foreach ($replaceURLAttributes[$child->tagName] as $attribute)
                        {
                            if ($child->hasAttribute($attribute))
                            {
                                $newValue = \ComplexPie\IRI::absolutize($child->baseURI, $child->getAttribute($attribute));
                                if ($newValue)
                                {
                                    $child->setAttribute($attribute, $newValue->iri);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function get_node()
    {
        return $this->nodes;
    }
    
    public function to_text()
    {
        $text = '';
        foreach ($this->nodes as $node)
        {
            $text .= $node->textContent;
        }
        return $text;
    }
    
    public function to_xml()
    {
        $xml = '';
        foreach ($this->nodes as $node)
        {
            $xml .= $this->document->saveXML($node);
        }
        return $xml;
    }
    
    public function to_html()
    {
        // Check if http://bugs.php.net/?id=50973 is fixed
        static $usefulSaveHTML;
        if ($usefulSaveHTML === null)
        {
            $dom = new \DOMDocument;
            $el = $dom->createElement('div');
            $usefulSaveHTML = substr(@$dom->saveHTML($el), 0, 4) === '<div';
        }
        
        $html = '';
        
        if ($usefulSaveHTML)
        {
            foreach ($this->nodes as $node)
            {
                $html .= $this->document->saveHTML($node);
            }
        }
        else
        {
            foreach ($this->nodes as $node)
            {
                $html .= \ComplexPie\nodeToHTML($node);
            }
        }
        
        return $html;
    }
}
