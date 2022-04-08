<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit346d39410d414012892cc1786f675b86
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SimpleCMS\\Translation\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SimpleCMS\\Translation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'SimpleCMS\\Translation\\Cache\\CacheRepositoryInterface' => __DIR__ . '/../..' . '/Cache/CacheRepositoryInterface.php',
        'SimpleCMS\\Translation\\Cache\\RepositoryFactory' => __DIR__ . '/../..' . '/Cache/RepositoryFactory.php',
        'SimpleCMS\\Translation\\Cache\\SimpleRepository' => __DIR__ . '/../..' . '/Cache/SimpleRepository.php',
        'SimpleCMS\\Translation\\Cache\\TaggedRepository' => __DIR__ . '/../..' . '/Cache/TaggedRepository.php',
        'SimpleCMS\\Translation\\Commands\\CacheFlushCommand' => __DIR__ . '/../..' . '/Commands/CacheFlushCommand.php',
        'SimpleCMS\\Translation\\Commands\\FileLoaderCommand' => __DIR__ . '/../..' . '/Commands/FileLoaderCommand.php',
        'SimpleCMS\\Translation\\DataTables\\TranslationDataTable' => __DIR__ . '/../..' . '/DataTables/TranslationDataTable.php',
        'SimpleCMS\\Translation\\Database\\Seeders\\TranslationDatabaseSeeder' => __DIR__ . '/../..' . '/Database/Seeders/TranslationDatabaseSeeder.php',
        'SimpleCMS\\Translation\\Facades\\TranslationCache' => __DIR__ . '/../..' . '/Facades/TranslationCache.php',
        'SimpleCMS\\Translation\\Facades\\UriLocalizer' => __DIR__ . '/../..' . '/Facades/UriLocalizer.php',
        'SimpleCMS\\Translation\\Http\\Controllers\\TranslationController' => __DIR__ . '/../..' . '/Http/Controllers/TranslationController.php',
        'SimpleCMS\\Translation\\Http\\Middleware\\CookieMiddleware' => __DIR__ . '/../..' . '/Http/Middleware/CookieMiddleware.php',
        'SimpleCMS\\Translation\\Http\\Middleware\\TranslationMiddleware' => __DIR__ . '/../..' . '/Http/Middleware/TranslationMiddleware.php',
        'SimpleCMS\\Translation\\Loaders\\CacheLoader' => __DIR__ . '/../..' . '/Loaders/CacheLoader.php',
        'SimpleCMS\\Translation\\Loaders\\DatabaseLoader' => __DIR__ . '/../..' . '/Loaders/DatabaseLoader.php',
        'SimpleCMS\\Translation\\Loaders\\FileLoader' => __DIR__ . '/../..' . '/Loaders/FileLoader.php',
        'SimpleCMS\\Translation\\Loaders\\Loader' => __DIR__ . '/../..' . '/Loaders/Loader.php',
        'SimpleCMS\\Translation\\Loaders\\MixedLoader' => __DIR__ . '/../..' . '/Loaders/MixedLoader.php',
        'SimpleCMS\\Translation\\Models\\Language' => __DIR__ . '/../..' . '/Models/Language.php',
        'SimpleCMS\\Translation\\Models\\Translation' => __DIR__ . '/../..' . '/Models/Translation.php',
        'SimpleCMS\\Translation\\Providers\\RouteServiceProvider' => __DIR__ . '/../..' . '/Providers/RouteServiceProvider.php',
        'SimpleCMS\\Translation\\Providers\\TranslationServiceProvider' => __DIR__ . '/../..' . '/Providers/TranslationServiceProvider.php',
        'SimpleCMS\\Translation\\Repositories\\LanguageRepository' => __DIR__ . '/../..' . '/Repositories/LanguageRepository.php',
        'SimpleCMS\\Translation\\Repositories\\Repository' => __DIR__ . '/../..' . '/Repositories/Repository.php',
        'SimpleCMS\\Translation\\Repositories\\TranslationRepository' => __DIR__ . '/../..' . '/Repositories/TranslationRepository.php',
        'SimpleCMS\\Translation\\Routes\\ResourceRegistrar' => __DIR__ . '/../..' . '/Routes/ResourceRegistrar.php',
        'SimpleCMS\\Translation\\Traits\\Translatable' => __DIR__ . '/../..' . '/Traits/Translatable.php',
        'SimpleCMS\\Translation\\Traits\\TranslatableObserver' => __DIR__ . '/../..' . '/Traits/TranslatableObserver.php',
        'SimpleCMS\\Translation\\UriLocalizer' => __DIR__ . '/../..' . '/UriLocalizer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit346d39410d414012892cc1786f675b86::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit346d39410d414012892cc1786f675b86::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit346d39410d414012892cc1786f675b86::$classMap;

        }, null, ClassLoader::class);
    }
}
