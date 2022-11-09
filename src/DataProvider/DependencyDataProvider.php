<?php

namespace App\DataProvider;



use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Encoder\ContextAwareDecoderInterface;
use Symfony\Component\VarDumper\Dumper\ContextProvider\ContextProviderInterface;

class DependencyDataProvider implements ProviderInterface
{

    public function __construct(private DependencyRepository $repository)
    {
    }


    /**
     * Provides data.
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // if it's GetCollection operation
        if($operation instanceof CollectionOperationInterface) {
            return $this->repository->findAll();
        }
        else
        {
            return $this->repository->find( $uriVariables['uuid'] );
        }
    }
}