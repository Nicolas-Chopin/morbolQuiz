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
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="session", cascade={"persist", "remove"})
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="session", cascade={"persist", "remove"})
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sessions")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sorpName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sumName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aTeamName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bTeamName;

    /**
     * @ORM\Column(type="smallint")
     */
    private $aTeamScore;

    /**
     * @ORM\Column(type="smallint")
     */
    private $bTeamScore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aTeamImgUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bTeamImgUrl;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="session")
     */
    private $answers;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSorpName(): ?string
    {
        return $this->sorpName;
    }

    public function setSorpName(string $sorpName): self
    {
        $this->sorpName = $sorpName;

        return $this;
    }

    public function getSumName(): ?string
    {
        return $this->sumName;
    }

    public function setSumName(string $sumName): self
    {
        $this->sumName = $sumName;

        return $this;
    }

    public function getATeamName(): ?string
    {
        return $this->aTeamName;
    }

    public function setATeamName(string $aTeamName): self
    {
        $this->aTeamName = $aTeamName;

        return $this;
    }

    public function getBTeamName(): ?string
    {
        return $this->bTeamName;
    }

    public function setBTeamName(string $bTeamName): self
    {
        $this->bTeamName = $bTeamName;

        return $this;
    }

    public function getATeamScore(): ?int
    {
        return $this->aTeamScore;
    }

    public function setATeamScore(int $aTeamScore): self
    {
        $this->aTeamScore = $aTeamScore;

        return $this;
    }

    public function getBTeamScore(): ?int
    {
        return $this->bTeamScore;
    }

    public function setBTeamScore(int $bTeamScore): self
    {
        $this->bTeamScore = $bTeamScore;

        return $this;
    }

    public function getATeamImgUrl(): ?string
    {
        return $this->aTeamImgUrl;
    }

    public function setATeamImgUrl(?string $aTeamImgUrl): self
    {
        $this->aTeamImgUrl = $aTeamImgUrl;

        return $this;
    }

    public function getBTeamImgUrl(): ?string
    {
        return $this->bTeamImgUrl;
    }

    public function setBTeamImgUrl(?string $bTeamImgUrl): self
    {
        $this->bTeamImgUrl = $bTeamImgUrl;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setSession($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getSession() === $this) {
                $answer->setSession(null);
            }
        }

        return $this;
    }
}
