<?php

namespace App\Entity\Traits;

use App\Model\Image;
use App\Processor\ImageProcessor;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait PictureTrait
{
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture = null): self
    {
        $this->picture = trim($picture);

        return $this;
    }

    public function getUploadedPicture(): ?string
    {
        return $this->picture;
    }

    public function setUploadedPicture(UploadedFile $uploadedPicture = null): self
    {
        if (null === $uploadedPicture) {
            return $this;
        }

        /** @var Image $image */
        $image = ImageProcessor::get(ImageProcessor::upload($uploadedPicture));
        $image = ImageProcessor::move($image, ImageProcessor::IMAGE_TYPE_LOCALE, $this->getId());
        $this->picture = $image->getWebPath();

        return $this;
    }
}
