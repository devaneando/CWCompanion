<?php

namespace App\Admin\Type;

use App\Admin\Type\Traits\LocaleTrait;
use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarkDownType extends SymfonyAbstractType
{
    use LocaleTrait;

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'class'=>'form-control markdown',
                'data-language'=>$this->getLocale(),
                'rows'=>5,
                'data-provide'=>'markdown',
            ],
            'choice_translation_domain' => 'messages',
            'rows' => 5,
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['attr']['rows'] = $options['rows'];
        $view->vars['rows'] = $options['rows'];
        $view->vars['attr'] = $options['attr'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['attr']['rows'] = $options['rows'];
        $builder
            ->setAttribute('rows', $options['rows'])
            ->setAttribute('attr', $options['attr']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'markdown';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextareaType::class;
    }
}
