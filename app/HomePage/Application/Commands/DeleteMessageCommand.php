<?php

declare(strict_types=1);

namespace App\HomePage\Application\Commands;

use App\HomePage\Domain\Repositories\MessageRepositoryInterface;

class DeleteMessageCommand
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {}

    public function execute(int $id): bool
    {
        return $this->messageRepository->delete($id);
    }
}
