<?php

namespace App\Entity;

use App\Entity\CharacterType;
use App\Entity\Country;
use App\Entity\EducationalDegree;
use App\Entity\Gender;
use App\Entity\IntelligenceQuotient;
use App\Entity\Profession;
use App\Entity\Religion;
use App\Entity\Scene;
use App\Entity\Sexuality;
use App\Entity\Temperament;
use App\Entity\Traits\OwnerTrait;
use App\Entity\Traits\PictureTrait;
use App\Entity\Traits\ProjectsTrait;
use App\Entity\User;
use App\Entity\Zodiac;
use App\Exception\ExtendedDate\InvalidExtendedDateStamp;
use App\Model\ExtendedDate;
use App\Model\Image;
use App\Processor\ImageProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\CharacterRepository")
 * @ORM\Table(name="characters",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_characters_fullname_nickname", columns={"fullname", "nickname"}),
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Character
{
    const GENDER_FEMALE = 'f';
    const GENDER_MALE = 'm';
    const GENDER_UNKNOWN = 'u';
    const PERSONALITY_EXTROVERT = 'ext';
    const PERSONALITY_INTROVERT = 'int';

    /** @var string */
    protected $pictureType = ImageProcessor::IMAGE_TYPE_CHARACTER;

    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="characters")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     */
    protected $owner;
    use OwnerTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Project")
     * @ORM\JoinTable(name="characters_projects",
     *     joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     * )
     */
    protected $projects;
    use ProjectsTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Scene", mappedBy="characters")
     */
    protected $scenes;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=false)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 60,
     *     maxMessage="length.max.character.nickname"
     * )
     */
    protected $nickname;

    /**
     * @var string
     * @ORM\Column(name="fullname", type="string", length=255, nullable=true)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.fullname"
     * )
     */
    protected $fullName;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    protected $picture;
    use PictureTrait;

    /**
     * @var Gender
     * @ORM\ManyToOne(targetEntity="Gender")
     * @ORM\JoinColumn(name="gender_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $gender;

    /**
     * @var CharacterType
     * @ORM\ManyToOne(targetEntity="CharacterType")
     * @ORM\JoinColumn(name="character_type_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $characterType;

    /**
     * @var string
     * @ORM\Column(name="concept", type="string", length=120, nullable=false)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 120,
     *     maxMessage="length.max.character.concept"
     * )
     */
    protected $concept;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="birth_country_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $birthCountry;

    /**
     * @var string
     * @ORM\Column(name="birth_city", type="string", length=60, nullable=true)
     * @Assert\Length(
     *     max = 60,
     *     maxMessage="length.max.character.birth_city"
     * )
     */
    protected $birthCity;

    /**
     * @var string
     * @ORM\Column(name="birth_date", type="string", length=20, nullable=false)
     */
    protected $birthdate;

    /**
     * @var Zodiac
     * @ORM\ManyToOne(targetEntity="Zodiac")
     * @ORM\JoinColumn(name="zodiac_id", referencedColumnName="id", nullable=true)
     */
    protected $zodiacSign;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="death_country_id", referencedColumnName="id", nullable=true)
     */
    protected $countryOfDeath;

    /**
     * @var string
     * @ORM\Column(name="death_city", type="string", length=60, nullable=true)
     * @Assert\Length(
     *     max = 60,
     *     maxMessage="length.max.character.death_city"
     * )
     */
    protected $cityOfDeath;

    /**
     * @var ExtendedDate
     * @ORM\Column(name="death_date", type="string", length=20, nullable=true)
     */
    protected $dateOfDeath;

    /**
     * @var string
     * @ORM\Column(name="eyes", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.eyes"
     * )
     */
    protected $eyes;

    /**
     * @var string
     * @ORM\Column(name="skin", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.skin"
     * )
     */
    protected $skin;

    /**
     * @var string
     * @ORM\Column(name="hair", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.hair"
     * )
     */
    protected $hair;

    /**
     * @var string
     * @ORM\Column(name="body_type", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.body_type"
     * )
     */
    protected $bodyType;

    /**
     * @var float
     * @ORM\Column(name="height", type="float", nullable=true)
     */
    protected $height;

    /**
     * @var string
     * @ORM\Column(name="distinguishing_marks", type="text", nullable=true)
     */
    protected $distinguishingMarks;

    /**
     * @var string
     * @ORM\Column(name="health_problems", type="text", nullable=true)
     */
    protected $healthProblems;

    /**
     * @var string
     * @ORM\Column(name="speech_pattern", type="text", nullable=true)
     */
    protected $speechPattern;

    /**
     * @var string
     * @ORM\Column(name="odor", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.body_odor"
     * )
     */
    protected $odor;

    /**
     * @var string
     * @ORM\Column(name="general_notes", type="text", nullable=true)
     */
    protected $generalNotes;

    /**
     * ##### Lifestyle info ####################################################################################
     * ##### Information relative to the character's daily life and lifestyle.
     */

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="home_country_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $homeCountry;

    /**
     * @var string
     * @ORM\Column(name="home_city", type="string", length=60, nullable=true)
     * @Assert\Length(
     *     max = 60,
     *     maxMessage="length.max.character.home_city"
     * )
     */
    protected $homeCity;

    /**
     * @var Profession
     * @ORM\ManyToOne(targetEntity="Profession")
     * @ORM\JoinColumn(name="current_occupation_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $currentOccupation;

    /**
     * @var bool
     * @ORM\Column(name="cur_occupation_nice", type="boolean", nullable=true)
     */
    protected $currentOccupationNice;

    /**
     * @var string
     * @ORM\Column(name="income", type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage="length.max.character.income"
     * )
     */
    protected $income;

    /**
     * @var Sexuality
     * @ORM\ManyToOne(targetEntity="Sexuality")
     * @ORM\JoinColumn(name="sexuality_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $sexuality;

    /**
     * @var string
     * @ORM\Column(name="dress_style", type="text", nullable=true)
     */
    protected $dressStyle;

    /**
     * @var string
     * @ORM\Column(name="hobbies", type="text", nullable=true)
     */
    protected $hobbies;

    /**
     * @var string
     * @ORM\Column(name="good_habits", type="text", nullable=true)
     */
    protected $goodHabits;

    /**
     * @var string
     * @ORM\Column(name="bad_habits", type="text", nullable=true)
     */
    protected $badHabits;

    /**
     * @var string
     * @ORM\Column(name="fav_music", type="text", nullable=true)
     */
    protected $favoriteMusic;

    /**
     * @var string
     * @ORM\Column(name="fav_sports", type="text", nullable=true)
     */
    protected $favoriteSports;

    /**
     * @var string
     * @ORM\Column(name="fav_food", type="text", nullable=true)
     */
    protected $favoriteFood;

    /**
     * ##### Intellectual info ####################################################################################
     * ##### The character's general cultural and intellectual background.
     */

    /**
     * @var IntelligenceQuotient
     * @ORM\ManyToOne(targetEntity="IntelligenceQuotient")
     * @ORM\JoinColumn(name="iq_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $iqLevel;

    /**
     * @var EducationalDegree
     * @ORM\ManyToOne(targetEntity="EducationalDegree")
     * @ORM\JoinColumn(name="edu_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $educationalLevel;

    /**
     * @var string
     * @ORM\Column(name="skills", type="text", nullable=true)
     */
    protected $skills;

    /**
     * @var string
     * @ORM\Column(name="self_view", type="text", nullable=true)
     */
    protected $selfView;

    /**
     * ##### Emotional info ####################################################################################
     * ##### The character's inner and emotional background.
     */

    /**
     * @var Temperament
     * @ORM\ManyToOne(targetEntity="Temperament")
     * @ORM\JoinColumn(name="dom_temperament_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $dominantTemperament;

    /**
     * @var Temperament
     * @ORM\ManyToOne(targetEntity="Temperament")
     * @ORM\JoinColumn(name="sec_temperament_id", referencedColumnName="id", nullable=true)
     */
    protected $secondaryTemperament;

    /**
     * @var string
     * @ORM\Column(name="personality", type="text", nullable=true)
     */
    protected $personality;

    /**
     * @var string
     * @ORM\Column(name="emo_traumas", type="text", nullable=true)
     */
    protected $emotionalTraumas;

    /**
     * @var string
     * @ORM\Column(name="what_motivates", type="text", nullable=true)
     */
    protected $whatMotivates;

    /**
     * @var string
     * @ORM\Column(name="what_makes_happy", type="text", nullable=true)
     */
    protected $whatMakesHappy;

    /**
     * @var string
     * @ORM\Column(name="what_frightens", type="text", nullable=true)
     */
    protected $whatFrightens;

    /**
     * @var string
     * @ORM\Column(name="what_would_change", type="text", nullable=true)
     */
    protected $whatWouldChange;

    /**
     * @var string
     * @ORM\Column(name="deepest_secret", type="text", nullable=true)
     */
    protected $deepestSecret;

    /**
     * ##### Spiritual info ####################################################################################
     * ##### The character's religious and spiritual view of the world.
     */

    /**
     * @var bool
     * @ORM\Column(name="religious", type="boolean", nullable=true)
     */
    protected $religious;

    /**
     * @var Religion
     * @ORM\ManyToOne(targetEntity="Religion")
     * @ORM\JoinColumn(name="religion_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.default")
     */
    protected $religion;

    /**
     * @var string
     * @ORM\Column(name="spi_beliefs", type="text", nullable=true)
     */
    protected $spiritualBeliefs;

    /**
     * @var string
     * @ORM\Column(name="spi_effects_life", type="text", nullable=true)
     */
    protected $spiritualEffectsInLife;

    /**
     * ##### Background info ####################################################################################
     * ##### Information relative to the character's history, family and friends.
     */

    /**
     * @var string
     * @ORM\Column(name="fam_parents", type="text", nullable=true)
     */
    protected $parents;

    /**
     * @var string
     * @ORM\Column(name="fam_siblings", type="text", nullable=true)
     */
    protected $siblings;

    /**
     * @var string
     * @ORM\Column(name="fam_children", type="text", nullable=true)
     */
    protected $children;

    /**
     * @var string
     * @ORM\Column(name="fam_spouse", type="text", nullable=true)
     */
    protected $spouse;

    /**
     * @var string
     * @ORM\Column(name="soc_friends", type="text", nullable=true)
     */
    protected $friends;

    /**
     * @var string
     * @ORM\Column(name="soc_enemies", type="text", nullable=true)
     */
    protected $enemies;

    /**
     * @var string
     * @ORM\Column(name="soc_significant_others", type="text", nullable=true)
     */
    protected $significantOthers;

    /**
     * @var string
     * @ORM\Column(name="personal_history", type="text", nullable=true)
     */
    protected $personalHistory;

    public function __construct()
    {
        $this->scenes = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $date = new \DateTime('-30years');
        $this->birthdate = $date->format('Y-m-d');
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getProjects()
    {
        return $this->projects;
    }

    public function setProjects($projects = null): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function getProjectsAsArray()
    {
        return $this->projects->toArray();
    }

    /** @return ArrayCollection|PersistentCollection */
    public function getScenes()
    {
        return $this->scenes;
    }

    /** @param ArrayCollection|PersistentCollection|null $scenes */
    public function setScenes($scenes): self
    {
        $this->scenes = $scenes;

        return $this;
    }

    public function addScene(Scene $object): self
    {
        if (true === $this->scenes->contains($object)) {
            return $this;
        }
        $this->scenes->add($object);
        $object->addCharacter($this);

        return $this;
    }

    public function removeScene(Scene $object): self
    {
        if (false === $this->scenes->contains($object)) {
            return $this;
        }
        $this->scenes->removeElement($object);
        $object->removeCharacter($this);

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function __toString(): string
    {
        return (null !== $this->nickname) ? $this->nickname : '';
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = trim($nickname);

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = trim($fullName);

        return $this;
    }

    public function setDefaultPicture(): self
    {
        if (null !== $this->picture) {
            return $this;
        }

        $image = ImageProcessor::IMAGE_CHARACTER_UNKNOWN;
        if (self::GENDER_FEMALE === $this->gender->getCode()) {
            $image = ImageProcessor::IMAGE_CHARACTER_FEMALE;
        } elseif (self::GENDER_MALE === $this->gender->getCode()) {
            $image = ImageProcessor::IMAGE_CHARACTER_MALE;
        }
        $date = new \DateTime();
        $newImage = ImageProcessor::PATH_UPLOAD . '/' . $this->getId() . '_' . $date->format('Ymd_His') . '.png';
        if (false === file_exists(ImageProcessor::PATH_UPLOAD)) {
            mkdir(ImageProcessor::PATH_UPLOAD);
        }
        copy($image, $newImage);

        try {
            /** @var Image $image */
            $image = ImageProcessor::get($newImage);
            $image = ImageProcessor::move($image, ImageProcessor::IMAGE_TYPE_CHARACTER, $this->getId());
            $this->picture = $image->getWebPath();

            return $this;
        } catch (\Exception $ex) {
            throw new \Exception(
                'Something unexpected happened in ' . basename($ex->getFile()) . '#' . $ex->getLine() . ': ' . $ex->getMessage(),
                0,
                $ex
            );

            return $this;
        }
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCharacterType(): ?CharacterType
    {
        return $this->characterType;
    }

    public function setCharacterType(CharacterType $characterType): self
    {
        $this->characterType = $characterType;

        return $this;
    }

    public function getConcept(): ?string
    {
        return $this->concept;
    }

    public function setConcept(string $concept = null): self
    {
        $this->concept = trim($concept);

        return $this;
    }

    public function getBirthCountry(): ?Country
    {
        return $this->birthCountry;
    }

    public function setBirthCountry(Country $birthCountry): self
    {
        $this->birthCountry = $birthCountry;

        return $this;
    }

    public function getBirthCity(): ?string
    {
        return $this->birthCity;
    }

    public function setBirthCity(string $birthCity = null): self
    {
        $this->birthCity = trim($birthCity);

        return $this;
    }

    public function getBirthdate(): ?ExtendedDate
    {
        return new ExtendedDate($this->birthdate);
    }

    /** @throws InvalidExtendedDateStamp */
    public function setBirthdate(ExtendedDate $birthdate = null): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAge(): int
    {
        $currentYear = new \DateTime();
        $currentYear = (int)$currentYear->format('Y');
        if (null !== $this->getDateOfDeath()) {
            $currentYear = $this->getDateOfDeath()->getYear();
        }

        return $currentYear - $this->getBirthdate()->getYear();
    }

    public function getZodiacSign(): ?Zodiac
    {
        return $this->zodiacSign;
    }

    public function setZodiacSign(Zodiac $zodiacSign = null): self
    {
        $this->zodiacSign = $zodiacSign;

        return $this;
    }

    public function getCountryOfDeath(): ?Country
    {
        return $this->countryOfDeath;
    }

    public function setCountryOfDeath(Country $countryOfDeath = null): self
    {
        $this->countryOfDeath = $countryOfDeath;

        return $this;
    }

    public function getCityOfDeath(): ?string
    {
        return $this->cityOfDeath;
    }

    public function setCityOfDeath(string $cityOfDeath = null): self
    {
        $this->cityOfDeath = trim($cityOfDeath);

        return $this;
    }

    public function getDateOfDeath(): ?ExtendedDate
    {
        return $this->dateOfDeath;
    }

    /** @throws InvalidExtendedDateStamp */
    public function setDateOfDeath(ExtendedDate $dateOfDeath = null): self
    {
        $this->dateOfDeath = $dateOfDeath;

        return $this;
    }

    public function getEyes(): ?string
    {
        return $this->eyes;
    }

    public function setEyes(string $eyes = null): self
    {
        $this->eyes = trim($eyes);

        return $this;
    }

    public function getSkin(): ?string
    {
        return $this->skin;
    }

    public function setSkin(string $skin = null): self
    {
        $this->skin = trim($skin);

        return $this;
    }

    public function getHair(): ?string
    {
        return $this->hair;
    }

    public function setHair(string $hair = null): self
    {
        $this->hair = trim($hair);

        return $this;
    }

    public function getBodyType(): ?string
    {
        return $this->bodyType;
    }

    public function setBodyType(string $bodyType = null): self
    {
        $this->bodyType = trim($bodyType);

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height = null): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDistinguishingMarks(): ?string
    {
        return $this->distinguishingMarks;
    }

    public function setDistinguishingMarks(string $distinguishingMarks = null): self
    {
        $this->distinguishingMarks = trim($distinguishingMarks);

        return $this;
    }

    public function getHealthProblems(): ?string
    {
        return $this->healthProblems;
    }

    public function setHealthProblems(string $healthProblems = null): self
    {
        $this->healthProblems = trim($healthProblems);

        return $this;
    }

    public function getSpeechPattern(): ?string
    {
        return $this->speechPattern;
    }

    public function setSpeechPattern(string $speechPattern = null): self
    {
        $this->speechPattern = trim($speechPattern);

        return $this;
    }

    public function getOdor(): ?string
    {
        return $this->odor;
    }

    public function setOdor(string $odor = null): self
    {
        $this->odor = trim($odor);

        return $this;
    }

    public function getGeneralNotes(): ?string
    {
        return $this->generalNotes;
    }

    public function setGeneralNotes(string $generalNotes = null): self
    {
        $this->generalNotes = trim($generalNotes);

        return $this;
    }

    public function getHomeCountry(): ?Country
    {
        return $this->homeCountry;
    }

    public function setHomeCountry(Country $homeCountry = null): self
    {
        $this->homeCountry = $homeCountry;

        return $this;
    }

    public function getHomeCity(): ?string
    {
        return $this->homeCity;
    }

    public function setHomeCity(string $homeCity = null): self
    {
        $this->homeCity = trim($homeCity);

        return $this;
    }

    public function getCurrentOccupation(): ?Profession
    {
        return $this->currentOccupation;
    }

    public function setCurrentOccupation(Profession $currentOccupation): self
    {
        $this->currentOccupation = $currentOccupation;

        return $this;
    }

    public function isCurrentOccupationNice(): ?bool
    {
        return $this->currentOccupationNice;
    }

    public function setCurrentOccupationNice(bool $currentOccupationNice): self
    {
        $this->currentOccupationNice = $currentOccupationNice;

        return $this;
    }

    public function getIncome(): ?string
    {
        return $this->income;
    }

    public function setIncome(string $income = null): self
    {
        $this->income = trim($income);

        return $this;
    }

    public function getSexuality(): ?Sexuality
    {
        return $this->sexuality;
    }

    public function setSexuality(Sexuality $sexuality): self
    {
        $this->sexuality = $sexuality;

        return $this;
    }

    public function getDressStyle(): ?string
    {
        return $this->dressStyle;
    }

    public function setDressStyle(string $dressStyle = null): self
    {
        $this->dressStyle = trim($dressStyle);

        return $this;
    }

    public function getHobbies(): ?string
    {
        return $this->hobbies;
    }

    public function setHobbies(string $hobbies = null): self
    {
        $this->hobbies = trim($hobbies);

        return $this;
    }

    public function getGoodHabits(): ?string
    {
        return $this->goodHabits;
    }

    public function setGoodHabits(string $goodHabits = null): self
    {
        $this->goodHabits = trim($goodHabits);

        return $this;
    }

    public function getBadHabits(): ?string
    {
        return $this->badHabits;
    }

    public function setBadHabits(string $badHabits = null): self
    {
        $this->badHabits = trim($badHabits);

        return $this;
    }

    public function getFavoriteMusic(): ?string
    {
        return $this->favoriteMusic;
    }

    public function setFavoriteMusic(string $favoriteMusic = null): self
    {
        $this->favoriteMusic = trim($favoriteMusic);

        return $this;
    }

    public function getFavoriteSports(): ?string
    {
        return $this->favoriteSports;
    }

    public function setFavoriteSports(string $favoriteSports = null): self
    {
        $this->favoriteSports = trim($favoriteSports);

        return $this;
    }

    public function getFavoriteFood(): ?string
    {
        return $this->favoriteFood;
    }

    public function setFavoriteFood(string $favoriteFood = null): self
    {
        $this->favoriteFood = trim($favoriteFood);

        return $this;
    }

    public function getIqLevel(): ?IntelligenceQuotient
    {
        return $this->iqLevel;
    }

    public function setIqLevel(IntelligenceQuotient $iqLevel): self
    {
        $this->iqLevel = $iqLevel;

        return $this;
    }

    public function getEducationalLevel(): ?EducationalDegree
    {
        return $this->educationalLevel;
    }

    public function setEducationalLevel(EducationalDegree $educationalLevel): self
    {
        $this->educationalLevel = $educationalLevel;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills = null): self
    {
        $this->skills = trim($skills);

        return $this;
    }

    public function getSelfView(): ?string
    {
        return $this->selfView;
    }

    public function setSelfView(string $selfView = null): self
    {
        $this->selfView = trim($selfView);

        return $this;
    }

    public function getDominantTemperament(): ?Temperament
    {
        return $this->dominantTemperament;
    }

    public function setDominantTemperament(Temperament $dominantTemperament): self
    {
        $this->dominantTemperament = $dominantTemperament;

        return $this;
    }

    public function getSecondaryTemperament(): ?Temperament
    {
        return $this->secondaryTemperament;
    }

    public function setSecondaryTemperament(Temperament $secondaryTemperament = null): self
    {
        $this->secondaryTemperament = $secondaryTemperament;

        return $this;
    }

    public function getPersonality(): ?string
    {
        return $this->personality;
    }

    public function setPersonality(string $personality = null): self
    {
        $this->personality = trim($personality);

        return $this;
    }

    public function getEmotionalTraumas(): ?string
    {
        return $this->emotionalTraumas;
    }

    public function setEmotionalTraumas(string $emotionalTraumas = null): self
    {
        $this->emotionalTraumas = trim($emotionalTraumas);

        return $this;
    }

    public function getWhatMotivates(): ?string
    {
        return $this->whatMotivates;
    }

    public function setWhatMotivates(string $whatMotivates = null): self
    {
        $this->whatMotivates = trim($whatMotivates);

        return $this;
    }

    public function getWhatMakesHappy(): ?string
    {
        return $this->whatMakesHappy;
    }

    public function setWhatMakesHappy(string $whatMakesHappy = null): self
    {
        $this->whatMakesHappy = trim($whatMakesHappy);

        return $this;
    }

    public function getWhatFrightens(): ?string
    {
        return $this->whatFrightens;
    }

    public function setWhatFrightens(string $whatFrightens = null): self
    {
        $this->whatFrightens = trim($whatFrightens);

        return $this;
    }

    public function getWhatWouldChange(): ?string
    {
        return $this->whatWouldChange;
    }

    public function setWhatWouldChange(string $whatWouldChange = null): self
    {
        $this->whatWouldChange = trim($whatWouldChange);

        return $this;
    }

    public function getDeepestSecret(): ?string
    {
        return $this->deepestSecret;
    }

    public function setDeepestSecret(string $deepestSecret = null): self
    {
        $this->deepestSecret = trim($deepestSecret);

        return $this;
    }

    public function isReligious(): ?bool
    {
        return $this->religious;
    }

    public function setReligious(bool $religious): self
    {
        $this->religious = $religious;

        return $this;
    }

    public function getReligion(): ?Religion
    {
        return $this->religion;
    }

    public function setReligion(Religion $religion): self
    {
        $this->religion = $religion;

        return $this;
    }

    public function getSpiritualBeliefs(): ?string
    {
        return $this->spiritualBeliefs;
    }

    public function setSpiritualBeliefs(string $spiritualBeliefs = null): self
    {
        $this->spiritualBeliefs = trim($spiritualBeliefs);

        return $this;
    }

    public function getSpiritualEffectsInLife(): ?string
    {
        return $this->spiritualEffectsInLife;
    }

    public function setSpiritualEffectsInLife(string $spiritualEffectsInLife = null): self
    {
        $this->spiritualEffectsInLife = trim($spiritualEffectsInLife);

        return $this;
    }

    public function getParents(): ?string
    {
        return $this->parents;
    }

    public function setParents(string $parents = null): self
    {
        $this->parents = trim($parents);

        return $this;
    }

    public function getSiblings(): ?string
    {
        return $this->siblings;
    }

    public function setSiblings(string $siblings = null): self
    {
        $this->siblings = trim($siblings);

        return $this;
    }

    public function getChildren(): ?string
    {
        return $this->children;
    }

    public function setChildren(string $children = null): self
    {
        $this->children = trim($children);

        return $this;
    }

    public function getSpouse(): ?string
    {
        return $this->spouse;
    }

    public function setSpouse(string $spouse = null): self
    {
        $this->spouse = trim($spouse);

        return $this;
    }

    public function getFriends(): ?string
    {
        return $this->friends;
    }

    public function setFriends(string $friends = null): self
    {
        $this->friends = trim($friends);

        return $this;
    }

    public function getEnemies(): ?string
    {
        return $this->enemies;
    }

    public function setEnemies(string $enemies = null): self
    {
        $this->enemies = trim($enemies);

        return $this;
    }

    public function getSignificantOthers(): ?string
    {
        return $this->significantOthers;
    }

    public function setSignificantOthers(string $significantOthers = null): self
    {
        $this->significantOthers = trim($significantOthers);

        return $this;
    }

    public function getPersonalHistory(): ?string
    {
        return $this->personalHistory;
    }

    public function setPersonalHistory(string $personalHistory = null): self
    {
        $this->personalHistory = trim($personalHistory);

        return $this;
    }
}
