<?php

namespace Mpwar\DataMiner\Application;

class SendDocumentsToMessageBus
{
    /**
     * @var MessageBus
     */
    private $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function send(DocumentWasStoredEvent $documentWasStoredEvent)
    {
        $message = [
            'eventName' => 'RawDocumentWasStored',
            'occurredOn' => $documentWasStoredEvent->occurredOn()->format(DATE_ATOM),
            'rawDocument' => [
                'id' => $documentWasStoredEvent->document()->id()->value(),
                'source' => $documentWasStoredEvent->document()->service()->value(),
                'keyword' => $documentWasStoredEvent->document()->keyword()->value(),
                'content' => $documentWasStoredEvent->document()->content()->value()
            ]
        ];

        $this->messageBus->dispatch(json_encode($message));
    }
}
