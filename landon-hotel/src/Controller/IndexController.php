<?php

namespace App\Controller;

use App\Entity\Hotel;
use Psr\Log\LoggerInterface;
use App\Service\RandomNumberGenerator;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class IndexController extends AbstractController implements TokenAuthenticatedController {

    /**
     * @Route("/")
     */
    public function home(LoggerInterface $logger, RandomNumberGenerator $rndNumGen){

        $year = $rndNumGen->getRandomNymber();


        $hotels = $this->getDoctrine()
            ->getRepository(Hotel::class)
            ->findAllBelowPrice(100);


        $logger->info('Jdot');

        return $this->render('index.html.twig', [
            'year' => $year,
            'hotels' => $hotels,
        ]);

    }
}