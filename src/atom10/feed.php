<?php
namespace ComplexPie\Atom10;

class Feed extends \ComplexPie\XML\Feed
{
    protected static $static_ext = array();

    protected static $aliases = array(
        'description' => 'subtitle',
        'tagline' => 'subtitle',
        'copyright' => 'rights',
    );
    
    protected static $elements = array(
        'authors' => array(
            'element' => 'atom:author',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Person',
            'single' => false
        ),
        'categories' => array(
            'element' => 'atom:category',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Category',
            'single' => false
        ),
        'contributors' => array(
            'element' => 'atom:contributor',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Person',
            'single' => false
        ),
        // XXX: generator
        'icon' => array(
            'element' => 'atom:icon',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'id' => array(
            'element' => 'atom:id',
            // Yes, not an IRI. atom:id is an opaque non-normalizable IRI,
            // which is nothing more than an opaque string.
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        // link is special cased, see below in __invoke.
        'logo' => array(
            'element' => 'atom:logo',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'rights' => array(
            'element' => 'atom:rights',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'subtitle' => array(
            'element' => 'atom:subtitle',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'title' => array(
            'element' => 'atom:title',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'updated' => array(
            'element' => 'atom:updated',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
    );
    
    protected static $element_namespaces = array(
        'atom' => XMLNS,
    );
    
    protected function entries($dom, $name)
    {
        if ($name === 'entries' || $name === 'items')
        {
            $nodes = \ComplexPie\Misc::xpath($dom, 'atom:entry', self::$element_namespaces);
            if ($nodes->length !== 0)
            {
                $return = array();
                foreach ($nodes as $node)
                {
                    $tree = $this->data['child'][XMLNS]['feed'][0]['child'][XMLNS]['entry'][count($return)];
                    $return[] = new Entry($this, $tree, $node);
                }
                return $return;
            }
        }
    }
    
    public function __construct()
    {
        $args = func_get_args();
        call_user_func_array(array($this, 'parent::__construct'), $args);
        $this->add_extension('get', array($this, 'entries'), ~PHP_INT_MAX);
    }
}

Feed::add_static_extension('get', '\\ComplexPie\\Atom10\\links', ~PHP_INT_MAX);
