<?php

declare(strict_types=1);

namespace App\HomePage\Application\Queries;

use App\HomePage\Application\DTOs\MessageDTO;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class GetMessageByIdQuery
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function execute(int $id): ?MessageDTO
    {
        $message = $this->messageRepository->findById($id);
        
        if ($message === null) {
            return null;
        }
        
        return new MessageDTO(
            id: $message->getId(),
            message: $message->getContent(),
            createdAt: $message->getCreatedAt()
        );
    }
}
