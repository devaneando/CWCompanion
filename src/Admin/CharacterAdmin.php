<?php

declare (strict_types = 1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\ExtendedDateType;
use App\Admin\Type\MarkDownType;
use App\Admin\Type\OwnerAware\ProjectType;
use App\Admin\Type\Predefined\CharacterType;
use App\Admin\Type\Predefined\CountryType;
use App\Admin\Type\Predefined\GenderType;
use App\Admin\Type\Predefined\IntelligenceQuotientType;
use App\Admin\Type\Predefined\LocationType;
use App\Admin\Type\Predefined\ProfessionType;
use App\Admin\Type\Predefined\ReligionType;
use App\Admin\Type\Predefined\SexualityType;
use App\Admin\Type\Predefined\TemperamentType;
use App\Entity\Character;
use App\Entity\Project;
use App\Traits\LoggedUserTrait;
use App\Traits\Repository\ZodiacRepositoryTrait;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\EducationalDegree;
use App\Admin\Type\Predefined\EducationalDegreeType;

final class CharacterAdmin extends AbstractExtraActionsAdmin
{
    use ZodiacRepositoryTrait;
    use LoggedUserTrait;
    protected $baseRouteName = 'writing_character';
    protected $baseRoutePattern = 'writing/character';
    protected $translationDomain = 'character';
    protected $hasRoutePreview = true;

    public function createQuery($context = 'list')
    {
        return $this->ownerOnlyListQuery($context);
    }

    public function preUpdate($object)
    {
        /** @var Character $object */
        if (null !== $object->getBirthdate()) {
            $sign = $this->getZodiacRepository()->findSignByExtendedDate($object->getBirthdate());
            $object->setZodiacSign($sign);
        }

        if (null === $object->getUploadedPicture() && null === $object->getPicture()) {
            $object->setDefaultPicture();
        }

        if (null === $object->getOwner()) {
            $object->setOwner($this->getLoggedUser());
        }
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('nickname', null, ['label' => 'admin.label.nickname'])
            ->add('fullName', null, ['label' => 'admin.label.full_name'])
            ->add('gender', null, ['label' => 'admin.label.gender'])
            ->add('characterType', null, ['label' => 'admin.label.character_type'])
            ->add('concept', null, ['label' => 'admin.label.concept'])
            ->add('birthdate', null, ['label' => 'admin.label.birthdate']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/list/picture.html.twig',
                ]
            )
            ->add(
                'characterType',
                null,
                [
                    'label' => 'admin.label.character_type',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add('nickname', null, ['label' => 'admin.label.nickname'])
            ->add(
                'concept',
                null,
                [
                    'label' => 'admin.label.concept',
                    'template' => 'form/list/markdown.html.twig',
                    'sortable' => true,
                ]
            )
            ->add(
                'gender',
                null,
                [
                    'label' => 'admin.label.gender',
                    'template' => 'form/list/gender_symbol.html.twig',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add('birthdate', null, ['label' => 'admin.label.birthdate'])
            ->add(
                'projects',
                null,
                [
                    'label' => 'admin.label.projects',
                    'sortable' => true
                ]
            )
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'list' => ['template' => 'CRUD/list__action_preview.html.twig'],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $pictureUploadedOptions = [
            'required' => false,
            'data_class' => null,
            'label' => 'admin.label.uploaded_picture',
        ];
        if (($subject = $this->getSubject()) && $subject->getPicture()) {
            $path = $subject->getPicture();
            $pictureUploadedOptions['help'] = '<img id="member-edit-picture" src="' . $path . '" style=" max-height: 250px;"/>';
        }

        /** ----- Tab Inherited ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_inherited', ['label' => 'admin.tab.inherited'])
            ->with('in_001', ['class' => 'col-md-4', 'label' => 'admin.block.inherited.bl_001'])
            ->add('nickname', null, ['label' => 'admin.label.nickname'])
            ->add('characterType', CharacterType::class, ['label' => 'admin.label.character_type'])
            ->add('concept', null, ['label' => 'admin.label.concept'])
            ->add('gender', GenderType::class, ['label' => 'admin.label.gender'])
            ->add('fullName', null, ['label' => 'admin.label.full_name'])
            ->add(
                'birthdate',
                ExtendedDateType::class,
                [
                    'label' => 'admin.label.birthdate',
                    'required' => true,
                ]
            )
            ->add('birthCountry', CountryType::class, ['label' => 'admin.label.birth_country'])
            ->add('birthCity', null, ['label' => 'admin.label.birth_city'])
            ->add(
                'dateOfDeath',
                ExtendedDateType::class,
                [
                    'label' => 'admin.label.date_of_death',
                    'required' => false,
                ]
            )
            ->add('countryOfDeath', CountryType::class, ['label' => 'admin.label.country_of_death'])
            ->add('cityOfDeath', null, ['label' => 'admin.label.city_of_death'])
            ->add('projects', ProjectType::class, ['label' => 'admin.label.projects', 'multiple' => true, 'class' => Project::class])
            ->end()
            ->with('in_002', ['class' => 'col-md-8', 'label' => 'admin.block.inherited.bl_002'])
            ->add('uploadedPicture', FileType::class, $pictureUploadedOptions)
            ->add('generalNotes', MarkDownType::class, ['label' => 'admin.label.general_notes', 'rows' => 15])
            ->end()
            ->with('in_003', ['class' => 'col-md-12', 'label' => 'admin.block.inherited.bl_003'])
            ->add('personalHistory', MarkDownType::class, ['label' => 'admin.label.personal_history', 'rows' => 20])
            ->end()
            ->end();

        /** ----- Tab Physical ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_physical', ['label' => 'admin.tab.physical'])
            ->with('phy_001', ['class' => 'col-md-4', 'label' => 'admin.block.physical.bl_001'])
            ->add('bodyType', null, ['label' => 'admin.label.body_type'])
            ->add(
                'height',
                NumberType::class,
                [
                    'label' => 'admin.label.height',
                    'required' => false,
                    'scale' => 2,
                ]
            )
            ->add('eyes', null, ['label' => 'admin.label.eyes'])
            ->add('skin', null, ['label' => 'admin.label.skin'])
            ->add('hair', null, ['label' => 'admin.label.hair'])
            ->add('odor', null, ['label' => 'admin.label.odor'])
            ->end()
            ->with('phy_002', ['class' => 'col-md-8', 'label' => 'admin.block.physical.bl_002'])
            ->add('distinguishingMarks', MarkDownType::class, ['label' => 'admin.label.distinguishing_marks'])
            ->add('healthProblems', MarkDownType::class, ['label' => 'admin.label.health_problems'])
            ->add('speechPattern', MarkDownType::class, ['label' => 'admin.label.speech_pattern'])
            ->end()
            ->end();

        /** ----- Tab Life Style ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_life_style', ['label' => 'admin.tab.life_style'])
            ->with('lst_001', ['class' => 'col-md-4', 'label' => 'admin.block.life_style.bl_001'])
            ->add('sexuality', SexualityType::class, ['label' => 'admin.label.sexuality'])
            ->add('homeCountry', CountryType::class, ['label' => 'admin.label.home_country'])
            ->add('homeCity', null, ['label' => 'admin.label.home_city'])
            ->add('income', null, ['label' => 'admin.label.income'])
            ->add('currentOccupation', ProfessionType::class, ['label' => 'admin.label.current_occupation'])
            ->add('currentOccupationNice', null, ['label' => 'admin.label.current_occupation_nice'])
            ->end()
            ->with('lst_002', ['class' => 'col-md-8', 'label' => 'admin.block.life_style.bl_002'])
            ->add('dressStyle', MarkDownType::class, ['label' => 'admin.label.dress_style'])
            ->add('goodHabits', MarkDownType::class, ['label' => 'admin.label.good_habits'])
            ->add('badHabits', MarkDownType::class, ['label' => 'admin.label.bad_habits'])
            ->add('favoriteMusic', MarkDownType::class, ['label' => 'admin.label.favorite_music'])
            ->add('favoriteSports', MarkDownType::class, ['label' => 'admin.label.favorite_sports'])
            ->add('favoriteFood', MarkDownType::class, ['label' => 'admin.label.favorite_food'])
            ->add('hobbies', MarkDownType::class, ['label' => 'admin.label.hobbies'])
            ->end()
            ->end();

        /** ----- Tab Intelectual ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_intelectual', ['label' => 'admin.tab.intelectual'])
            ->with('int_001', ['class' => 'col-md-6', 'label' => 'admin.block.intelectual.bl_001'])
            ->add('iqLevel', IntelligenceQuotientType::class, ['label' => 'admin.label.iq_level'])
            ->add('educationalLevel', EducationalDegreeType::class, ['label' => 'admin.label.educational_level'])
            ->add('skills', MarkDownType::class, ['label' => 'admin.label.skills'])
            ->add('personality', MarkDownType::class, ['label' => 'admin.label.personality'])
            ->end()
            ->with('int_002', ['class' => 'col-md-6', 'label' => 'admin.block.intelectual.bl_002'])
            ->add('dominantTemperament', TemperamentType::class, ['label' => 'admin.label.dominant_temperament'])
            ->add('secondaryTemperament', TemperamentType::class, ['label' => 'admin.label.secondary_temperament'])
            ->add('selfView', MarkDownType::class, ['label' => 'admin.label.self_view'])
            ->add('whatWouldChange', MarkDownType::class, ['label' => 'admin.label.what_would_change'])
            ->end()
            ->end();

        /** ----- Tab Emotional ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_emotional', ['label' => 'admin.tab.emotional'])
            ->with('emo_001', ['class' => 'col-md-12', 'label' => 'admin.block.emotional.bl_001'])
            ->add('emotionalTraumas', MarkDownType::class, ['label' => 'admin.label.emotional_traumas'])
            ->add('deepestSecret', MarkDownType::class, ['label' => 'admin.label.deepest_secret'])
            ->add('whatMotivates', MarkDownType::class, ['label' => 'admin.label.what_motivates'])
            ->add('whatMakesHappy', MarkDownType::class, ['label' => 'admin.label.what_makes_happy'])
            ->add('whatFrightens', MarkDownType::class, ['label' => 'admin.label.what_frightens'])
            ->end()
            /** end group #013 */
            ->end();

        /** ----- Tab Spiritual ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_spiritual', ['label' => 'admin.tab.spiritual'])
            ->with('spi_001', ['class' => 'col-md-12', 'label' => 'admin.block.spiritual.bl_001'])
            ->add('religion', ReligionType::class, ['label' => 'admin.label.religion'])
            ->add('religious', null, ['label' => 'admin.label.religious'])
            ->add('spiritualBeliefs', MarkDownType::class, ['label' => 'admin.label.spiritual_beliefs'])
            ->add('spiritualEffectsInLife', MarkDownType::class, ['label' => 'admin.label.spiritual_effects_in_life'])
            ->end()
            ->end();

        /** ----- Tab Relationship ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_relationship', ['label' => 'admin.tab.relationship'])
            ->with('rel_001', ['class' => 'col-md-12', 'label' => 'admin.block.relationship.bl_001'])
            ->add('parents', MarkDownType::class, ['label' => 'admin.label.parents'])
            ->add('siblings', MarkDownType::class, ['label' => 'admin.label.siblings'])
            ->add('children', MarkDownType::class, ['label' => 'admin.label.children'])
            ->add('spouse', MarkDownType::class, ['label' => 'admin.label.spouse'])
            ->add('friends', MarkDownType::class, ['label' => 'admin.label.friends'])
            ->add('enemies', MarkDownType::class, ['label' => 'admin.label.enemies'])
            ->add('significantOthers', MarkDownType::class, ['label' => 'admin.label.significant_others'])
            ->end()
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        /** ----- Tab Inherited ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_inherited', ['label' => 'admin.tab.inherited'])
            ->with('in_001', ['class' => 'col-md-4', 'label' => 'admin.block.inherited.bl_001'])
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('nickname', null, ['label' => 'admin.label.nickname'])
            ->add('characterType', null, ['label' => 'admin.label.character_type', 'route' => ['name' => 'show']])
            ->add('concept', null, ['label' => 'admin.label.concept'])
            ->add('gender', null, ['label' => 'admin.label.gender', 'route' => ['name' => 'show']])
            ->add('fullName', null, ['label' => 'admin.label.full_name'])
            ->add('birthdate', null, ['label' => 'admin.label.birthdate'])
            ->add('birthCountry', null, ['label' => 'admin.label.birth_country', 'route' => ['name' => 'show']])
            ->add('birthCity', null, ['label' => 'admin.label.birth_city'])
            ->add('dateOfDeath', null, ['label' => 'admin.label.date_of_death'])
            ->add('countryOfDeath', null, ['label' => 'admin.label.country_of_death', 'route' => ['name' => 'show']])
            ->add('cityOfDeath', null, ['label' => 'admin.label.city_of_death'])
            ->add('projects', null, ['label' => 'admin.label.projects', 'route' => ['name' => 'show']])
            ->end()
            ->with('in_002', ['class' => 'col-md-8', 'label' => 'admin.block.inherited.bl_002'])
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/show/picture.html.twig',
                ]
            )
            ->add(
                'generalNotes',
                null,
                [
                    'label' => 'admin.label.general_notes',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->with('in_003', ['class' => 'col-md-12', 'label' => 'admin.block.inherited.bl_003'])
            ->add(
                'personalHistory',
                null,
                [
                    'label' => 'admin.label.personal_history',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();

        /** ----- Tab Physical ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_physical', ['label' => 'admin.tab.physical'])
            ->with('phy_001', ['class' => 'col-md-4', 'label' => 'admin.block.physical.bl_001'])
            ->add('bodyType', null, ['label' => 'admin.label.body_type'])
            ->add('height', null, ['label' => 'admin.label.height'])
            ->add(
                'eyes',
                null,
                [
                    'label' => 'admin.label.eyes',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'skin',
                null,
                [
                    'label' => 'admin.label.skin',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'hair',
                null,
                [
                    'label' => 'admin.label.hair',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'odor',
                null,
                [
                    'label' => 'admin.label.odor',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->with('phy_002', ['class' => 'col-md-8', 'label' => 'admin.block.physical.bl_002'])
            ->add(
                'distinguishingMarks',
                null,
                [
                    'label' => 'admin.label.distinguishing_marks',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'healthProblems',
                null,
                [
                    'label' => 'admin.label.health_problems',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'speechPattern',
                null,
                [
                    'label' => 'admin.label.speech_pattern',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();

        /** ----- Tab Life Style ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_life_style', ['label' => 'admin.tab.life_style'])
            ->with('lst_001', ['class' => 'col-md-4', 'label' => 'admin.block.life_style.bl_001'])
            ->add('sexuality', null, ['label' => 'admin.label.sexuality', 'route' => ['name' => 'show']])
            ->add('homeCountry', null, ['label' => 'admin.label.home_country', 'route' => ['name' => 'show']])
            ->add('homeCity', null, ['label' => 'admin.label.home_city'])
            ->add(
                'income',
                null,
                [
                    'label' => 'admin.label.income',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add('currentOccupation', null, ['label' => 'admin.label.current_occupation', 'route' => ['name' => 'show']])
            ->add('currentOccupationNice', null, ['label' => 'admin.label.current_occupation_nice'])
            ->end()
            ->with('lst_002', ['class' => 'col-md-8', 'label' => 'admin.block.life_style.bl_002'])
            ->add(
                'dressStyle',
                null,
                [
                    'label' => 'admin.label.dress_style',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'goodHabits',
                null,
                [
                    'label' => 'admin.label.good_habits',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'badHabits',
                null,
                [
                    'label' => 'admin.label.bad_habits',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'favoriteMusic',
                null,
                [
                    'label' => 'admin.label.favorite_music',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'favoriteSports',
                null,
                [
                    'label' => 'admin.label.favorite_sports',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'favoriteFood',
                null,
                [
                    'label' => 'admin.label.favorite_food',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'hobbies',
                null,
                [
                    'label' => 'admin.label.hobbies',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();

        /** ----- Tab Intelectual ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_intelectual', ['label' => 'admin.tab.intelectual'])
            ->with('int_001', ['class' => 'col-md-6', 'label' => 'admin.block.intelectual.bl_001'])
            ->add('iqLevel', null, ['label' => 'admin.label.iq_level', 'route' => ['name' => 'show']])
            ->add('educationalLevel', null, ['label' => 'admin.label.educational_level', 'route' => ['name' => 'show']])
            ->add(
                'skills',
                null,
                [
                    'label' => 'admin.label.skills',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'personality',
                null,
                [
                    'label' => 'admin.label.personality',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->with('int_002', ['class' => 'col-md-6', 'label' => 'admin.block.intelectual.bl_002'])
            ->add('dominantTemperament', null, ['label' => 'admin.label.dominant_temperament', 'route' => ['name' => 'show']])
            ->add('secondaryTemperament', null, ['label' => 'admin.label.secondary_temperament', 'route' => ['name' => 'show']])
            ->add(
                'selfView',
                null,
                [
                    'label' => 'admin.label.self_view',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'whatWouldChange',
                null,
                [
                    'label' => 'admin.label.what_would_change',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();

        /** ----- Tab Emotional ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_emotional', ['label' => 'admin.tab.emotional'])
            ->with('emo_001', ['class' => 'col-md-12', 'label' => 'admin.block.emotional.bl_001'])
            ->add(
                'emotionalTraumas',
                null,
                [
                    'label' => 'admin.label.emotional_traumas',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'deepestSecret',
                null,
                [
                    'label' => 'admin.label.deepest_secret',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'whatMotivates',
                null,
                [
                    'label' => 'admin.label.what_motivates',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'whatMakesHappy',
                null,
                [
                    'label' => 'admin.label.what_makes_happy',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'whatFrightens',
                null,
                [
                    'label' => 'admin.label.what_frightens',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();

        /** ----- Tab Spiritual ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_spiritual', ['label' => 'admin.tab.spiritual'])
            ->with('spi_001', ['class' => 'col-md-12', 'label' => 'admin.block.spiritual.bl_001'])
            ->add('religion', null, ['label' => 'admin.label.religion', 'route' => ['name' => 'show']])
            ->add('religious', null, ['label' => 'admin.label.religious'])
            ->add(
                'spiritualBeliefs',
                null,
                [
                    'label' => 'admin.label.spiritual_beliefs',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'spiritualEffectsInLife',
                null,
                [
                    'label' => 'admin.label.spiritual_effects_in_life',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();

        /** ----- Tab Relationship ---------------------------------------------------------------------- */
        $showMapper
            ->tab('tab_relationship', ['label' => 'admin.tab.relationship'])
            ->with('rel_001', ['class' => 'col-md-12', 'label' => 'admin.block.relationship.bl_001'])
            ->add(
                'parents',
                null,
                [
                    'label' => 'admin.label.parents',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'siblings',
                null,
                [
                    'label' => 'admin.label.siblings',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'children',
                null,
                [
                    'label' => 'admin.label.children',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'spouse',
                null,
                [
                    'label' => 'admin.label.spouse',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'friends',
                null,
                [
                    'label' => 'admin.label.friends',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'enemies',
                null,
                [
                    'label' => 'admin.label.enemies',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'significantOthers',
                null,
                [
                    'label' => 'admin.label.significant_others',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end()
            ->end();
    }
}
