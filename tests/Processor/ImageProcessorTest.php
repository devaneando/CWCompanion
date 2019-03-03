<?php

namespace App\Tests\Traits;

use App\Model\Image;
use App\Processor\ImageProcessor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageProcessorTest extends KernelTestCase
{
    protected function getService(string $service)
    {
        $kernel = self::bootKernel();
        $service = self::$container->get($service);

        return $service;
    }

    public function testUpload()
    {
        $file = new \DateTime();
        $file = 'cmm_upload_test_'.$file->format('Ymd_his').'.png';
        $tmpFile = '/tmp/'.$file;
        copy(ImageProcessor::IMAGE_CHARACTER_MALE, $tmpFile);
        $uploaded = new UploadedFile($tmpFile, $file, null, null, true);
        /** @var ImageProcessor $imageProcessor */
        $imageProcessor = $this->getService('test.processor.image');
        $path = $imageProcessor->upload($uploaded);
        $this->assertTrue(file_exists($path));

        $image = $imageProcessor->get($path);
        $this->assertEquals(Image::class, get_class($image));

        $movedImage = $imageProcessor->move($image, ImageProcessor::IMAGE_TYPE_CHARACTER);
        $this->assertTrue(file_exists($movedImage->getPath()));
    }
}
