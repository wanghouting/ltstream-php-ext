<?php
/**
 * Created by PhpStorm.
 * User: wanghouting
 * Date: 2019-06-14
 * Time: 13:40
 */
use Illuminate\Routing\Router;

Route::group([
    'namespace' => "LTStream\\Extension\\Controllers",
    'prefix' => 'ltstream',
    'middleware' => []
], function (Router $router) {
    $router->get('callback', 'LTStreamCallbackController@callback');
});
