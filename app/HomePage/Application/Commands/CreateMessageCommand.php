<?php

declare(strict_types=1);

namespace App\HomePage\Application\Commands;

use App\HomePage\Application\DTOs\MessageDTO;
use App\HomePage\Domain\Entities\Message;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class CreateMessageCommand
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function execute(string $content): MessageDTO
    {
        $message = new Message(null, $content);
        $savedMessage = $this->messageRepository->save($message);
        
        return new MessageDTO(
            id: $savedMessage->getId(),
            message: $savedMessage->getContent(),
            createdAt: $savedMessage->getCreatedAt()
        );
    }
}
