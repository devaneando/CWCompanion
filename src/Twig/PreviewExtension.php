<?php

namespace App\Twig;

use App\Traits\Services\TranslatorTrait;
use Symfony\Component\Routing\RouterInterface;

class PreviewExtension extends \Twig_Extension
{
    use TranslatorTrait;

    /** @var RouterInterface $router */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            'the_parent' => new \Twig_Function('the_parent', [$this, 'getParent'], ['needs_context' => false]),
            'the_children' => new \Twig_Function('the_children', [$this, 'getChildren'], ['needs_context' => false]),
        ];
    }

    public function getParent($object, $type = 'html'): string
    {
        if (false === method_exists($object, 'getParent')) {
            return '';
        }

        if (true === empty($object->getParent())) {
            return '';
        }

        $route = 'writing_'.strtolower((new \ReflectionClass(get_class($object)))->getShortName()).'_preview';

        if ('markdown' === trim($type)) {
            return sprintf(
                '[%s](%s)',
                $object->getParent()->getName(),
                $this->router->generate($route, ['id' => $object->getParent()->getId()])
            );
        }

        return sprintf(
            '<a href="%s" target="_blank" alt="%s">%s</a>',
            $this->router->generate($route, ['id' => $object->getParent()->getId()]),
            $object->getParent()->getName(),
            $object->getParent()->getName()
        );
    }

    public function getChildren($object, $type = 'html'): string
    {
        if (false === method_exists($object, 'getChildren')) {
            return '';
        }

        if (true === empty($object->getChildren())) {
            return '';
        }

        if ('markdown' === trim($type)) {
            $result = '';
            foreach ($object->getChildren() as $child) {
                $route = 'writing_'.strtolower((new \ReflectionClass(get_class($child)))->getShortName()).'_preview';

                $result .= sprintf(
                    "- [%s](%s)\n",
                    $child->getName(),
                    $this->router->generate($route, ['id' => $child->getId()])
                );
            }

            return $result;
        }

        $result = '<ul>';
        foreach ($object->getChildren() as $child) {
            $route = 'writing_'.strtolower((new \ReflectionClass(get_class($child)))->getShortName()).'_preview';

            $result .= sprintf(
                '<li><a href="%s" target="_blank" alt="%s">%s</a></li>',
                $this->router->generate($route, ['id' => $child->getId()]),
                $child->getName(),
                $child->getName()
            );
        }
        $result .= '</ul>';

        return $result;
    }
}
