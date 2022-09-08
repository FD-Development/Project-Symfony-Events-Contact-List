<?php

/** Kernel */

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Kernel class.
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
