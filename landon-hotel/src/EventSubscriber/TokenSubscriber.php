<?php

namespace App\EventSubscriber;

use App\Controller\ApiController;
use App\Controller\TokenAuthenticatedController;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TokenSubscriber implements EventSubscriberInterface{
    
    /**
     * @var array
     */
    protected $tokens;

    public function __construct(){

        $this->tokens = [ 
            'user1' => 'token1',
            'user2' => 'token2'
        ];   
    }

    public function beforeController(ControllerEvent $event){
        $controller = $event->getController();
    
        // if it contains the controller that we were looking for so we can grab the token that's being sent by the http request from the event 
        if(is_array($controller) && $controller[0] instanceof TokenAuthenticatedController){
                // It will give us access to the query string where we can specify the key from that we wnt ( in our case 'token')
            $token = $event->getRequest()->query->get('token');
    
            if(!in_array($token, $this->tokens)){
    
                throw new AccessDeniedHttpException('This need a valid token');
            }
        }
    
    }

    
    public static function getSubscribedEvents(){
        return [
            // first subscriber
            kernelEvents::CONTROLLER => 'beforeController'
        ];
    }
 
}