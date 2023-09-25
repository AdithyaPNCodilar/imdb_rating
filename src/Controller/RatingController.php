<?php


namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingCommentType;
use App\Repository\MovieRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RatingController extends AbstractController
{
    #[Route('/rate-movie/{movieId}', name: 'rate-movie')]
    public function rateMovie(Request $request, $movieId, EntityManagerInterface $entityManager, MovieRepository $movieRepository): Response
    {
        $rating = new Rating();

        $form = $this->createForm(RatingCommentType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $rating->setUser($user);

            $movie = $movieRepository->find($movieId);

            $rating->setMovie($movie);

            $entityManager->persist($rating);
            $entityManager->flush();

            return $this->redirectToRoute('home', ['id' => $movieId]);
        }

        return $this->render('home/ratemovie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
