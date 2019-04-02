<?php

namespace App\Twig;

use App\Entity\Chapter;
use App\Entity\KeyItem;
use App\Entity\Location;
use App\Entity\Project;
use App\Entity\Scene;
use App\Twig\AbstractPreviewExtension;

class SceneExtension extends AbstractPreviewExtension
{
    public function getFunctions(): array
    {
        return [
            'the_scene_name' => new \Twig_Function('the_scene_name', [$this, 'getSceneName'], ['needs_context' => false]),
            'the_scene' => new \Twig_Function('the_scene', [$this, 'getScene'], ['needs_context' => false]),
            'the_scenes' => new \Twig_Function('the_scenes', [$this, 'getScenes'], ['needs_context' => false]),
            'the_chapter' => new \Twig_Function('the_chapter', [$this, 'getChapter'], ['needs_context' => false]),
            'the_project' => new \Twig_Function('the_project', [$this, 'getProject'], ['needs_context' => false]),
            'the_location' => new \Twig_Function('the_location', [$this, 'getLocation'], ['needs_context' => false]),
            'the_key_items' => new \Twig_Function('the_key_items', [$this, 'getKeyItems'], ['needs_context' => false]),

        ];
    }

    protected function getSceneNameAsMarkdown(Scene $scene): string
    {
        return sprintf(
            '%s %03d -- %s -- %s',
            $this->getTranslator()->trans('admin.label.scene', [], 'scene'),
            $scene->getScene(),
            $this->getTranslator()->trans('ambient.'.$scene->getAmbient(), [], 'scene'),
            $this->getTranslator()->trans('time.'.$scene->getTime(), [], 'scene')
        );
    }

    public function getSceneName(Scene $scene, $type = self::TYPE_HTML): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getSceneNameAsMarkdown($scene);
        }

        return sprintf(
            '%s %03d &mdash; %s &mdash; %s',
            $this->getTranslator()->trans('admin.label.scene', [], 'scene'),
            $scene->getScene(),
            $this->getTranslator()->trans('ambient.'.$scene->getAmbient(), [], 'scene'),
            $this->getTranslator()->trans('time.'.$scene->getTime(), [], 'scene')
        );
    }

    protected function getSceneAsMarkdown(Scene $scene): string
    {
        return sprintf(
            '[%s](%s)',
            $this->getSceneNameAsMarkdown($scene),
            $this->generatePreviewRoute($scene, self::TYPE_MARKDOWN)
        );
    }

    public function getScene(Scene $scene, $type = self::TYPE_HTML, string $class=''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getSceneAsMarkdown($scene);
        }

        return sprintf(
            '<a class="%s" href="%s" target="_blank" alt="%s">%s</a>',
            $class,
            $this->generatePreviewRoute($scene),
            $this->getSceneNameAsMarkdown($scene),
            $this->getSceneNameAsMarkdown($scene)
        );
    }

    protected function getScenesAsMarkdown($object): string
    {
        if (false === method_exists($object, 'getScenes')) {
            return '';
        }

        if (true === empty($object->getScenes())) {
            return '';
        }

        $list = '';
        foreach ($object->getScenes() as $scene) {
            $list .= sprintf("- %s\n", $this->getSceneAsMarkdown($scene));
        }
        if (true === empty($list)) {
            $this->getTranslator()->trans('text.no_scene', [], 'scene');
        }

        return $list;
    }

    public function getScenes($object, $type = self::TYPE_HTML): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getScenesAsMarkdown($object);
        }

        if (false === method_exists($object, 'getScenes')) {
            return '';
        }

        if (true === empty($object->getScenes())) {
            return '';
        }

        $list = '';
        foreach ($object->getScenes() as $scene) {
            $list .= sprintf("    <li>%s</li>\n", $this->getScene($scene));
        }
        if (true === empty($list)) {
            $this->getTranslator()->trans('text.no_scene', [], 'scene');
        }

        return "<ul>\n".$list."</ul>\n";
    }

    protected function getChapterAsMarkdown(?Chapter $chapter): string
    {
        if (true === empty($chapter)) {
            return '';
        }

        return sprintf(
            '[%s](%s)',
            $chapter->getName(),
            $this->generatePreviewRoute($chapter, self::TYPE_MARKDOWN)
        );
    }

    public function getChapter(?Chapter $chapter, $type = self::TYPE_HTML, string $class = ''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getChapterAsMarkdown($chapter);
        }
        if (true === empty($chapter)) {
            return '';
        }

        return sprintf(
            '<a class="%s" href="%s" target="_blank" alt="%s">%s</a>',
            $class,
            $this->generatePreviewRoute($chapter),
            $chapter->getName(),
            $chapter->getName()
        );
    }

    protected function getProjectAsMarkdown(?Project $project): string
    {
        if (true === empty($project)) {
            return '';
        }

        return sprintf(
            '[%s](%s)',
            $project->getName(),
            $this->generatePreviewRoute($project, self::TYPE_MARKDOWN)
        );
    }

    public function getProject(?Project $project, $type = self::TYPE_HTML, string $class = ''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getProjectAsMarkdown($project);
        }
        if (true === empty($project)) {
            return '';
        }

        return sprintf(
            '<a class="%s"href="%s" target="_blank" alt="%s">%s</a>',
            $class,
            $this->generatePreviewRoute($project),
            $project->getName(),
            $project->getName()
        );
    }

    protected function getLocationAsMarkdown(?Location $location): string
    {
        if (true === empty($location)) {
            return '';
        }

        return sprintf(
            '[%s](%s)',
            $location->getName(),
            $this->generatePreviewRoute($location, self::TYPE_MARKDOWN)
        );
    }

    public function getLocation(?Location $location, $type = self::TYPE_HTML, string $class = ''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getLocationAsMarkdown($location);
        }

        if (true === empty($location)) {
            return '';
        }

        return sprintf(
            '<a class="%s"href="%s" target="_blank" alt="%s">%s</a>',
            $class,
            $this->generatePreviewRoute($location),
            $location->getName(),
            $location->getName()
        );
    }

    protected function getKeyItemAsMarkdown(KeyItem $keyItem): string
    {
        return sprintf(
            '[%s](%s)',
            $keyItem->getName(),
            $this->generatePreviewRoute($keyItem, self::TYPE_MARKDOWN)
        );
    }

    public function getKeyItem(KeyItem $keyItem, $type = self::TYPE_HTML, string $class=''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getKeyItemAsMarkdown($keyItem);
        }

        return sprintf(
            '<a class="%s" href="%s" target="_blank" alt="%s">%s</a>',
            $class,
            $this->generatePreviewRoute($keyItem),
            $keyItem->getName(),
            $keyItem->getName()
        );
    }

    protected function getKeyItemsAsMarkdown($object): string
    {
        if (false === method_exists($object, 'getKeyItems')) {
            return '';
        }

        if (true === empty($object->getKeyItems())) {
            return '';
        }

        $list = '';
        foreach ($object->getKeyItems() as $keyitem) {
            $list .= sprintf("- %s\n", $this->getKeyItemAsMarkdown($keyitem));
        }
        if (true === empty($list)) {
            $list = $this->getTranslator()->trans('text.no_key_item', [], 'scene');
        }

        return $list;
    }

    public function getKeyItems($object, $type = self::TYPE_HTML): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getKeyItemsAsMarkdown($object);
        }

        if (false === method_exists($object, 'getKeyItems')) {
            return '';
        }

        if (true === empty($object->getKeyItems())) {
            return '';
        }

        $list = '';
        foreach ($object->getKeyItems() as $keyItem) {
            $list .= sprintf("    <li>%s</li>\n", $this->getKeyItem($keyItem));
        }
        if (true === empty($list)) {
            $list = $this->getTranslator()->trans('text.no_key_item', [], 'scene');
        }

        return "<ul>\n".$list."</ul>\n";
    }
}
