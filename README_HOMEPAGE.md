# HomePage Domain - Repository i Query z PDO MySQL

## Opis

Ten moduł zawiera implementację repozytorium i query dla domeny HomePage z połączeniem do bazy danych MySQL używając PDO, bez wykorzystania frameworkowych narzędzi Laravel.

## Struktura

```
app/HomePage/
├── Domain/
│   ├── Entities/
│   │   └── Message.php                    # Encja wiadomości
│   └── Repositories/
│       └── MessageRepositoryInterface.php # Interfejs repozytorium
├── Application/
│   ├── Queries/                           # Query do odczytu danych
│   │   ├── GetWelcomeMessageQuery.php
│   │   ├── GetAllMessagesQuery.php
│   │   └── GetMessageByIdQuery.php
│   ├── Commands/                          # Komendy do modyfikacji danych
│   │   ├── CreateMessageCommand.php
│   │   ├── UpdateMessageCommand.php
│   │   └── DeleteMessageCommand.php
│   └── DTOs/
│       └── MessageDTO.php                 # Data Transfer Object
├── Infrastructure/
│   ├── Database/
│   │   ├── DatabaseConfig.php             # Konfiguracja bazy danych
│   │   └── DatabaseConnection.php         # Połączenie PDO
│   ├── Repositories/
│   │   └── MessageRepository.php          # Implementacja repozytorium
│   └── Providers/
│       └── HomePageServiceProvider.php    # Service Provider
└── View/
    └── Controllers/
        └── HomeController.php              # Kontroler z endpointami
```

## Konfiguracja bazy danych

### 1. Konfiguracja w Laravel

Dodaj konfigurację MySQL w `config/database.php`:

```php
'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'homepage'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
    ],
],
```

### 2. Zmienne środowiskowe

W pliku `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=homepage
DB_USERNAME=root
DB_PASSWORD=twoje_haslo
```

## Użycie

### 1. Automatyczne tworzenie tabeli

Tabela `messages` zostanie automatycznie utworzona przy pierwszym uruchomieniu aplikacji.

### 2. Endpointy API

#### GET / - Pobierz wiadomość powitalną
```bash
curl http://localhost:8000/
```

#### GET /messages - Pobierz wszystkie wiadomości
```bash
curl http://localhost:8000/messages
```

#### GET /messages/{id} - Pobierz wiadomość po ID
```bash
curl http://localhost:8000/messages/1
```

#### POST /messages - Utwórz nową wiadomość
```bash
curl -X POST http://localhost:8000/messages \
  -H "Content-Type: application/json" \
  -d '{"content": "Nowa wiadomość"}'
```

#### PUT /messages/{id} - Zaktualizuj wiadomość
```bash
curl -X PUT http://localhost:8000/messages/1 \
  -H "Content-Type: application/json" \
  -d '{"content": "Zaktualizowana wiadomość"}'
```

#### DELETE /messages/{id} - Usuń wiadomość
```bash
curl -X DELETE http://localhost:8000/messages/1
```

## Implementacja PDO

### DatabaseConfig
Klasa konfigurująca parametry połączenia z bazą danych:

```php
$config = new DatabaseConfig(
    host: 'localhost',
    database: 'homepage',
    username: 'root',
    password: 'haslo',
    port: 3306
);
```

### DatabaseConnection
Klasa zarządzająca połączeniem PDO:

```php
$connection = new DatabaseConnection($config);
$pdo = $connection->getConnection();
```

### MessageRepository
Implementacja repozytorium z metodami CRUD:

- `findById(int $id): ?Message` - Znajdź wiadomość po ID
- `findAll(): array` - Pobierz wszystkie wiadomości
- `save(Message $message): Message` - Zapisz/aktualizuj wiadomość
- `delete(int $id): bool` - Usuń wiadomość
- `getWelcomeMessage(): Message` - Pobierz wiadomość powitalną

## Przykład użycia w kodzie

```php
// W kontrolerze lub serwisie
public function __construct(
    private MessageRepositoryInterface $messageRepository
) {}

public function createMessage(string $content): MessageDTO
{
    $message = new Message(null, $content);
    $savedMessage = $this->messageRepository->save($message);
    
    return new MessageDTO(
        id: $savedMessage->getId(),
        message: $savedMessage->getContent(),
        createdAt: $savedMessage->getCreatedAt()
    );
}
```

## Bezpieczeństwo

- Wszystkie zapytania używają prepared statements
- Parametry są bindowane z odpowiednimi typami
- Walidacja danych wejściowych w kontrolerach
- Obsługa błędów PDO

## Architektura

Implementacja następuje wzorce:
- **Repository Pattern** - Abstrakcja dostępu do danych
- **CQRS** - Rozdzielenie operacji odczytu (Query) i zapisu (Command)
- **DTO Pattern** - Transfer danych między warstwami
- **Dependency Injection** - Wstrzykiwanie zależności
