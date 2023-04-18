<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4a64ed8b8ec0db2cdc8f43cf841f5357
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4a64ed8b8ec0db2cdc8f43cf841f5357::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4a64ed8b8ec0db2cdc8f43cf841f5357::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4a64ed8b8ec0db2cdc8f43cf841f5357::$classMap;

        }, null, ClassLoader::class);
    }
}