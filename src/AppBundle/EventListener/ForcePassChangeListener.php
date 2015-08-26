<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class ForcePassChangeListener
{
    /** @var TokenStorage */
    private $tokenStorage;

    /** @var Router */
    private $router;

    /**
     * @param Router        $router
     * @param TokenStorage  $tokenStorage
     */
    public function __construct(Router $router, TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function check(GetResponseEvent $event)
    {
        if ($this->tokenStorage->getToken() && $this->tokenStorage->getToken()->isAuthenticated()
            && $this->tokenStorage->getToken()->getUser() instanceof User) {
            $routeName = $this->router->match($event->getRequest()->getPathInfo())['_route'];

            if ($routeName != 'fos_user_change_password') {
                $changed = $this->tokenStorage->getToken()->getUser()->isPasswordChanged();
                if (!$changed) {
                    $response = new RedirectResponse($this->router->generate('fos_user_change_password'));
                    $event->setResponse($response);
                }
            }
        }
    }
}
