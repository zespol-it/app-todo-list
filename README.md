# To-Do Dashboard (Vue 3 + Laravel + Docker)

## Opis projektu

Aplikacja do zarządzania zadaniami (To-Do List) z możliwością dodawania, edytowania, usuwania oraz oznaczania zadań jako ukończone. Projekt składa się z backendu w PHP (Laravel) oraz frontendowej aplikacji w Vue.js z Tailwind CSS. Całość uruchamiana przez Docker Compose.

---

## Szybki start (Docker)

1. **Sklonuj repozytorium i przejdź do katalogu projektu**
2. **Uruchom całość przez Docker Compose:**
   ```sh
   docker-compose up -d --build
   ```
3. **Backend (Laravel API):**
   - Dostępny pod: [http://localhost:8000/api/tasks](http://localhost:8000/api/tasks)
4. **Frontend (Vue Dashboard):**
   - Dostępny pod: [http://localhost:5173](http://localhost:5173)
5. **Pierwsze uruchomienie:**
   - Wykonaj migracje:
     ```sh
     docker-compose exec backend php artisan migrate
     ```
   - Wygeneruj klucz aplikacji (wymagane przy pierwszym uruchomieniu lub po zmianie .env):
     ```sh
     docker-compose exec backend php artisan key:generate
     ```
     Klucz zostanie automatycznie zapisany w pliku `.env`.

---

## Funkcjonalności
- Dodawanie, edycja, usuwanie zadań
- Oznaczanie zadania jako ukończone
- Estetyczny dashboard (Vue 3 + Tailwind CSS)
- Obsługa błędów w UI (alerty)
- Animacje przy dodawaniu/usuwaniu
- Testy jednostkowe backend (PHPUnit) i frontend (Jest)

---

## Schemat bazy danych

```mermaid
erDiagram
  TASKS {
    int id PK
    string title
    text description
    enum status
    datetime created_at
    datetime updated_at
  }
```

---

## Diagram klas (UML)

```mermaid
classDiagram
  class Task {
    +int id
    +string title
    +string description
    +string status
    +created_at
    +updated_at
  }
  class TaskController {
    +index()
    +store()
    +update()
    +destroy()
  }
  TaskController --> Task
```

---

## Struktura katalogów (UML)

```mermaid
flowchart TD
  A[enel-med]
  A --> B[backend]
  A --> C[frontend]
  B --> B1[app/]
  B --> B2[config/]
  B --> B3[database/]
  B --> B4[public/]
  B --> B5[resources/]
  B --> B6[routes/]
  B --> B7[tests/]
  C --> C1[src/]
  C --> C2[public/]
  C1 --> C11[components/]
  C1 --> C12[views/]
  C1 --> C13[assets/]
  C --> C3[tests/]
```

---

## Architektura rozwiązania

```mermaid
flowchart TD
  A[Użytkownik] -->|UI| B[Vue Dashboard]
  B -->|REST API| C[Laravel Backend]
  C -->|Eloquent ORM| D[(MySQL DB)]
```

---

## Testy

### Backend (PHPUnit)
```sh
docker-compose exec backend php artisan test
```

### Frontend (Jest)
```sh
docker-compose exec frontend npm run test
```

---

## Technologie
- Laravel 12+ (PHP)
- Vue 3 + Vite
- Tailwind CSS
- MySQL (Docker)
- Docker Compose
- PHPUnit, Jest

---

## Autor
Grzegorz Skotniczny