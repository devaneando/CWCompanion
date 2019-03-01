<?php

namespace App\Model;

class Image
{
    /** @var int */
    public $height;

    /** @var int */
    private $originalHeight;

    /** @var int */
    public $width;

    /** @var int */
    private $originalWidth;

    /** @var string */
    public $webPath;

    /** @var string */
    public $path;

    /** @var string */
    public $originalPath;

    /** @var string */
    public $md5;

    /** @var string */
    private $baseName;

    /** @var string */
    private $dirName;

    /** @var string */
    private $extension;

    /** @var float */
    private $percentage;

    /** @return int */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return self
     */
    public function setHeight(int $height)
    {
        $this->height = $height;

        return $this;
    }

    /** @return int */
    public function getOriginalHeight()
    {
        return $this->originalHeight;
    }

    /**
     * @param int $originalHeight
     *
     * @return self
     */
    public function setOriginalHeight(int $originalHeight)
    {
        $this->originalHeight = $originalHeight;

        return $this;
    }

    /** @return int */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return self
     */
    public function setWidth(int $width)
    {
        $this->width = $width;

        return $this;
    }

    /** @return int */
    public function getOriginalWidth()
    {
        return $this->originalWidth;
    }

    /**
     * @param int $originalWidth
     *
     * @return self
     */
    public function setOriginalWidth(int $originalWidth)
    {
        $this->originalWidth = $originalWidth;

        return $this;
    }

    /** @return string */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * @param string $webPath
     *
     * @return self
     */
    public function setWebPath(string $webPath)
    {
        $this->webPath = $webPath;

        return $this;
    }

    /** @return string */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /** @return string */
    public function getOriginalPath()
    {
        return $this->originalPath;
    }

    /**
     * @param string $originalPath
     *
     * @return self
     */
    public function setOriginalPath(string $originalPath)
    {
        $this->originalPath = $originalPath;

        return $this;
    }

    /** @return string */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * @param string $md5
     *
     * @return self
     */
    public function setMd5(string $md5)
    {
        $this->md5 = $md5;

        return $this;
    }

    /** @return string */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * @param string $baseName
     *
     * @return self
     */
    public function setBaseName(string $baseName)
    {
        $this->baseName = $baseName;

        return $this;
    }

    /** @return string */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * @param string $dirName
     *
     * @return self
     */
    public function setDirName(string $dirName)
    {
        $this->dirName = $dirName;

        return $this;
    }

    /** @return string */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     *
     * @return self
     */
    public function setExtension(string $extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /** @return float */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     *
     * @return self
     */
    public function setPercentage(float $percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }
}
