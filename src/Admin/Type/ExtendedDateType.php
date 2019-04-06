<?php

namespace App\Admin\Type;

use App\Admin\Mapper\ExtendedDateMapper;
use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/** @ignore check https://symfony.com/doc/current/form/form_customization.html */
class ExtendedDateType extends SymfonyAbstractType
{
    /** @var string */
    protected $transDomain = 'messages';

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dayData = [];
        $dayData[$this->translator->trans('day.none', [], $this->transDomain)] = null;
        for ($i=1; $i <= 31; ++$i) {
            $dayData[sprintf('%02d', $i)] = $i;
        }
        $options['form_type'] = 'horizontal';
        $builder
            ->add('anno_domini', CheckboxType::class, [
                'empty_data' => null,
                'required' => false,
                'attr' => ['class' => 'form-inline'],
                'label' => $this->translator->trans('extended_date.anno_domini', [], $this->transDomain),
                'translation_domain' => false,
            ])
            ->add('year', TextType::class, [
                'empty_data' => null,
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'form-inline', 'placeholder' => $this->translator->trans('year', [], $this->transDomain)],
                'translation_domain' => false,
            ])
            ->add('month', ChoiceType::class, [
                'empty_data' => null,
                'choice_translation_domain' => false,
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'form-inline'],
                'choices' => [
                    $this->translator->trans('month.none', [], $this->transDomain)=> null,
                    $this->translator->trans('month.january', [], $this->transDomain)=> 1,
                    $this->translator->trans('month.february', [], $this->transDomain)=> 2,
                    $this->translator->trans('month.march', [], $this->transDomain)=> 3,
                    $this->translator->trans('month.april', [], $this->transDomain)=> 4,
                    $this->translator->trans('month.may', [], $this->transDomain)=> 5,
                    $this->translator->trans('month.june', [], $this->transDomain)=> 6,
                    $this->translator->trans('month.july', [], $this->transDomain)=> 7,
                    $this->translator->trans('month.august', [], $this->transDomain)=> 8,
                    $this->translator->trans('month.september', [], $this->transDomain)=> 9,
                    $this->translator->trans('month.october', [], $this->transDomain)=> 10,
                    $this->translator->trans('month.november', [], $this->transDomain)=> 11,
                    $this->translator->trans('month.december', [], $this->transDomain)=> 12,
                ],
            ])
            ->add('day', ChoiceType::class, [
                'empty_data' => null,
                'label' => false,
                'required' => false,
                'choice_translation_domain' => false,
                'attr' => ['class' => 'form-inline'],
                'choices' => $dayData,
            ])
            ->setDataMapper(new ExtendedDateMapper());
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('empty_data', null);
    }

    /** {@inheritdoc} */
    public function getBlockPrefix()
    {
        return 'extended_date';
    }
}
