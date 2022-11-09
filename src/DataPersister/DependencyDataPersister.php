<?php

namespace App\DataPersister;


use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\DependencyRepository;

class DependencyDataPersister implements ProcessorInterface
{

    public function __construct(private DependencyRepository $repository)
    {
    }

    /**
     * Handle the state.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // if it's Delete operation
        if($operation instanceof DeleteOperationInterface)
        {
            $this->repository->remove($data);
            return true;
        }


        $this->repository->persist($data);
    }
}