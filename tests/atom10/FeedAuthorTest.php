<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedAuthorTest extends PHPUnit_Framework_TestCase
{
    public function nameData()
    {
        return array(
            array(
                'Foobar',
                '<name>Foobar</name>',
            ),
            array(
                'Foobar',
                '<name xmlns="http://example.com">FAIL</name><name>Foobar</name>',
            ),
            array(
                'Foobar',
                '<name>Foobar</name><name xmlns="http://example.com">FAIL</name>',
            ),
            array(
                'Foo&bar',
                '<name>Foo&amp;bar</name>',
            ),
            array(
                'Foo&amp;bar',
                '<name>Foo&amp;amp;bar</name>',
            ),
            array(
                '<span>Foobar</span>',
                '<name>&lt;span>Foobar&lt;/span></name>',
            ),
            array(
                null,
                '',
            ),
        );
    }
    
    /**
     * @dataProvider nameData
     */
    public function testName($expected, $input)
    {
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><author>%s</author></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($person) = $feed->author;
        if ($expected !== null)
        {
            $this->assertSame($expected, $person->name->to_text());
        }
        else
        {
            $this->assertSame($expected, $person->name);
        }
    }
    
    public function uriData()
    {
        return array(
            array(
                'http://example.com',
                '<uri>http://example.com</uri>',
            ),
            array(
                'http://example.com',
                '<uri xml:base="http://example.com">/</uri>',
            ),
            array(
                'http://example.com?foo&bar',
                '<uri>http://example.com?foo&amp;bar</uri>',
            ),
            array(
                '/',
                '<uri>/</uri>',
            ),
            array(
                null,
                '',
            ),
        );
    }
    
    /**
     * @dataProvider uriData
     */
    public function testUri($expected, $input)
    {
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><author>%s</author></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($person) = $feed->author;
        if ($expected !== null)
        {
            $this->assertSame($expected, $person->uri->to_text());
        }
        else
        {
            $this->assertSame($expected, $person->uri);
        }
    }
    
    public function emailData()
    {
        return array(
            array(
                'foobar@example.com',
                '<email>foobar@example.com</email>',
            ),
            array(
                'Invalid bogus string',
                '<email>Invalid bogus string</email>',
            ),
            array(
                'Foo&bar',
                '<email>Foo&amp;bar</email>',
            ),
            array(
                'Foo&amp;bar',
                '<email>Foo&amp;amp;bar</email>',
            ),
            array(
                '<span>Foobar</span>',
                '<email>&lt;span>Foobar&lt;/span></email>',
            ),
            array(
                null,
                '',
            ),
        );
    }
    
    /**
     * @dataProvider emailData
     */
    public function testEmail($expected, $input)
    {
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><author>%s</author></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($person) = $feed->author;
        if ($expected !== null)
        {
            $this->assertSame($expected, $person->email->to_text());
        }
        else
        {
            $this->assertSame($expected, $person->email);
        }
    }
}

?>
