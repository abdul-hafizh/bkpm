<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'SimpleCMS\\Translation\\Cache\\CacheRepositoryInterface' => $baseDir . '/Cache/CacheRepositoryInterface.php',
    'SimpleCMS\\Translation\\Cache\\RepositoryFactory' => $baseDir . '/Cache/RepositoryFactory.php',
    'SimpleCMS\\Translation\\Cache\\SimpleRepository' => $baseDir . '/Cache/SimpleRepository.php',
    'SimpleCMS\\Translation\\Cache\\TaggedRepository' => $baseDir . '/Cache/TaggedRepository.php',
    'SimpleCMS\\Translation\\Commands\\CacheFlushCommand' => $baseDir . '/Commands/CacheFlushCommand.php',
    'SimpleCMS\\Translation\\Commands\\FileLoaderCommand' => $baseDir . '/Commands/FileLoaderCommand.php',
    'SimpleCMS\\Translation\\DataTables\\TranslationDataTable' => $baseDir . '/DataTables/TranslationDataTable.php',
    'SimpleCMS\\Translation\\Database\\Seeders\\TranslationDatabaseSeeder' => $baseDir . '/Database/Seeders/TranslationDatabaseSeeder.php',
    'SimpleCMS\\Translation\\Facades\\TranslationCache' => $baseDir . '/Facades/TranslationCache.php',
    'SimpleCMS\\Translation\\Facades\\UriLocalizer' => $baseDir . '/Facades/UriLocalizer.php',
    'SimpleCMS\\Translation\\Http\\Controllers\\TranslationController' => $baseDir . '/Http/Controllers/TranslationController.php',
    'SimpleCMS\\Translation\\Http\\Middleware\\CookieMiddleware' => $baseDir . '/Http/Middleware/CookieMiddleware.php',
    'SimpleCMS\\Translation\\Http\\Middleware\\TranslationMiddleware' => $baseDir . '/Http/Middleware/TranslationMiddleware.php',
    'SimpleCMS\\Translation\\Loaders\\CacheLoader' => $baseDir . '/Loaders/CacheLoader.php',
    'SimpleCMS\\Translation\\Loaders\\DatabaseLoader' => $baseDir . '/Loaders/DatabaseLoader.php',
    'SimpleCMS\\Translation\\Loaders\\FileLoader' => $baseDir . '/Loaders/FileLoader.php',
    'SimpleCMS\\Translation\\Loaders\\Loader' => $baseDir . '/Loaders/Loader.php',
    'SimpleCMS\\Translation\\Loaders\\MixedLoader' => $baseDir . '/Loaders/MixedLoader.php',
    'SimpleCMS\\Translation\\Models\\Language' => $baseDir . '/Models/Language.php',
    'SimpleCMS\\Translation\\Models\\Translation' => $baseDir . '/Models/Translation.php',
    'SimpleCMS\\Translation\\Providers\\RouteServiceProvider' => $baseDir . '/Providers/RouteServiceProvider.php',
    'SimpleCMS\\Translation\\Providers\\TranslationServiceProvider' => $baseDir . '/Providers/TranslationServiceProvider.php',
    'SimpleCMS\\Translation\\Repositories\\LanguageRepository' => $baseDir . '/Repositories/LanguageRepository.php',
    'SimpleCMS\\Translation\\Repositories\\Repository' => $baseDir . '/Repositories/Repository.php',
    'SimpleCMS\\Translation\\Repositories\\TranslationRepository' => $baseDir . '/Repositories/TranslationRepository.php',
    'SimpleCMS\\Translation\\Routes\\ResourceRegistrar' => $baseDir . '/Routes/ResourceRegistrar.php',
    'SimpleCMS\\Translation\\Traits\\Translatable' => $baseDir . '/Traits/Translatable.php',
    'SimpleCMS\\Translation\\Traits\\TranslatableObserver' => $baseDir . '/Traits/TranslatableObserver.php',
    'SimpleCMS\\Translation\\UriLocalizer' => $baseDir . '/UriLocalizer.php',
);
