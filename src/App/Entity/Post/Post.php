<?php

namespace App\Entity\Post;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'posts')]
class Post
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[ORM\Column(name: 'create_date', type: 'datetime_immutable')]
    private \DateTimeImmutable $createDate;
    #[ORM\Column(name: 'update_date', type: 'datetime_immutable', nullable: true)]
    private \DateTimeImmutable $updateDate;
    #[ORM\Column(type: 'string')]
    private string $title;
    #[ORM\Embedded(class: Content::class)]
    private Content $content;
    #[ORM\Embedded(class: Meta::class)]
    private Meta $meta;
    /**
     * @var ArrayCollection|Comment[]
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post', orphanRemoval: true, cascade: ['persist'])]
    private ArrayCollection $comments;

    public function __construct(\DateTimeImmutable $date, string $title, Content $content, Meta $meta)
    {
        $this->createDate = $date;
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->comments = new ArrayCollection();
    }

    public function edit(string $title, Content $content, Meta $meta): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->updateDate = new \DateTimeImmutable();
    }

    public function addComment(\DateTimeImmutable $date, string $author, string $content): void
    {
        $this->comments->add(new Comment($this, $date, $author, $content));
    }

    public function removeComment(int $id): void
    {
        foreach ($this->comments as $comment) {
            if ($comment->getId() === $id) {
                $this->comments->removeElement($comment);
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    public function getUpdateDate(): \DateTimeImmutable
    {
        return $this->updateDate;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }
}