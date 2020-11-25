<?php

namespace App\EventSubscriber;

use App\Controller\ApiController;
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

        // Inside the array, this will be data from users token from de database
        // We gonna hardcode this for our purpose for the moment 

        $this->tokens = [ 
            'user1' => 'token1',
            'user2' => 'token2'
        ];   
    }

    // Middleware to manage http req - res lyfecycle events
    public function beforeController(ControllerEvent $event){
        $controller = $event->getController();
    
        // check if that contains an array and check the controller itself contain the controller we were expecting
        // if it contains the controller that we were looking for so we can grab the token that's being sent by the http request from the event 
        if(is_array($controller) && $controller[0] instanceof ApiController){
                // It will give us access to the query string where we can specify the key from that we wnt ( in our case 'token')
            $token = $event->getRequest()->query->get('token');
    
            // We got the token it's being sent as part of the HTTP request and we just need to validate that token is the array of valid tokens
            if(!in_array($token, $this->tokens)){
                // cancel the HTTP request and send back a denied response 
                throw new AccessDeniedHttpException('This need a valid token');
            }
        }
    
    }
    // Return an array of key value pairs 
    // key name of the method tha we're subscribing
    // value: name of the methodthat we would run when the method trigger
    // The class KernelEvents contains a list of constant with the event name in that 
    public static function getSubscribedEvents(){
        return [
            // first subscriber
            kernelEvents::CONTROLLER => 'beforeController'
        ];
    }
 
}