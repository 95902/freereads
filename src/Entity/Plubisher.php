<?php

namespace App\Entity;

use App\Entity\Trait\idNameTrait;
use App\Repository\PlubisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlubisherRepository::class)]
class Plubisher
{
    use idNameTrait;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'publishers')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addPublisher($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removePublisher($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
