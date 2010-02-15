<?php
namespace ComplexPie\Atom10\Content;

class Link extends \ComplexPie\Content\IRI
{
    protected $rel;
    protected $type;
    protected $hreflang;
    protected $title;
    protected $length;
    
    public function __construct($node)
    {
        $iriref = new \ComplexPie\IRI($node->getAttribute('href'));
        if ($iri = \ComplexPie\IRI::absolutize($node->baseURI, $iriref))
            $iriref = $iri;
        
        parent::__construct($iriref);
        
        if ($node->hasAttribute('rel'))
        {
            $rel = $node->getAttribute('rel');
            if (strpos($rel, ':') === false)
            {
                $rel = 'http://www.iana.org/assignments/relation/' . $rel;
            }
            $this->rel = new \ComplexPie\Content\String($rel);
        }
        
        if ($node->hasAttribute('type'))
        {
            $type = $node->getAttribute('type');
            $this->type = new \ComplexPie\Content\String($type);
        }
        
        if ($node->hasAttribute('hreflang'))
        {
            $hreflang = $node->getAttribute('hreflang');
            $this->hreflang = new \ComplexPie\Content\String($hreflang);
        }
        
        if ($node->hasAttribute('title'))
        {
            $title = $node->getAttribute('title');
            $this->title = new \ComplexPie\Content\String($title);
        }
        
        if ($node->hasAttribute('length'))
        {
            $length = $node->getAttribute('length');
            $this->type = new \ComplexPie\Content\String($length);
        }
    }
    
    public function __get($name)
    {
        if (
            $name === 'rel' ||
            $name === 'type' ||
            $name === 'hreflang' ||
            $name === 'title' ||
            $name === 'length'
        )
        {
            return $this->$name;
        }
    }
}
