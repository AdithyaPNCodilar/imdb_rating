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

        // Calculate average ratings for each movie
        $averageRatings = [];
        foreach ($movies as $movie) {
            $ratings = $ratingRepository->findBy(['movies' => $movie]);
            $totalRatings = count($ratings);
            $sumRatings = array_reduce($ratings, function ($carry, $rating) {
                return $carry + $rating->getRating();
            }, 0);
            $average = $totalRatings > 0 ? $sumRatings / $totalRatings : 0;
            $averageRatings[$movie->getId()] = $average;
        }

        // Fetch user ratings if the user is authenticated
        $userRatings = [];
        if ($user) {
            $userRatings = $ratingRepository->findBy(['user' => $user]);
        }

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'userRatings' => $userRatings,
            'averageRatings' => $averageRatings,
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
