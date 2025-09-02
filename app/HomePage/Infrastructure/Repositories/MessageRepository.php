<?php

declare(strict_types=1);

namespace App\HomePage\Infrastructure\Repositories;

use App\HomePage\Domain\Entities\Message;
use App\HomePage\Domain\Repositories\MessageRepositoryInterface;
use App\HomePage\Infrastructure\Database\DatabaseConnection;
use PDO;

class MessageRepository implements MessageRepositoryInterface
{
    private const TABLE_NAME = 'messages';

    public function __construct(
        private DatabaseConnection $connection
    ) {
    }

    public function getWelcomeMessage(): Message
    {
        $sql = "
            SELECT 
                id,
                content,
                created_at
            FROM " . self::TABLE_NAME . "
            WHERE content LIKE '%welcome%'
            LIMIT 1
        ";
        
        $stmt = $this->connection->getConnection()->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if ($result === false) {
            // Fallback if no welcome message found
            return new Message(null, 'Welcome to our homepage!');
        }
        
        return Message::createFromArray($result);
    }

    public function findById(int $id): ?Message
    {
        $sql = "
            SELECT 
                id,
                content,
                created_at
            FROM " . self::TABLE_NAME . "
            WHERE id = :id
        ";
        
        $stmt = $this->connection->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        if ($result === false) {
            return null;
        }
        
        return Message::createFromArray($result);
    }

    public function findAll(): array
    {
        $sql = "
            SELECT 
                id,
                content,
                created_at
            FROM " . self::TABLE_NAME . "
            ORDER BY created_at DESC
        ";
        
        $stmt = $this->connection->getConnection()->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        $messages = [];
        
        foreach ($results as $result) {
            $messages[] = Message::createFromArray($result);
        }
        
        return $messages;
    }

    public function save(Message $message): Message
    {
        $pdo = $this->connection->getConnection();
        
        if ($message->getId() === null) {
            // Insert new message
            $sql = "
                INSERT INTO " . self::TABLE_NAME . " (
                    content,
                    created_at
                ) VALUES (
                    :content,
                    NOW()
                )
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':content', $message->getContent(), PDO::PARAM_STR);
            $stmt->execute();
            
            $id = $pdo->lastInsertId();
            return new Message((int) $id, $message->getContent(), date('Y-m-d H:i:s'));
        } else {
            // Update existing message
            $sql = "
                UPDATE " . self::TABLE_NAME . "
                SET content = :content
                WHERE id = :id
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':content', $message->getContent(), PDO::PARAM_STR);
            $stmt->bindParam(':id', $message->getId(), PDO::PARAM_INT);
            $stmt->execute();
            
            return $message;
        }
    }

    public function delete(int $id): bool
    {
        $sql = "
            DELETE FROM " . self::TABLE_NAME . "
            WHERE id = :id
        ";
        
        $stmt = $this->connection->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function createTableIfNotExists(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS " . self::TABLE_NAME . " (
                id INT AUTO_INCREMENT PRIMARY KEY,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        
        $this->connection->getConnection()->exec($sql);
    }
}
