<?php
namespace Taavit\TwigExtraBundle\Twig\Extension;

use Symfony\Component\Translation\Translator;

use Twig_Extension;
use Twig_Filter_Method;

/**
 * @author Dawid Królak <taavit@gmail.com>
 *
 */
class UrlExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            'makeUrl' => new Twig_Filter_Method($this, 'makeUrl'),
        );
    }

    public function makeUrl($url)
    {
        if (!$url) {
            return null;
        }
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://$url";
        }
        return $url;
    }

    public function getName()
    {
        return 'url_extension';
    }
}

