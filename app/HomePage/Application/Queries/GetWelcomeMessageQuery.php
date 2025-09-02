<?php

namespace App\HomePage\Application\Queries;

use App\HomePage\Application\DTOs\MessageDTO;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class GetWelcomeMessageQuery
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function execute(): MessageDTO
    {
        $message = $this->messageRepository->getWelcomeMessage();
        
        return new MessageDTO(
            $message->getContent()
        );
    }
}
