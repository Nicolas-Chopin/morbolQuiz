<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
    private $text;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $orderInNuggets;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $orderInSaltpepper;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $orderInMenu;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $orderInSum;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $orderInDeathquiz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="questions")
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", cascade={"persist", "remove"})
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getOrderInNuggets(): ?int
    {
        return $this->orderInNuggets;
    }

    public function setOrderInNuggets(?int $orderInNuggets): self
    {
        $this->orderInNuggets = $orderInNuggets;

        return $this;
    }

    public function getOrderInSaltpepper(): ?int
    {
        return $this->orderInSaltpepper;
    }

    public function setOrderInSaltpepper(?int $orderInSaltpepper): self
    {
        $this->orderInSaltpepper = $orderInSaltpepper;

        return $this;
    }

    public function getOrderInMenu(): ?int
    {
        return $this->orderInMenu;
    }

    public function setOrderInMenu(?int $orderInMenu): self
    {
        $this->orderInMenu = $orderInMenu;

        return $this;
    }

    public function getOrderInSum(): ?int
    {
        return $this->orderInSum;
    }

    public function setOrderInSum(?int $orderInSum): self
    {
        $this->orderInSum = $orderInSum;

        return $this;
    }

    public function getOrderInDeathquiz(): ?int
    {
        return $this->orderInDeathquiz;
    }

    public function setOrderInDeathquiz(?int $orderInDeathquiz): self
    {
        $this->orderInDeathquiz = $orderInDeathquiz;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
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
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }
}
