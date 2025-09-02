<?php

declare(strict_types=1);

namespace App\HomePage\Application\Queries;

use App\HomePage\Application\DTOs\MessageDTO;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class GetAllMessagesQuery
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function execute(): array
    {
        $messages = $this->messageRepository->findAll();
        
        return array_map(function ($message) {
            return new MessageDTO(
                id: $message->getId(),
                message: $message->getContent(),
                createdAt: $message->getCreatedAt()
            );
        }, $messages);
    }
}
