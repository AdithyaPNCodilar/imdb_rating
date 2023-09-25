<?php

namespace App\Controller;

use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;
use App\Form\RatingCommentType;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(MovieRepository $movieRepository, RatingRepository $ratingRepository): Response
    {
        // Fetch the currently authenticated user
        $user = $this->getUser();

        // Fetch movies
        $movies = $movieRepository->findAll();

        // Fetch user ratings if the user is authenticated
        $userRatings = [];
        if ($user) {
            $userRatings = $ratingRepository->findBy(['user' => $user]);
        }

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'userRatings' => $userRatings, // Pass user ratings to the template
        ]);
    }
}


















//
//namespace App\Controller;
//
//use App\Repository\RatingRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//use App\Repository\MovieRepository;
//use App\Form\RatingCommentType;
//
//class HomeController extends AbstractController
//{
//    #[Route('/home', name: 'home')]
//    public function index(MovieRepository $movieRepository): Response
//    {
//        $movies = $movieRepository->findAll();
//
//        return $this->render('home/index.html.twig', [
//            'movies' => $movies,
//        ]);
//    }
//
//}
