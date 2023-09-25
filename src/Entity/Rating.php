<?php

namespace App\Entity;

use App\Entity\User;
use  App\Entity\Movies;
use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $review = null;

    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    #[ORM\JoinColumn(name: "movie_id", referencedColumnName: "id")]
    #[ORM\ManyToOne(targetEntity: Movies::class)]
    private ?Movies $movies;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(string $review): static
    {
        $this->review = $review;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }


    public function getMovie(): ?Movies
    {
        return $this->movies;
    }

    public function setMovie(?Movies $movies): self
    {
        $this->movies = $movies;
        return $this;
    }
}
