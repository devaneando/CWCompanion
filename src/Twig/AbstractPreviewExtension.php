<?php

namespace App\Twig;

use App\Entity\Chapter;
use App\Entity\Character;
use App\Entity\Concept;
use App\Entity\KeyItem;
use App\Entity\Location;
use App\Entity\Project;
use App\Entity\Scene;
use App\Traits\ConstantValidationTrait;
use Proxies\__CG__\App\Entity\Chapter as ProxiesChapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\DataCollectorTranslator;

class AbstractPreviewExtension extends \Twig_Extension
{
    const TYPE_HTML = 'html';
    const TYPE_MARKDOWN = 'markdown';

    use ConstantValidationTrait;

    /** @var DataCollectorTranslator $translator */
    private $translator;

    /** @var RouterInterface $router */
    private $router;

    public function getTranslator(): DataCollectorTranslator
    {
        return $this->translator;
    }

    public function setTranslator(DataCollectorTranslator $translator): self
    {
        $this->translator = $translator;

        return $this;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    public function setRouter(RouterInterface $router): self
    {
        $this->router = $router;

        return $this;
    }

    /** @throws NotFoundHttpException */
    protected function generatePreviewRoute($object, string $type = self::TYPE_HTML): string
    {
        $base = trim(strtolower((new \ReflectionClass(get_class($object)))->getShortName()));
        $route = null;
        if (true === in_array($base, ['project', 'chapter', 'scene'])) {
            $route = 'project_' . $base . '_preview';
        } elseif (true === in_array($base, ['character', 'concept', 'keyItem', 'location'])) {
            $route = 'writing_' . $base . '_preview';
        } elseif ('keyitem' === $base) {
            $route = 'writing_key_item_preview';
        }
        if (null === $route) {
            throw new NotFoundHttpException('No route found for the given object [' . $base . '].');
        }

        return $this->router->generate($route, ['id' => $object->getId(), 'type' => $type], RouterInterface::ABSOLUTE_URL);
    }
}
