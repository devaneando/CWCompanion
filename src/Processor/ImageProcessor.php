<?php

namespace App\Processor;

use App\Exception\Image\CorruptedImageFile;
use App\Exception\Image\InvalidHash;
use App\Exception\Image\InvalidImage;
use App\Exception\Image\InvalidImageType;
use App\Exception\Image\UnexistentFile;
use App\Model\Image;
use App\Traits\ConstantValidationTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageProcessor
{
    const PUBLIC_IMAGES = '/images';
    const PUBLIC_CHARACTERS = self::PUBLIC_IMAGES.'/characters';
    const PUBLIC_CONCEPTS = self::PUBLIC_IMAGES.'/concepts';
    const PUBLIC_KEY_ITEMS = self::PUBLIC_IMAGES.'/key-items';
    const PUBLIC_LOCALES = self::PUBLIC_IMAGES.'/locales';
    const PUBLIC_PROJECTS = self::PUBLIC_IMAGES.'/projects';

    const PATH_UPLOAD = '/tmp/cwc';
    const PATH_PUBLIC = __DIR__.'/../../public';
    const PATH_DEFAULT = '/default';
    const PATH_CHARACTERS = self::PATH_PUBLIC.self::PUBLIC_CHARACTERS;
    const PATH_CHARACTERS_DEFAULT = self::PATH_CHARACTERS.self::PATH_DEFAULT;
    const PATH_KEY_ITEMS = self::PATH_PUBLIC.self::PUBLIC_KEY_ITEMS;
    const PATH_KEY_ITEMS_DEFAULT = self::PATH_KEY_ITEMS.self::PATH_DEFAULT;
    const PATH_LOCALES = self::PATH_PUBLIC.self::PUBLIC_LOCALES;
    const PATH_LOCALES_DEFAULT = self::PATH_LOCALES.self::PATH_DEFAULT;
    const PATH_CONCEPTS = self::PATH_PUBLIC.self::PUBLIC_CONCEPTS;
    const PATH_CONCEPTS_DEFAULT = self::PATH_CONCEPTS.self::PATH_DEFAULT;
    const PATH_PROJECTS = self::PATH_PUBLIC.self::PUBLIC_PROJECTS;
    const PATH_PROJECTS_DEFAULT = self::PATH_PROJECTS.self::PATH_DEFAULT;

    const IMAGE_HEIGHT = 512;
    const IMAGE_CHARACTER_FEMALE = self::PATH_CHARACTERS_DEFAULT.'/female.png';
    const IMAGE_CHARACTER_MALE = self::PATH_CHARACTERS_DEFAULT.'/male.png';
    const IMAGE_CHARACTER_UNKNOWN = self::PATH_CHARACTERS_DEFAULT.'/unknown.png';
    const IMAGE_LOCALE = self::PATH_LOCALES_DEFAULT.'/locale.png';
    const IMAGE_KEY_ITEM = self::PATH_KEY_ITEMS_DEFAULT.'/key-item.png';
    const IMAGE_CONCEPT = self::PATH_CONCEPTS_DEFAULT.'/concept.png';
    const IMAGE_PROJECT = self::PATH_PROJECTS_DEFAULT.'/project.png';

    const IMAGE_TYPE_CHARACTER = 'character';
    const IMAGE_TYPE_KEY_ITEM = 'key-item';
    const IMAGE_TYPE_LOCALE = 'locale';
    const IMAGE_TYPE_CONCEPT = 'concept';
    const IMAGE_TYPE_PROJECT = 'project';

    /** @var array */
    public static $imageTypes = [
        0=>'unknown',
        1=>'gif',
        2=>'jpg',
        3=>'png',
        4=>'swf',
        5=>'psd',
        6=>'bmp',
        7=>'tiff',
        8=>'tiff',
        9=>'jpc',
        10=>'jp2',
        11=>'jpx',
        12=>'jb2',
        13=>'swc',
        14=>'iff',
        15=>'wbmp',
        16=>'xbm',
        17=>'ico',
        18=>'count',
    ];

    /** @var array */
    private static $validMimeTypes = ['image/jpeg', 'image/png'];

    /**
     * Check if a fileName has a valid image fileName extension and has correct data.
     *
     * @param string $fileName
     * @param Image|null $image
     *
     * @return Image
     */
    public static function validateImage(string $fileName, Image $image = null)
    {
        if (false === file_exists($fileName)) {
            throw new UnexistentFile();
        }

        if (null === $image) {
            $image = new Image();
        }

        $imageInfo = getimagesize($fileName);
        if (false === $imageInfo) {
            throw new CorruptedImageFile();
        }

        if (false === in_array($imageInfo['mime'], self::$validMimeTypes)) {
            throw new InvalidImage('Only .jpg and .png images are accepted.');
        }

        $image->setExtension('jpg');
        if ('image/png' === $imageInfo['mime']) {
            $image->setExtension('png');
        }

        $info = pathinfo($fileName);

        $image
            ->setOriginalHeight($imageInfo[1])
            ->setOriginalWidth($imageInfo[0])
            ->setPercentage(round(((512 * 100) / $image->getOriginalHeight())/100, 2))
            ->setWidth(round($image->getOriginalWidth() * $image->getPercentage()))
            ->setHeight(self::IMAGE_HEIGHT)
            ->setPath($fileName)
            ->setOriginalPath($fileName)
            ->setBaseName($info['basename'])
            ->setDirName($info['dirname'])
            ->setMd5(md5_file($fileName));

        return $image;
    }

    /**
     * Manage the copy of the image to the server
     * For more information, check:
     *     - https://symfony.com/doc/3.4/controller/upload_file.html
     *     - https://symfony.com/doc/3.x/bundles/SonataAdminBundle/cookbook/recipe_file_uploads.html.
     *
     * @param UploadedFile $uploadedImage
     *
     * @return string|false The path to the saved image, or false, if some problem happens
     */
    public static function upload(UploadedFile $uploadedImage)
    {
        if (false === file_exists(self::PATH_UPLOAD)) {
            mkdir(self::PATH_UPLOAD, 0755, true);
        }

        try {
            $uploadedImage->move(self::PATH_UPLOAD, $uploadedImage->getClientOriginalName());

            return self::PATH_UPLOAD.'/'.$uploadedImage->getClientOriginalName();
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Get a mew Image instance based on a imagePath.
     *
     * @param string $imagePath
     *
     * @return Image
     */
    public static function get(string $imagePath)
    {
        if (false === file_exists($imagePath)) {
            throw new UnexistentFile();
        }
        $image = self::validateImage($imagePath);

        return $image;
    }

    /**
     * Get the path where the image will be saved.
     *
     * @param Image $image The image to be moved
     * @param string $hash The image hash
     * @param string $type One of the ImageProcessor::IMAGE_TYPE_* constants
     *
     * @throws InvalidImageType
     *
     * @return array ['path' => '', 'public' => '']
     */
    public static function getImagePath(Image $image, string $type, string $hash = null)
    {
        if (self::IMAGE_TYPE_CHARACTER !== $type
            && self::IMAGE_TYPE_LOCALE !== $type
            && self::IMAGE_TYPE_KEY_ITEM !== $type
            && self::IMAGE_TYPE_CONCEPT !== $type
            && self::IMAGE_TYPE_PROJECT !== $type
        ) {
            throw new InvalidImageType();
        }
        switch ($type) {
            case self::IMAGE_TYPE_CHARACTER:
                $pathImage = self::PATH_CHARACTERS;
                $publicImage = self::PUBLIC_CHARACTERS;

                break;
            case self::IMAGE_TYPE_KEY_ITEM:
                $pathImage = self::PATH_KEY_ITEMS;
                $publicImage = self::PUBLIC_KEY_ITEMS;

                break;
            case self::IMAGE_TYPE_LOCALE:
                $pathImage = self::PATH_LOCALES;
                $publicImage = self::PUBLIC_LOCALES;

                break;
            case self::IMAGE_TYPE_CONCEPT:
                $pathImage = self::PATH_CONCEPTS;
                $publicImage = self::PUBLIC_CONCEPTS;

                break;
            case self::IMAGE_TYPE_PROJECT:
                $pathImage = self::PATH_PROJECTS;
                $publicImage = self::PUBLIC_PROJECTS;

                break;
            default:
                throw new InvalidImageType();

                break;
        }

        $date = new \DateTime();
        $pathImage .= $date->format('/Y-m');
        $publicImage .= $date->format('/Y-m');
        if (false === file_exists($pathImage)) {
            mkdir($pathImage, 0755, true);
        }

        $hash = (null === $hash) ? bin2hex(random_bytes(10)) : $hash;
        $pathImage .= "/${hash}";
        $publicImage .= "/${hash}";

        $pathImage .= '.'.$image->getExtension();
        $publicImage .= '.'.$image->getExtension();

        return [
            'path' => $pathImage,
            'public' => $publicImage,
        ];
    }

    /**
     * Move an image to the web path.
     *
     * @param Image $image The image to be moved
     * @param string $hash The image hash
     * @param string $type One of the ImageProcessor::IMAGE_TYPE_* constants
     *
     * @throws InvalidImageType
     *
     * @return Image
     */
    public static function move(Image $image, string $type, string $hash = null)
    {
        $path = self::getImagePath($image, $type, $hash);
        $image
            ->setPath($path['path'])
            ->setWebPath($path['public']);
        if ('jpg' === $image->getExtension()) {
            $sourceImage = imagecreatefromjpeg($image->getOriginalPath());
        } else {
            $sourceImage = imagecreatefrompng($image->getOriginalPath());
        }
        $newImage = imagecreatetruecolor($image->getWidth(), $image->getHeight());
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        imagecopyresampled(
            $newImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $image->getWidth(),
            $image->getHeight(),
            $image->getOriginalWidth(),
            $image->getOriginalHeight()
        );
        if ('jpg' === $image->getExtension()) {
            imagejpeg($newImage, $image->getPath());
        } else {
            imagepng($newImage, $image->getPath());
        }
        $image->setMd5(md5_file($image->getPath()));

        return $image;
    }
}
