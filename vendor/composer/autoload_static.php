<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4b4b13363bed9d463df60bf3261cb13b
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Asset\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Asset\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/asset',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4b4b13363bed9d463df60bf3261cb13b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4b4b13363bed9d463df60bf3261cb13b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4b4b13363bed9d463df60bf3261cb13b::$classMap;

        }, null, ClassLoader::class);
    }
}