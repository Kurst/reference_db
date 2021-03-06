<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../lib/PHPRtfLite.php';

/**
 * Test class for PHPRtfLite_Font.
 * Generated by PHPUnit on 2010-04-26 at 22:19:25.
 */
class PHPRtfLite_FontTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPRtfLite_Font
     */
    protected $_font;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        // register PHPRtfLite class loader
        PHPRtfLite::registerAutoloader();
        
        $this->_font = new PHPRtfLite_Font(10);
    }


    /**
     * tests getContent().
     */
    public function testGetContent()
    {
        $this->_font->setBold();
        $this->_font->setItalic();
        $this->_font->setUnderline();
        $this->_font->setAnimation(PHPRtfLite_Font::ANIMATE_LAS_VEGAS_LIGHTS);
        $this->_font->setDoubleStriked();
        $this->assertEquals('\fs20 \b \i \ul \animtext1\striked1 1', trim($this->_font->getContent()));
    }
}
