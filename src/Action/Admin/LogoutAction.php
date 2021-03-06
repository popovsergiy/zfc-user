<?php

namespace Popov\ZfcUser\Action\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
#use Psr\Http\Server\RequestHandlerInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Stagem\ZfcAction\MiddlewareInterface;
use Popov\ZfcCore\Helper\UrlHelper;
use Popov\ZfcUser\Auth\Auth;
use Zend\Diactoros\Response\RedirectResponse;

class LogoutAction implements MiddlewareInterface
{
    use LogoutTrait;

    /** @var Auth */
    protected $auth;

    /** @var UrlHelper*/
    protected $urlHelper;

    public function __construct(
        Auth $auth,
        UrlHelper $urlHelper
    ) {
        $this->auth = $auth;
        $this->urlHelper = $urlHelper;
        $this->redirect['route'] = 'admin/default';
        $this->redirect['params'] = [
            'controller' => 'user',
            'action' => 'login',
        ];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->logout();

        $url = $this->urlHelper->generate($this->redirect['route'], $this->redirect['params']);

        return new RedirectResponse($url);
    }
}