<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1510af8c1bdd148fb6558ce04caee5a0
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Respect\\Validation\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Respect\\Validation\\' => 
        array (
            0 => __DIR__ . '/..' . '/respect/validation/library',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'lib\\apiClass' => __DIR__ . '/../..' . '/lib/apiClass.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1510af8c1bdd148fb6558ce04caee5a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1510af8c1bdd148fb6558ce04caee5a0::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit1510af8c1bdd148fb6558ce04caee5a0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit1510af8c1bdd148fb6558ce04caee5a0::$classMap;

        }, null, ClassLoader::class);
    }
}
