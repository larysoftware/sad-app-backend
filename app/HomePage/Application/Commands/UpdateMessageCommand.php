<?php

declare(strict_types=1);

namespace App\HomePage\Application\Commands;

use App\HomePage\Application\DTOs\MessageDTO;
use App\HomePage\Domain\Entities\Message;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class UpdateMessageCommand
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function execute(int $id, string $content): ?MessageDTO
    {
        $existingMessage = $this->messageRepository->findById($id);
        
        if ($existingMessage === null) {
            return null;
        }
        
        $updatedMessage = new Message($id, $content, $existingMessage->getCreatedAt());
        $savedMessage = $this->messageRepository->save($updatedMessage);
        
        return new MessageDTO(
            id: $savedMessage->getId(),
            message: $savedMessage->getContent(),
            createdAt: $savedMessage->getCreatedAt()
        );
    }
}
