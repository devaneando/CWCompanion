<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Type\ExtendedDateType;
use App\Admin\Type\MarkDownType;
use App\Entity\Character;
use App\Model\ExtendedDate;
use App\Traits\Repository\ZodiacRepositoryTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

final class CharacterAdmin extends AbstractAdmin
{
    use ZodiacRepositoryTrait;
    protected $baseRouteName = 'writing_character';
    protected $baseRoutePattern = 'writing/character';
    protected $datagridValues = [
        '_sort_by'=> 'name',
        '_sort_order'=> 'ASC',
        '_per_page'=> 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];
    protected $translationDomain = 'character';

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
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label'=> 'admin.label.id'])
            ->add('nickname', null, ['label'=> 'admin.label.nickname'])
            ->add('slug', null, ['label'=> 'admin.label.slug'])
            ->add('fullName', null, ['label'=> 'admin.label.full_name'])
            ->add('picture', null, ['label'=> 'admin.label.picture'])
            ->add('gender', null, ['label'=> 'admin.label.gender'])
            ->add('characterType', null, ['label'=> 'admin.label.character_type'])
            ->add('concept', null, ['label'=> 'admin.label.concept'])
            ->add('zodiacSign', null, ['label'=> 'admin.label.zodiac_sign'])
            ->add('birthCountry', null, ['label'=> 'admin.label.birth_country'])
            ->add('birthCity', null, ['label'=> 'admin.label.birth_city'])
            ->add('birthdate', null, ['label'=> 'admin.label.birthdate'])
            ->add('cityOfDeath', null, ['label'=> 'admin.label.city_of_death'])
            ->add('dateOfDeath', null, ['label'=> 'admin.label.date_of_death'])
            ->add('eyes', null, ['label'=> 'admin.label.eyes'])
            ->add('skin', null, ['label'=> 'admin.label.skin'])
            ->add('hair', null, ['label'=> 'admin.label.hair'])
            ->add('bodyType', null, ['label'=> 'admin.label.body_type'])
            ->add('height', null, ['label'=> 'admin.label.height'])
            ->add('distinguishingMarks', null, ['label'=> 'admin.label.distinguishing_marks'])
            ->add('healthProblems', null, ['label'=> 'admin.label.health_problems'])
            ->add('speechPattern', null, ['label'=> 'admin.label.speech_pattern'])
            ->add('odor', null, ['label'=> 'admin.label.odor'])
            ->add('generalNotes', null, ['label'=> 'admin.label.general_notes'])
            ->add('homeCountry', null, ['label'=> 'admin.label.home_country'])
            ->add('homeCity', null, ['label'=> 'admin.label.home_city'])
            ->add('currentOccupation', null, ['label'=> 'admin.label.current_occupation'])
            ->add('currentOccupationNice', null, ['label'=> 'admin.label.current_occupation_nice'])
            ->add('income', null, ['label'=> 'admin.label.income'])
            ->add('sexuality', null, ['label'=> 'admin.label.sexuality'])
            ->add('dressStyle', null, ['label'=> 'admin.label.dress_style'])
            ->add('hobbies', null, ['label'=> 'admin.label.hobbies'])
            ->add('goodHabits', null, ['label'=> 'admin.label.good_habits'])
            ->add('badHabits', null, ['label'=> 'admin.label.bad_habits'])
            ->add('favoriteMusic', null, ['label'=> 'admin.label.favorite_music'])
            ->add('favoriteSports', null, ['label'=> 'admin.label.favorite_sports'])
            ->add('favoriteFood', null, ['label'=> 'admin.label.favorite_food'])
            ->add('iqLevel', null, ['label'=> 'admin.label.iq_level'])
            ->add('educationalLevel', null, ['label'=> 'admin.label.educational_level'])
            ->add('skills', null, ['label'=> 'admin.label.skills'])
            ->add('selfView', null, ['label'=> 'admin.label.self_view'])
            ->add('dominantTemperament', null, ['label'=> 'admin.label.dominant_temperament'])
            ->add('secondaryTemperament', null, ['label'=> 'admin.label.secondary_temperament'])
            ->add('personality', null, ['label'=> 'admin.label.personality'])
            ->add('emotionalTraumas', null, ['label'=> 'admin.label.emotional_traumas'])
            ->add('whatMotivates', null, ['label'=> 'admin.label.what_motivates'])
            ->add('whatMakesHappy', null, ['label'=> 'admin.label.what_makes_happy'])
            ->add('whatFrightens', null, ['label'=> 'admin.label.what_frightens'])
            ->add('whatWouldChange', null, ['label'=> 'admin.label.what_would_change'])
            ->add('deepestSecret', null, ['label'=> 'admin.label.deepest_secret'])
            ->add('religious', null, ['label'=> 'admin.label.religious'])
            ->add('spiritualBeliefs', null, ['label'=> 'admin.label.spiritual_beliefs'])
            ->add('spiritualEffectsInLife', null, ['label'=> 'admin.label.spiritual_effects_in_life'])
            ->add('parents', null, ['label'=> 'admin.label.parents'])
            ->add('siblings', null, ['label'=> 'admin.label.siblings'])
            ->add('children', null, ['label'=> 'admin.label.children'])
            ->add('spouse', null, ['label'=> 'admin.label.spouse'])
            ->add('friends', null, ['label'=> 'admin.label.friends'])
            ->add('enemies', null, ['label'=> 'admin.label.enemies'])
            ->add('significantOthers', null, ['label'=> 'admin.label.significant_others'])
            ->add('personalHistory', null, ['label'=> 'admin.label.personal_history']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['label'=> 'admin.label.id'])
            ->add('nickname', null, ['label'=> 'admin.label.nickname'])
            ->add('slug', null, ['label'=> 'admin.label.slug'])
            ->add('fullName', null, ['label'=> 'admin.label.full_name'])
            ->add('picture', null, ['label'=> 'admin.label.picture'])
            ->add('gender', null, ['label'=> 'admin.label.gender'])
            ->add('characterType', null, ['label'=> 'admin.label.character_type'])
            ->add('concept', null, ['label'=> 'admin.label.concept'])
            ->add('zodiacSign', null, ['label'=> 'admin.label.zodiac_sign'])
            ->add('birthCountry', null, ['label'=> 'admin.label.birth_country'])
            ->add('birthCity', null, ['label'=> 'admin.label.birth_city'])
            ->add('birthdate', null, ['label'=> 'admin.label.birthdate'])
            ->add('cityOfDeath', null, ['label'=> 'admin.label.city_of_death'])
            ->add('dateOfDeath', null, ['label'=> 'admin.label.date_of_death'])
            ->add('eyes', null, ['label'=> 'admin.label.eyes'])
            ->add('skin', null, ['label'=> 'admin.label.skin'])
            ->add('hair', null, ['label'=> 'admin.label.hair'])
            ->add('bodyType', null, ['label'=> 'admin.label.body_type'])
            ->add('height', null, ['label'=> 'admin.label.height'])
            ->add('distinguishingMarks', null, ['label'=> 'admin.label.distinguishing_marks'])
            ->add('healthProblems', null, ['label'=> 'admin.label.health_problems'])
            ->add('speechPattern', null, ['label'=> 'admin.label.speech_pattern'])
            ->add('odor', null, ['label'=> 'admin.label.odor'])
            ->add('generalNotes', null, ['label'=> 'admin.label.general_notes'])
            ->add('homeCountry', null, ['label'=> 'admin.label.home_country'])
            ->add('homeCity', null, ['label'=> 'admin.label.home_city'])
            ->add('currentOccupation', null, ['label'=> 'admin.label.current_occupation'])
            ->add('currentOccupationNice', null, ['label'=> 'admin.label.current_occupation_nice'])
            ->add('income', null, ['label'=> 'admin.label.income'])
            ->add('sexuality', null, ['label'=> 'admin.label.sexuality'])
            ->add('dressStyle', null, ['label'=> 'admin.label.dress_style'])
            ->add('hobbies', null, ['label'=> 'admin.label.hobbies'])
            ->add('goodHabits', null, ['label'=> 'admin.label.good_habits'])
            ->add('badHabits', null, ['label'=> 'admin.label.bad_habits'])
            ->add('favoriteMusic', null, ['label'=> 'admin.label.favorite_music'])
            ->add('favoriteSports', null, ['label'=> 'admin.label.favorite_sports'])
            ->add('favoriteFood', null, ['label'=> 'admin.label.favorite_food'])
            ->add('iqLevel', null, ['label'=> 'admin.label.iq_level'])
            ->add('educationalLevel', null, ['label'=> 'admin.label.educational_level'])
            ->add('skills', null, ['label'=> 'admin.label.skills'])
            ->add('selfView', null, ['label'=> 'admin.label.self_view'])
            ->add('dominantTemperament', null, ['label'=> 'admin.label.dominant_temperament'])
            ->add('secondaryTemperament', null, ['label'=> 'admin.label.secondary_temperament'])
            ->add('personality', null, ['label'=> 'admin.label.personality'])
            ->add('emotionalTraumas', null, ['label'=> 'admin.label.emotional_traumas'])
            ->add('whatMotivates', null, ['label'=> 'admin.label.what_motivates'])
            ->add('whatMakesHappy', null, ['label'=> 'admin.label.what_makes_happy'])
            ->add('whatFrightens', null, ['label'=> 'admin.label.what_frightens'])
            ->add('whatWouldChange', null, ['label'=> 'admin.label.what_would_change'])
            ->add('deepestSecret', null, ['label'=> 'admin.label.deepest_secret'])
            ->add('religious', null, ['label'=> 'admin.label.religious'])
            ->add('spiritualBeliefs', null, ['label'=> 'admin.label.spiritual_beliefs'])
            ->add('spiritualEffectsInLife', null, ['label'=> 'admin.label.spiritual_effects_in_life'])
            ->add('parents', null, ['label'=> 'admin.label.parents'])
            ->add('siblings', null, ['label'=> 'admin.label.siblings'])
            ->add('children', null, ['label'=> 'admin.label.children'])
            ->add('spouse', null, ['label'=> 'admin.label.spouse'])
            ->add('friends', null, ['label'=> 'admin.label.friends'])
            ->add('enemies', null, ['label'=> 'admin.label.enemies'])
            ->add('significantOthers', null, ['label'=> 'admin.label.significant_others'])
            ->add('personalHistory', null, ['label'=> 'admin.label.personal_history'])
            ->add('_action', null, [
                'actions'=> [
                    'show'=> [],
                    'edit'=> [],
                    'delete'=> [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $pictureUploadedOptions = [
                'required'=> false,
                'data_class'=> null,
                'label'=> 'admin.label.uploaded_picture',
            ];
        if (($subject = $this->getSubject()) && $subject->getPicture()) {
            $path = $subject->getPicture();
            $pictureUploadedOptions['help'] = '<img id="member-edit-picture" src="'.$path.'" style=" max-height: 250px;"/>';
        }

        /** ----- Tab Inherited ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_inherited', ['label'=> 'admin.tab.inherited'])
            ->with('in_001', ['class'=> 'col-md-4', 'label'=> 'admin.block.inherited.bl_001'])
            ->add('nickname', null, ['label'=> 'admin.label.nickname'])
            ->add('characterType', null, ['label'=> 'admin.label.character_type'])
            ->add('concept', null, ['label'=> 'admin.label.concept'])
            ->add('gender', null, ['label'=> 'admin.label.gender'])
            ->add('fullName', null, ['label'=> 'admin.label.full_name'])
            ->add(
                'birthdate',
                ExtendedDateType::class,
                [
                    'label'=> 'admin.label.birthdate',
                    'required'=> true,
                ]
            )
            ->add('birthCountry', null, ['label'=> 'admin.label.birth_country'])
            ->add('birthCity', null, ['label'=> 'admin.label.birth_city'])
            ->add(
                'dateOfDeath',
                ExtendedDateType::class,
                [
                    'label'=> 'admin.label.date_of_death',
                    'required'=> false,
                ]
            )
            ->add('countryOfDeath', null, ['label'=> 'admin.label.country_of_death'])
            ->add('cityOfDeath', null, ['label'=> 'admin.label.city_of_death'])
            ->end()
            ->with('in_002', ['class'=> 'col-md-8', 'label'=> 'admin.block.inherited.bl_002'])
            ->add('uploadedPicture', FileType::class, $pictureUploadedOptions)
            ->add('generalNotes', MarkDownType::class, ['label'=> 'admin.label.general_notes', 'rows'=> 15])
            ->end()
            ->with('in_003', ['class'=> 'col-md-12', 'label'=> 'admin.block.inherited.bl_003'])
            ->add('personalHistory', MarkDownType::class, ['label'=> 'admin.label.personal_history', 'rows'=> 20])
            ->end()
            ->end();

        /** ----- Tab Physical ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_physical', ['label'=> 'admin.tab.physical'])
            ->with('phy_001', ['class'=> 'col-md-4', 'label'=> 'admin.block.physical.bl_001'])
            ->add('bodyType', null, ['label'=> 'admin.label.body_type'])
            ->add(
                'height',
                NumberType::class,
                [
                    'label'=> 'admin.label.height',
                    'required'=> false,
                    'scale'=> 2,
                ]
            )
            ->add('eyes', null, ['label'=> 'admin.label.eyes'])
            ->add('skin', null, ['label'=> 'admin.label.skin'])
            ->add('hair', null, ['label'=> 'admin.label.hair'])
            ->add('odor', null, ['label'=> 'admin.label.odor'])
            ->end()
            ->with('phy_002', ['class'=> 'col-md-8', 'label'=> 'admin.block.physical.bl_002'])
            ->add('distinguishingMarks', MarkDownType::class, ['label'=> 'admin.label.distinguishing_marks'])
            ->add('healthProblems', MarkDownType::class, ['label'=> 'admin.label.health_problems'])
            ->add('speechPattern', MarkDownType::class, ['label'=> 'admin.label.speech_pattern'])
            ->end()
            ->end();

        /** ----- Tab Life Style ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_life_style', ['label'=> 'admin.tab.life_style'])
            ->with('lst_001', ['class'=> 'col-md-4', 'label'=> 'admin.block.life_style.bl_001'])
            ->add('sexuality', null, ['label'=> 'admin.label.sexuality'])
            ->add('homeCountry', null, ['label'=> 'admin.label.home_country'])
            ->add('homeCity', null, ['label'=> 'admin.label.home_city'])
            ->add('income', null, ['label'=> 'admin.label.income'])
            ->add('currentOccupation', null, ['label'=> 'admin.label.current_occupation'])
            ->add('currentOccupationNice', null, ['label'=> 'admin.label.current_occupation_nice'])
            ->end()
            ->with('lst_002', ['class'=> 'col-md-8', 'label'=> 'admin.block.life_style.bl_002'])
            ->add('dressStyle', MarkDownType::class, ['label'=> 'admin.label.dress_style'])
            ->add('goodHabits', MarkDownType::class, ['label'=> 'admin.label.good_habits'])
            ->add('badHabits', MarkDownType::class, ['label'=> 'admin.label.bad_habits'])
            ->add('favoriteMusic', MarkDownType::class, ['label'=> 'admin.label.favorite_music'])
            ->add('favoriteSports', MarkDownType::class, ['label'=> 'admin.label.favorite_sports'])
            ->add('favoriteFood', MarkDownType::class, ['label'=> 'admin.label.favorite_food'])
            ->add('hobbies', MarkDownType::class, ['label'=> 'admin.label.hobbies'])
            ->end()
            ->end();

        /** ----- Tab Intelectual ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_intelectual', ['label'=> 'admin.tab.intelectual'])
            ->with('int_001', ['class'=> 'col-md-6', 'label'=> 'admin.block.intelectual.bl_001'])
            ->add('iqLevel', null, ['label'=> 'admin.label.iq_level'])
            ->add('educationalLevel', null, ['label'=> 'admin.label.educational_level'])
            ->add('skills', MarkDownType::class, ['label'=> 'admin.label.skills'])
            ->add('personality', MarkDownType::class, ['label'=> 'admin.label.personality'])
            ->end()
            ->with('int_002', ['class'=> 'col-md-6', 'label'=> 'admin.block.intelectual.bl_002'])
            ->add('dominantTemperament', null, ['label'=> 'admin.label.dominant_temperament'])
            ->add('secondaryTemperament', null, ['label'=> 'admin.label.secondary_temperament'])
            ->add('selfView', MarkDownType::class, ['label'=> 'admin.label.self_view'])
            ->add('whatWouldChange', MarkDownType::class, ['label'=> 'admin.label.what_would_change'])
            ->end()
            ->end();

        /** ----- Tab Emotional ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_emotional', ['label'=> 'admin.tab.emotional'])
            ->with('emo_001', ['class'=> 'col-md-12', 'label'=> 'admin.block.emotional.bl_001'])
            ->add('emotionalTraumas', MarkDownType::class, ['label'=> 'admin.label.emotional_traumas'])
            ->add('deepestSecret', MarkDownType::class, ['label'=> 'admin.label.deepest_secret'])
            ->add('whatMotivates', MarkDownType::class, ['label'=> 'admin.label.what_motivates'])
            ->add('whatMakesHappy', MarkDownType::class, ['label'=> 'admin.label.what_makes_happy'])
            ->add('whatFrightens', MarkDownType::class, ['label'=> 'admin.label.what_frightens'])
            ->end() /** end group #013 */
            ->end();

        /** ----- Tab Spiritual ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_spiritual', ['label'=> 'admin.tab.spiritual'])
            ->with('spi_001', ['class'=> 'col-md-12', 'label'=> 'admin.block.spiritual.bl_001'])
            ->add('religion', null, ['label'=> 'admin.label.religion'])
            ->add('religious', null, ['label'=> 'admin.label.religious'])
            ->add('spiritualBeliefs', MarkDownType::class, ['label'=> 'admin.label.spiritual_beliefs'])
            ->add('spiritualEffectsInLife', MarkDownType::class, ['label'=> 'admin.label.spiritual_effects_in_life'])
            ->end()
            ->end();

        /** ----- Tab Relationship ---------------------------------------------------------------------- */
        $formMapper
            ->tab('tab_relationship', ['label'=> 'admin.tab.relationship'])
            ->with('rel_001', ['class'=> 'col-md-12', 'label'=> 'admin.block.relationship.bl_001'])
            ->add('parents', MarkDownType::class, ['label'=> 'admin.label.parents'])
            ->add('siblings', MarkDownType::class, ['label'=> 'admin.label.siblings'])
            ->add('children', MarkDownType::class, ['label'=> 'admin.label.children'])
            ->add('spouse', MarkDownType::class, ['label'=> 'admin.label.spouse'])
            ->add('friends', MarkDownType::class, ['label'=> 'admin.label.friends'])
            ->add('enemies', MarkDownType::class, ['label'=> 'admin.label.enemies'])
            ->add('significantOthers', MarkDownType::class, ['label'=> 'admin.label.significant_others'])
            ->end()
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label'=> 'admin.label.id'])
            ->add('nickname', null, ['label'=> 'admin.label.nickname'])
            ->add('slug', null, ['label'=> 'admin.label.slug'])
            ->add('fullName', null, ['label'=> 'admin.label.full_name'])
            ->add('picture', null, ['label'=> 'admin.label.picture'])
            ->add('gender', null, ['label'=> 'admin.label.gender'])
            ->add('characterType', null, ['label'=> 'admin.label.character_type'])
            ->add('concept', null, ['label'=> 'admin.label.concept'])
            ->add('zodiacSign', null, ['label'=> 'admin.label.zodiac_sign'])
            ->add('birthCountry', null, ['label'=> 'admin.label.birth_country'])
            ->add('birthCity', null, ['label'=> 'admin.label.birth_city'])
            ->add('birthdate', null, ['label'=> 'admin.label.birthdate'])
            ->add('cityOfDeath', null, ['label'=> 'admin.label.city_of_death'])
            ->add('dateOfDeath', null, ['label'=> 'admin.label.date_of_death'])
            ->add('eyes', null, ['label'=> 'admin.label.eyes'])
            ->add('skin', null, ['label'=> 'admin.label.skin'])
            ->add('hair', null, ['label'=> 'admin.label.hair'])
            ->add('bodyType', null, ['label'=> 'admin.label.body_type'])
            ->add('height', null, ['label'=> 'admin.label.height'])
            ->add('distinguishingMarks', null, ['label'=> 'admin.label.distinguishing_marks'])
            ->add('healthProblems', null, ['label'=> 'admin.label.health_problems'])
            ->add('speechPattern', null, ['label'=> 'admin.label.speech_pattern'])
            ->add('odor', null, ['label'=> 'admin.label.odor'])
            ->add('generalNotes', null, ['label'=> 'admin.label.general_notes'])
            ->add('homeCountry', null, ['label'=> 'admin.label.home_country'])
            ->add('homeCity', null, ['label'=> 'admin.label.home_city'])
            ->add('currentOccupation', null, ['label'=> 'admin.label.current_occupation'])
            ->add('currentOccupationNice', null, ['label'=> 'admin.label.current_occupation_nice'])
            ->add('income', null, ['label'=> 'admin.label.income'])
            ->add('sexuality', null, ['label'=> 'admin.label.sexuality'])
            ->add('dressStyle', null, ['label'=> 'admin.label.dress_style'])
            ->add('hobbies', null, ['label'=> 'admin.label.hobbies'])
            ->add('goodHabits', null, ['label'=> 'admin.label.good_habits'])
            ->add('badHabits', null, ['label'=> 'admin.label.bad_habits'])
            ->add('favoriteMusic', null, ['label'=> 'admin.label.favorite_music'])
            ->add('favoriteSports', null, ['label'=> 'admin.label.favorite_sports'])
            ->add('favoriteFood', null, ['label'=> 'admin.label.favorite_food'])
            ->add('iqLevel', null, ['label'=> 'admin.label.iq_level'])
            ->add('educationalLevel', null, ['label'=> 'admin.label.educational_level'])
            ->add('skills', null, ['label'=> 'admin.label.skills'])
            ->add('selfView', null, ['label'=> 'admin.label.self_view'])
            ->add('dominantTemperament', null, ['label'=> 'admin.label.dominant_temperament'])
            ->add('secondaryTemperament', null, ['label'=> 'admin.label.secondary_temperament'])
            ->add('personality', null, ['label'=> 'admin.label.personality'])
            ->add('emotionalTraumas', null, ['label'=> 'admin.label.emotional_traumas'])
            ->add('whatMotivates', null, ['label'=> 'admin.label.what_motivates'])
            ->add('whatMakesHappy', null, ['label'=> 'admin.label.what_makes_happy'])
            ->add('whatFrightens', null, ['label'=> 'admin.label.what_frightens'])
            ->add('whatWouldChange', null, ['label'=> 'admin.label.what_would_change'])
            ->add('deepestSecret', null, ['label'=> 'admin.label.deepest_secret'])
            ->add('religious', null, ['label'=> 'admin.label.religious'])
            ->add('spiritualBeliefs', null, ['label'=> 'admin.label.spiritual_beliefs'])
            ->add('spiritualEffectsInLife', null, ['label'=> 'admin.label.spiritual_effects_in_life'])
            ->add('parents', null, ['label'=> 'admin.label.parents'])
            ->add('siblings', null, ['label'=> 'admin.label.siblings'])
            ->add('children', null, ['label'=> 'admin.label.children'])
            ->add('spouse', null, ['label'=> 'admin.label.spouse'])
            ->add('friends', null, ['label'=> 'admin.label.friends'])
            ->add('enemies', null, ['label'=> 'admin.label.enemies'])
            ->add('significantOthers', null, ['label'=> 'admin.label.significant_others'])
            ->add('personalHistory', null, ['label'=> 'admin.label.personal_history']);
    }
}
