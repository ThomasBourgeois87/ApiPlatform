<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as PostAlias;
use ApiPlatform\Metadata\Put;
use App\Controller\PostCountController;
use App\Controller\PostPublishController;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: PostRepository::class)]
// /post/count GET renvoie le nombre total d'articles qui sont sur le site


#[ApiResource
(
    operations:
    [
        new PostAlias
        (
            uriTemplate: '/posts/{id}/publish',
            controller: PostPublishController::class,
            openapiContext:
            [
                'summary' => 'Permit to publish an article',
                'requestBody' =>
                [
                    'content' => ['application/json' => [ 'schema' => ['type' => 'object'] ] ]
                ]
            ],
            name: 'Publish'
        ),
        new Get
        (
            uriTemplate: '/post/count',
            controller: PostCountController::class,
            openapiContext:
            [
                'summary' => 'Get total number of posts',
                'parameters' =>
                [
                    [
                        'in' => 'query',
                        'name' => 'online',
                        'schema' =>
                        [
                            'type' => 'integer',
                            'maximum' => 1,
                            'minimum' => 0,
                        ],
                        'description' => 'Filter online articles Test',
                    ],
                ],
                'responses' =>
                [
                        200 =>
                        [
                                'description' => 'Done',
                        'content' =>
                        [
                                'application/json' =>
                                [
                                        'schema' => ['type' => 'integer', 'example' => '3']
                                ]
                        ]
                        ],
                ]
            ],
            paginationEnabled: false,
            filters: [],
            read: false,
            name: 'count'
        )
    ],
    normalizationContext: ['groups' => ['read:collection'], 'openapi_definition_name' => 'Collection'],
    denormalizationContext: ['groups' => ['write:Post']],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2,
)]

#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'partial'])]

#[Get
(
    normalizationContext: ['groups' => ['read:collection', 'read:item', 'read:Post'], 'openapi_definition_name' => 'Details']
)]

#[GetCollection()]

#[PostAlias
(

)]

#[Put
(

)]

#[Delete()]

class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Groups(['read:collection', 'write:Post']),
        Length(min: 5)
    ]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'write:Post'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:item', 'write:Post'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['read:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts', cascade: ['persist'])]
    #[
        Groups(['read:item', 'write:Post']),
        Valid()
    ]
    private ?Category $category = null;

    #[ORM\Column(options: ['default' => 0])]
    #[ApiProperty
    (
        openapiContext: ['type' => 'boolean', 'description' => 'Set online or not a Post']
    )]
    private ?bool $online = false;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
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

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}
