<?php

declare(strict_types=1);

namespace App\HomePage\View\Controllers;

use App\HomePage\Application\Commands\CreateMessageCommand;
use App\HomePage\Application\Commands\DeleteMessageCommand;
use App\HomePage\Application\Commands\UpdateMessageCommand;
use App\HomePage\Application\Queries\GetAllMessagesQuery;
use App\HomePage\Application\Queries\GetMessageByIdQuery;
use App\HomePage\Application\Queries\GetWelcomeMessageQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController
{
    public function __construct(
        private GetWelcomeMessageQuery $getWelcomeMessageQuery,
        private GetAllMessagesQuery $getAllMessagesQuery,
        private GetMessageByIdQuery $getMessageByIdQuery,
        private CreateMessageCommand $createMessageCommand,
        private UpdateMessageCommand $updateMessageCommand,
        private DeleteMessageCommand $deleteMessageCommand
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->getWelcomeMessageQuery->execute()
        );
    }

    public function getAllMessages(): JsonResponse
    {
        return response()->json([
            'messages' => $this->getAllMessagesQuery->execute()
        ]);
    }

    public function getMessageById(int $id): JsonResponse
    {
        $message = $this->getMessageByIdQuery->execute($id);
        
        if ($message === null) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        
        return response()->json($message);
    }

    public function createMessage(Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $message = $this->createMessageCommand->execute($request->input('content'));
        
        return response()->json($message, 201);
    }

    public function updateMessage(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $message = $this->updateMessageCommand->execute($id, $request->input('content'));
        
        if ($message === null) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        
        return response()->json($message);
    }

    public function deleteMessage(int $id): JsonResponse
    {
        $deleted = $this->deleteMessageCommand->execute($id);
        
        if (!$deleted) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        
        return response()->json(['message' => 'Message deleted successfully']);
    }
}
