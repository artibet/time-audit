<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class NestedPathGenerator implements PathGenerator
{
  /**
   * Get the path for the given media, sharding the ID into subfolders.
   * Example: ID 123456 becomes "12/34/56/123456/"
   */
  public function getPath(Media $media): string
  {
    // Pad the ID to ensure consistent folder depth 
    $paddedId = str_pad($media->id, 8, '0', STR_PAD_LEFT);

    // Split the ID into chunks of 2 to create the directory levels
    // '123456' -> ['12', '34', '56', '78']
    $parts = str_split($paddedId, 2);

    // Join the parts with slashes and add the specific media ID folder at the end
    return implode('/', $parts) . '/' . $media->id . '/';
  }

  /**
   * Get the path for conversions of the given media.
   */
  public function getPathForConversions(Media $media): string
  {
    return $this->getPath($media) . 'conversions/';
  }

  /**
   * Get the path for responsive images of the given media.
   */
  public function getPathForResponsiveImages(Media $media): string
  {
    return $this->getPath($media) . 'responsive-images/';
  }
}
