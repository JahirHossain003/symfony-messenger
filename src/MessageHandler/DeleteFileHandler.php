<?php

namespace App\MessageHandler;

use App\Message\DeleteFile;
use App\Photo\PhotoFileManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteFileHandler implements MessageHandlerInterface
{
    /**
     * @var PhotoFileManager
     */
    private $photoManager;

    public function __construct(PhotoFileManager $photoManager)
    {
        $this->photoManager = $photoManager;
    }

    public function __invoke(DeleteFile $deleteFile)
    {
        $this->photoManager->deleteImage($deleteFile->getFilename());
    }
}