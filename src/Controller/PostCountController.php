<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class PostCountController extends AbstractController
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function __invoke(Request $request): int
    {
        $onlineQuery = $request->get('online');
        $conditions = [];

        if($onlineQuery !== null) {
            $conditions = ['online' => $onlineQuery === '1'];
        }


        return $this->postRepository->count($conditions);
    }
}