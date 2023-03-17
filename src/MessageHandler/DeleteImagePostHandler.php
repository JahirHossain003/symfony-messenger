<?php

namespace App\MessageHandler;

use App\Message\DeleteFile;
use App\Message\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use App\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface
{
    private $messengerEvent;
    private $entityManager;

    public function __construct(MessageBusInterface $messengerEvent, EntityManagerInterface $entityManager)
    {
        $this->messengerEvent = $messengerEvent;
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $deleteImagePost->getImagePost();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->messengerEvent->dispatch(new ImagePostDeletedEvent($imagePost->getFilename()));
    }
}
