<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * 1) Fonction publique dans un Controller
     * 2) Route
     * 3) Reponse
     */

     /**
      * @Route("/hello/{prenom}", name="hello")
      */
     public function hello($prenom = "") {
        return new Response("Hello " . $prenom);
     }

     /**
      * @Route("/", name="home")
      *
      */
     public function home(AdRepository $adRepository, UserRepository $userRepository) {
        //dump($userRepository->findBestUsers(2));
        //die();
        return $this->render(
            'home.html.twig',
            [
               'ads' => $adRepository->findBestAds(3),
               'users' =>  $userRepository->findBestUsers(2)
            ]
        );
     }

}