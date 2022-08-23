<?php

namespace App\Entity;


use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: true,options: ["default"=>false])]
    private bool $is_active = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active=false): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
