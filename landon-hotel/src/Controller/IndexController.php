<?php

namespace App\Controller;

use App\Service\RandomNumberGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController {

    /**
     * @Route("/")
     */
    public function home(LoggerInterface $logger, RandomNumberGenerator $rndNumGen){

        $year = $rndNumGen->getRandomNymber();

        $logger->info('Jdot');

        return $this->render('index.html.twig', [
            'year' => $year
        ]);

    }
}