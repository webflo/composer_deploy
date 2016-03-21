<?php

/**
 * @file
 * Contains \Drupal\composer_deploy\ComposerDeployHanlder.
 */

namespace Drupal\composer_deploy;

use ReflectionClass;

class ComposerDeployHandler {

  protected $packages;

  public function __construct($path) {
    $this->packages = json_decode(file_get_contents($path), TRUE);
  }

  public function getPackage($projectName) {
    foreach ($this->packages as $package) {
      if ($package['name'] == 'drupal/' . $projectName) {
        return $package;
      }
    }
    return FALSE;
  }

  public static function fromAutoloader() {
    $autoloader = require \Drupal::root() . '/autoload.php';
    $reflector = new ReflectionClass($autoloader);
    $vendor_dir = dirname(dirname($reflector->getFileName()));
    return new static($vendor_dir . '/composer/installed.json');
  }

}
