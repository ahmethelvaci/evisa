<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

require __DIR__ . '/vendor'.'/autoload.php';

define('DIR_TEMP', __DIR__ . '/temp');
define('DIR_PDF', __DIR__ . '/pdf');
define('EVISA', 'https://www.evisa.gov.tr');
define('EVISA_URL', EVISA . '/tr/status/');
define('SITE_URL', 'http://localhost/evisa/');
define('SECOND_SITE', 'http://localhost/evisa/');

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;
$app->register(new Silex\Provider\SessionServiceProvider());

$app->get('/', function () use ($app)
{
    $resourceRow = file_get_contents('resourceRow');
    $app['session']->set('resourceRow', $resourceRow);
    $search = new Evisa\Search();
    $app['session']->set('inputs', $search->getInputs());
    require __DIR__ . '/template.php';
    return false;
});


$app->post('/', function (Request $request) use ($app)
{
    require '_resource.php';
    $find = new Evisa\Find();
    $find->setInputs($app['session']->get('inputs'));
    $find->setCaptcha($request->get("captcha"));
    $find->setResource(new Resource());
    $resourceRow = $find->find($app['session']->get('resourceRow'));
    $app['session']->set('resourceRow', $resourceRow);
    file_put_contents('resourceRow', $resourceRow);
    file_get_contents(SECOND_SITE . 'set/' . $resourceRow);
    return $app->redirect(SITE_URL);
});

$app->get('/setzero/', function () use ($app)
{
    $app['session']->set('resourceRow', 0);
    return false;
});

$app->get('/set/{id}', function ($id) use ($app)
{
    $app['session']->set('resourceRow', (int) $id);
    file_put_contents('resourceRow', (int) $id);
    return $app->redirect(SITE_URL);
});

$app->get('/get/', function () use ($app)
{
    echo $app['session']->get('resourceRow');
    return false;
});

$app->run();
