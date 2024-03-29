<?php

namespace App\MessageHandler\Command;

use App\Message\Command\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface
{
    private $eventBus;
    private $entityManager;

    public function __construct(MessageBusInterface $eventBus, EntityManagerInterface $entityManager)
    {
        $this->eventBus = $eventBus;
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $deleteImagePost->getImagePost();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->eventBus->dispatch(new ImagePostDeletedEvent($imagePost->getFilename()));
    }
}
