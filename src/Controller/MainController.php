<?php

namespace App\Controller;

use App\Message\Query\GetTotalImageCount;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage(MessageBusInterface $queryBus): Response
    {
        $envelop = $queryBus->dispatch(new GetTotalImageCount());

        /** @var HandledStamp $handled */
        $handled = $envelop->last(HandledStamp::class);
        $imageCount = $handled->getResult();

        return $this->render('main/homepage.html.twig', [
            'totalImages' => $imageCount
        ]);
    }
}
