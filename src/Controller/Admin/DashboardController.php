<?php

namespace App\Controller\Admin;

use App\Entity\Rating;
use App\Form\RatingCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MovieType;
use App\Entity\Movies;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RatingRepository;

class DashboardController extends AbstractController
{

    #[Route('/admin', name: 'dashboard')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/admin', name: 'add_movie')]
    public function addMovie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movies();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/addmovie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/delete-movie/{id}', name: 'delete_movie')]
    public function deleteMovie(Movies $movie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($movie);
        $entityManager->flush();

        return $this->redirectToRoute('dashboard');
    }

    #[Route('/admin/edit/{id}', name: 'edit_movie')]
    public function editMovie(Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $movie = $movieRepository->find($id);

        if (!$movie) {
            return $this->redirectToRoute('dashboard');
        } else {
            $form = $this->createForm(MovieType::class, $movie);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('dashboard');
            }

            return $this->render('admin/editmovie.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/admin', name: 'view-rating', methods: ['GET'])]
    public function showMovie(RatingRepository $ratingRepository): Response
    {
        $rating = $ratingRepository->findAll();
        return $this->render('admin/viewratings.html.twig', [
            'rating' => $rating,
        ]);
    }

    #[Route('/admin/delete-rating/{id}', name: 'delete-rating')]
    public function deleteRating(Rating $rating, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($rating);
        $entityManager->flush();

        return $this->redirectToRoute('view-rating');
    }

    #[Route('/admin/edit-rating/{id}', name: 'edit-rating')]
    public function editRating(Request $request, RatingRepository $ratingRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $rating = $ratingRepository->find($id);

        if (!$rating) {
            return $this->redirectToRoute('view-rating');
        } else {
            $form = $this->createForm(RatingCommentType::class, $rating);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('view-rating');
            }

            return $this->render('admin/editrating.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
