<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="session")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="session")
     */
    private $menus;

    /**
     * @ORM\OneToOne(targetEntity=TeamA::class, mappedBy="session", cascade={"persist", "remove"})
     */
    private $teamA;

    /**
     * @ORM\OneToOne(targetEntity=TeamB::class, mappedBy="session", cascade={"persist", "remove"})
     */
    private $teamB;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sessions")
     */
    private $user;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setSession($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getSession() === $this) {
                $question->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setSession($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getSession() === $this) {
                $menu->setSession(null);
            }
        }

        return $this;
    }

    public function getTeamA(): ?TeamA
    {
        return $this->teamA;
    }

    public function setTeamA(?TeamA $teamA): self
    {
        $this->teamA = $teamA;

        // set (or unset) the owning side of the relation if necessary
        $newSession = null === $teamA ? null : $this;
        if ($teamA->getSession() !== $newSession) {
            $teamA->setSession($newSession);
        }

        return $this;
    }

    public function getTeamB(): ?TeamB
    {
        return $this->teamB;
    }

    public function setTeamB(?TeamB $teamB): self
    {
        $this->teamB = $teamB;

        // set (or unset) the owning side of the relation if necessary
        $newSession = null === $teamB ? null : $this;
        if ($teamB->getSession() !== $newSession) {
            $teamB->setSession($newSession);
        }

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
}
