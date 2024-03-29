<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteafe542f162fbc7030c626f10a12728e
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Greatsami\\Mobilyws\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Greatsami\\Mobilyws\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteafe542f162fbc7030c626f10a12728e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteafe542f162fbc7030c626f10a12728e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
