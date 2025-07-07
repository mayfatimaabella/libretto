# Postman API Testing Guide for Libretto

## Setup Instructions

1. **Start your Laravel server:**
   ```bash
   php artisan serve
   ```

2. **Seed your database:**
   ```bash
   php artisan db:seed
   ```

## Postman Configuration

### Base URL
Set up an environment variable in Postman:
- Variable Name: `baseUrl`
- Value: `http://localhost:8000/api`

### Token Storage
Create another environment variable:
- Variable Name: `token`
- Value: (leave empty - will be set automatically)

## API Testing Steps

### 1. Authentication

#### **Login Request**
- **Method**: POST
- **URL**: `{{baseUrl}}/login`
- **Headers**: 
  ```
  Content-Type: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
    "email": "test@example.com",
    "password": "password"
  }
  ```

**Save the token from response for other requests**

### 2. Authors CRUD

#### **Get All Authors**
- **Method**: GET
- **URL**: `{{baseUrl}}/authors`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  ```

#### **Create Author**
- **Method**: POST
- **URL**: `{{baseUrl}}/authors`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
    "name": "Stephen King",
    "biography": "American author of horror, supernatural fiction, suspense, crime, science-fiction, and fantasy novels.",
    "birth_date": "1947-09-21"
  }
  ```

#### **Get Single Author**
- **Method**: GET
- **URL**: `{{baseUrl}}/authors/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  ```

#### **Update Author**
- **Method**: PUT
- **URL**: `{{baseUrl}}/authors/1`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
    "biography": "Updated biography text"
  }
  ```

### 3. Books CRUD

#### **Get All Books**
- **Method**: GET
- **URL**: `{{baseUrl}}/books`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  ```

#### **Create Book**
- **Method**: POST
- **URL**: `{{baseUrl}}/books`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
    "title": "The Shining",
    "author_id": 1,
    "isbn": "9780385121675",
    "publication_date": "1977-01-28",
    "description": "A horror novel about a family that becomes winter caretakers of an isolated hotel.",
    "genres": [1, 2]
  }
  ```

### 4. Genres CRUD

#### **Get All Genres**
- **Method**: GET
- **URL**: `{{baseUrl}}/genres`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  ```

#### **Create Genre**
- **Method**: POST
- **URL**: `{{baseUrl}}/genres`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
    "name": "Horror",
    "description": "Horror fiction genre"
  }
  ```

### 5. Reviews CRUD

#### **Create Review**
- **Method**: POST
- **URL**: `{{baseUrl}}/reviews`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  Content-Type: application/json
  ```
- **Body** (raw JSON):
  ```json
  {
    "book_id": 1,
    "rating": 5,
    "comment": "Excellent book! Highly recommended."
  }
  ```

#### **Get Book Reviews**
- **Method**: GET
- **URL**: `{{baseUrl}}/books/1/reviews`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  ```

### 6. Dashboard Stats
- **Method**: GET
- **URL**: `{{baseUrl}}/dashboard/stats`
- **Headers**: 
  ```
  Authorization: Bearer {{token}}
  ```

### 7. Public Access (No Authentication)

#### **Get Public Books**
- **Method**: GET
- **URL**: `{{baseUrl}}/public/books`
- **Headers**: None required

## Quick Test Sequence

1. **Login** → Save token
2. **Get Dashboard Stats** → Verify seeded data counts
3. **Get All Authors** → See seeded authors
4. **Create New Author** → Test creation
5. **Get All Books** → See seeded books
6. **Create New Book** → Test book creation with genres
7. **Create Review** → Test review creation
8. **Test Public Access** → Verify no auth needed

## Expected Response Format

All API responses follow this format:
```json
{
  "success": true,
  "data": {...},
  "message": "Operation completed successfully"
}
```

## Error Handling

- **401 Unauthorized**: Token expired or invalid
- **422 Validation Error**: Invalid data provided
- **404 Not Found**: Resource not found
- **403 Forbidden**: User doesn't own the resource (reviews)

## Token Management

- Tokens expire after 24 hours
- Each user can have only one active token
- Login creates a new token or returns existing valid token
