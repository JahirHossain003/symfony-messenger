<?php

namespace App\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class AuditMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $messengerAudit;

    public function __construct(LoggerInterface $messengerAudit)
    {

        $this->messengerAudit = $messengerAudit;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null == $envelope->last(UniqueIdStamp::class)) {
            $envelope = $envelope->with(new UniqueIdStamp());
        }

        /** @var UniqueIdStamp $stamp */
        $stamp = $envelope->last(UniqueIdStamp::class);

        $envelope = $stack->next()->handle($envelope, $stack);

        $context = [
            'id' => $stamp->getUuid(),
            'class' => get_class($envelope->getMessage())
        ];

        if ($envelope->last(ReceivedStamp::class)) {
            $this->messengerAudit->info('[{id}] Received {class}', $context);
        } elseif ($envelope->last(HandledStamp::class)) {
            $this->messengerAudit->info('[{id}] Handled {class}', $context);
        } else {
            $this->messengerAudit->info('[{id}] Sent {class}', $context);
        }

        return $envelope;
    }
}