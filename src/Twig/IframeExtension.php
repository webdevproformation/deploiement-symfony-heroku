<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use RicardoFiorani\Matcher\VideoServiceMatcher;

class IframeExtension extends AbstractExtension
{
    private $vsm ;

    public function __construct()
    {
        $this->vsm = new VideoServiceMatcher();
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('iframe_youtube', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSomething(string $url):string
    {
        $video = $this->vsm->parse($url);
        return $video->getEmbedCode("100%", 380, true, true);
    }
}
