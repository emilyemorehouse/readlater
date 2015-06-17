<?php

namespace AppBundle\Twig;

/**
 * Class Extension
 *
 * @package AppBundle\Twig
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class Extension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('filemtime', array($this, 'getFilemtime')),
        );
    }

    public function getFunctions()
    {
        return array(
            'timestamp' => new \Twig_Function_Method($this, 'getTimestamp'),
            'browserWidget' => new \Twig_Function_Method($this, 'browserWidget'),
        );
    }

    public function getFilemtime($filename)
    {
        if (@file_exists($filename)) {
            return @filemtime($filename);
        } else {
            return $this->getTimestamp();
        }
    }

    public function getTimestamp()
    {
        return time();
    }

    public function browserWidget($uri)
    {
        return 'javascript:(function () {l = "'.$uri.'?url="+encodeURIComponent(window.location.href)+"&title="+encodeURIComponent(document.title)+"&nowindow=1";var e = window.open(l,"readlater","location=0,links=0,scrollbars=0,toolbar=0,width=600,height=485");})();';
    }

    public function getName()
    {
        return 'twig_extension';
    }
}
