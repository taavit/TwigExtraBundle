<?php

namespace Taavit\TwigExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $builder->root('taavit_twig_extra')->end();
        return $builder;
    }
}
