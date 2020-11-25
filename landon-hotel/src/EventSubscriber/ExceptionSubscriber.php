<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface {

    public function onException(ExceptionEvent $event){
        
        $e = $event->getThrowable();
    
        //if the exception isn't an instanceof AccessDeniedHttpException then we just return !    
        if(!$e instanceof AccessDeniedHttpException){
            return;
        }
        else{
    
            $responseData = ['error' => $e->getMessage()];
            $response = new JsonResponse($responseData);
    
            // We can then send it back and get back our repsonse object
            $event->setResponse($response);
    
        }
    }
    
    public static function getSubscribedEvents(){

        return [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

}