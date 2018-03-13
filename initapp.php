<?php

/**
 * Initialisations de l'application Silex + Twig
 */

/**
 * Application Silex 
 * @var Silex\Application $app
 */

$app = new Silex\Application ();

$app ['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/app.db',
    ),
));

$app->register(new Silex\Provider\SessionServiceProvider());

// Initialisations pour moteur de templates Twig
$app->register ( new Silex\Provider\TwigServiceProvider (), array (
    'twig.path' => __DIR__ . '/templates',
    'twig.options' => array (
        'debug' => true
    )
) );

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    $twig->addExtension(new \Twig_Extension_Debug());
    return $twig;
});

// Ajout de la fonction 'path' dans les templates Twig
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('path', function (...$url) use ($app) {
        return call_user_func_array(array(
            $app['url_generator'],
            'generate'
        ), $url);
    }));
    return $twig;
});

 return $app;
    