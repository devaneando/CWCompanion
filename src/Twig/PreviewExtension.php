<?php

namespace App\Twig;

use App\Twig\AbstractPreviewExtension;

class PreviewExtension extends AbstractPreviewExtension
{
    public function getFunctions(): array
    {
        return [
            'the_title' => new \Twig_Function('the_title', [$this, 'getTitle'], ['needs_context' => true]),
            'the_parent' => new \Twig_Function('the_parent', [$this, 'getParent'], ['needs_context' => false]),
            'the_children' => new \Twig_Function('the_children', [$this, 'getChildren'], ['needs_context' => false]),
        ];
    }

    public function getTitle($context, string $title): string
    {
        $icons = [
            'beliefs_and_spirituality' => 'fas fa-pray',
            'characters' => 'fas fa-theater-masks',
            'content' => 'fas fa-file-signature',
            'derivations' => 'fas fa-code-branch',
            'description' => 'fas fa-comment-alt',
            'emotional_characteristics' => 'fas fa-heartbeat',
            'family_relationships' => 'fas fa-baby',
            'history' => 'fas fa-history',
            'inherited_characteristics' => 'fas fa-compress-arrows-alt',
            'intellectual_characteristics' => 'fas fa-brain',
            'key_items' => 'fas fa-key',
            'lifestyle' => 'fas fa-tshirt',
            'locations' => 'fas fa-globe-americas',
            'notes' => 'fas fa-file-signature',
            'personal_history' => 'fas fa-user-secret',
            'relations' => 'fas fa-code-branch',
            'scenes' => 'fas fa-code-branch',
        ];

        if (false === array_key_exists($title, $icons)) {
            return '';
        }

        return sprintf(
            '<i class="%s"></i> %s',
            $icons[$title],
            $this->getTranslator()->trans('title.'.$title, [], $context['trans_default_domain'])
        );
    }

    protected function getParentAsMarkdown($object): string
    {
        if (false === method_exists($object, 'getParent')) {
            return '';
        }

        if (true === empty($object->getParent())) {
            return '';
        }

        return sprintf(
            '[%s](%s)',
            $object->getParent()->getName(),
            $this->generatePreviewRoute($object->getParent(), self::TYPE_MARKDOWN)
        );
    }

    public function getParent($object, $type = self::TYPE_HTML): string
    {
        if (false === method_exists($object, 'getParent')) {
            return '';
        }

        if (true === empty($object->getParent())) {
            return '';
        }

        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getParentAsMarkdown($object);
        }

        return sprintf(
            '<a href="%s" target="_blank" alt="%s">%s</a>',
            $this->generatePreviewRoute($object),
            $object->getParent()->getName(),
            $object->getParent()->getName()
        );
    }

    protected function getChildrenAsMarkdown($object): string
    {
        if (false === method_exists($object, 'getChildren')) {
            return '';
        }

        if (true === empty($object->getChildren())) {
            return '';
        }

        $result = '';
        foreach ($object->getChildren() as $child) {
            $result .= sprintf(
                "- [%s](%s)\n",
                $child->getName(),
                $this->generatePreviewRoute($child, self::TYPE_MARKDOWN)
            );
        }

        return $result;
    }

    public function getChildren($object, $type = self::TYPE_HTML): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getChildrenAsMarkdown($object);
        }

        if (false === method_exists($object, 'getChildren')) {
            return '';
        }

        if (true === empty($object->getChildren())) {
            return '';
        }

        $result = '<ul>';
        foreach ($object->getChildren() as $child) {
            $result .= sprintf(
                '<li><a href="%s" target="_blank" alt="%s">%s</a></li>',
                $this->generatePreviewRoute($child),
                $child->getName(),
                $child->getName()
            );
        }
        $result .= '</ul>';

        return $result;
    }
}
