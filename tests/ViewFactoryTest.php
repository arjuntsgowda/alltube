<?php

/**
 * ViewFactoryTest class.
 */

namespace Alltube\Test;

use Alltube\Exception\DependencyException;
use Alltube\Factory\LocaleManagerFactory;
use Alltube\Factory\SessionFactory;
use Alltube\Factory\ViewFactory;
use Slim\Container;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Views\Smarty;
use SmartyException;

/**
 * Unit tests for the ViewFactory class.
 */
class ViewFactoryTest extends BaseTest
{
    /**
     * Test the create() function.
     *
     * @return void
     * @throws SmartyException
     * @throws DependencyException
     */
    public function testCreate()
    {
        $container = new Container();
        $container['session'] = SessionFactory::create($container);
        $container['locale'] = LocaleManagerFactory::create($container);
        $view = ViewFactory::create($container);
        $this->assertInstanceOf(Smarty::class, $view);
    }

    /**
     * Test the create() function with a X-Forwarded-Proto header.
     *
     * @return void
     * @throws SmartyException
     * @throws DependencyException
     */
    public function testCreateWithXForwardedProto()
    {
        $container = new Container();
        $container['session'] = SessionFactory::create($container);
        $container['locale'] = LocaleManagerFactory::create($container);
        $request = Request::createFromEnvironment(Environment::mock());
        $view = ViewFactory::create($container, $request->withHeader('X-Forwarded-Proto', 'https'));
        $this->assertInstanceOf(Smarty::class, $view);
    }
}
