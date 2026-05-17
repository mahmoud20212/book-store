<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Alignment;
use Intervention\Image\Format;

trait ImageUploadTrait
{
  protected $imagePath = 'app/public/images/covers';
  protected $imgHeight = 600;
  protected $imgWidth = 600;

  public function uploadImage($img)
  {
    $imgName = $this->imageName($img);
    $manager = new ImageManager(new Driver());
    $image = $manager->read($img);
    $image->scale(
      width: $this->imgWidth,
      height: $this->imgHeight,
    );

    $image->toJpeg()->save(
      storage_path($this->imagePath . '/' . $imgName)
    );

    return "images/covers/" . $imgName;
  }

  public function imageName($image)
  {
    $extension = $image->getClientOriginalExtension();
    return time() . '-' . $extension;
  }
}
