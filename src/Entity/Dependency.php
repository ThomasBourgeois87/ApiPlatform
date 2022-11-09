<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as PostAlias;
use ApiPlatform\Metadata\Put;
use App\DataPersister\DependencyDataPersister;
use App\DataProvider\DependencyDataProvider;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(provider: DependencyDataProvider::class, processor: DependencyDataPersister::class)]

#[GetCollection
(
    paginationEnabled: false,
)]

#[Get
(

)]

#[PostAlias
(

)]

#[Put
(
    denormalizationContext: ['groups' => ['put:Dependency']]
)]


#[Delete()]


class Dependency
{
    #[ApiProperty(identifier: true)]
    private string $uuid;

    #[
        ApiProperty(description: 'Dependency name'),
        Length(min: 2),
        NotBlank(),
    ]
    private string $name;

    #[
        ApiProperty
        (
            description: 'Dependency version',
            openapiContext:
            [
                'example' => '6.1.*'
            ]
        ),
        Length(min: 2),
        NotBlank(),
        Groups(['put:Dependency'])
    ]
    private string $version;


    public function __construct(string $name, string $version)
    {
        $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
        $this->name = $name;
        $this->version = $version;
    }


    public function getUuid(): string
    {
        return $this->uuid;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getVersion(): string
    {
        return $this->version;
    }


    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
}