<?php
namespace Taavit\TwigExtraBundle\Tests;

use Taavit\TwigExtraBundle\Twig\Extension\DateExtension;
use Symfony\Component\Translation\Translator;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function testPrettifyFuture()
    {
        $translator = new Translator();
        $extension = new DateExtension($translator);
        $result = $extension->prettify(new \DateTime(0));
        $this->assert($result, '');
    }
}
