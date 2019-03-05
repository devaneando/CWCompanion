<?php

namespace App\DataFixtures;

use App\Entity\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Used as base class for fixtues, provides container and progress bar.
 */
abstract class AbstractDataFixture extends AbstractFixture implements OrderedFixtureInterface
{
    const PATH_RESOURCES = __DIR__.'/Resources';
    const FALLBACK_LOCALE = 'en';

    /** @var TranslatorInterface */
    private $translator;

    /** @var UserManager */
    private $userManager;

    /** @var string */
    private $locale;

    /** @var ConsoleOutput */
    private $output;

    /** @var array */
    private $data;

    /** @var ProgressBar */
    private $progressBar;

    public function __construct(TranslatorInterface $translator, UserManager $userManager)
    {
        $this->translator = $translator;
        $this->locale = $this->translator->getLocale();
        $this->userManager = $userManager;
    }

    /**
     * @return ConsoleOutput
     */
    public function getOutput(): ConsoleOutput
    {
        if (null === $this->output) {
            $this->output = new ConsoleOutput();
        }

        return $this->output;
    }

    public function getUserManager(): UserManager
    {
        return $this->userManager;
    }

    /**
     * Get the value of data.
     *
     * @param string $key The name of the key of the array
     *
     * @return mixed
     */
    public function getData(string $key = null)
    {
        if (true === empty($key)) {
            return $this->data;
        }
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getProgressBar(): ProgressBar
    {
        if (null === $this->progressBar) {
            $this->progressBar = new ProgressBar($this->getOutput(), count($this->getData()));
        }

        return $this->progressBar;
    }

    /** Step the progressBar. */
    public function stepIt(): self
    {
        $this->getProgressBar()->advance();

        return $this;
    }

    /** Load a yaml data file into the data array. */
    public function loadData(string $fileName): self
    {
        $resourceFile = self::PATH_RESOURCES.'/'.$this->locale.'/'.$fileName;
        if (false === file_exists($resourceFile)) {
            $resourceFile = self::PATH_RESOURCES.'/'.self::FALLBACK_LOCALE.'/'.$fileName;
        } elseif (false === file_exists($resourceFile)) {
            throw new \Exception("The file '$fileName' does not exist.");
        }

        $this->data = Yaml::parseFile($resourceFile);

        return $this;
    }

    /** Convert a string to its slug form */
    public function slugify(string $name): string
    {
        $slugify = new Slugify();

        return $slugify->slugify($name);
    }
}
