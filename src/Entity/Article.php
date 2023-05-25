<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks
 */

class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */

    //  /** @Assert\Length(
    //  * min:20,
    //  * max:255,
    //  * minMessage: 'Title must be at least {{ limit }} characters long',
    //  * maxMessage: 'Your first name cannot be longer than {{ limit }} characters'
    //   */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $intro;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

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

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    /** 
     * Genére un slug automatiquement
     * @ORM\PrePersist
     * @return void 
     */  

    public function initSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->getTitle() . time() . hash( "sha1" , $this->getIntro()));
        }
    }

    /** 
     * Genére un slug automatiquement
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void 
     */

    public function updateDate(){
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }



}
