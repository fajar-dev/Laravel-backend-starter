# Laravel Backend Starter

> Backend laravel with json web token and Cloudinary

give a star if you like it

Author : fajar-dev

## Requirements

- git
- laravel
- A browser (e.g., Firefox or Chrome)
- composser
- SQL Database


## How To Start
- Install dependencies with `composser install`.
- rename the `.env.example` file to `.env`
- add mysql database information on .env
- add TOKEN_SECRET for JWT
- setup SMTP Mail Environment
- setup Cloudinary Environment
- Run the server locally with `php artisan serve`
- run database migration with `php artisan migration`

## Routes
- POST <http://localhost:8000/api/auth/register>
- POST <http://localhost:8000/api/auth/login>
- POST <http://localhost:8000/api/auth/forget>
- POST <http://localhost:8000/api/auth/logout>(need authorization)
- POST <http://localhost:8000/api/auth/refresh>(need authorization)
- GET <http://localhost:8000/api/auth/me>(need authorization)
- GET <http://localhost:8000/api/user> (need authorization)
- POST <http://localhost:8000/api/user/create> (need authorization)
- POST <http://localhost:8000/api/user/update/{id}> (need authorization)
- POST <http://localhost:8000/api/user/delete/{id}> (need authorization)
- POST <http://localhost:8000/api/account/update> (need authorization)
- POST <http://localhost:8000/api/account/change_password> (need authorization)

## Authorization
set Headers `Authorization : Baarer<YOUR_TOKEN>`
example `Authorization : BaarereyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2Mjg4ODM4Y2U5YWZhMzViMmYxNTM3YjEiLCJpYXQiOjE2NTMxMTM3OTR9.7wdHLeDIxzJCm7ZyOWJSlk1b1HPp2Y4cxIVNzcnjf5g`

## Documentation
### Authentication

#### 1. Register

> POST `http://localhost:8000/api/auth/register`
```
name: required
email: required
password: required|email|unique
```

Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "Requests created successfully.",
    "data": true
}
```

#### 2. Login

> POST `http://localhost:8000/api/auth/login`
```
email: required
password: required
```

Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "Login Successfully",
        "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY3OTcyODY4MSwiZXhwIjoxNjc5NzMyMjgxLCJuYmYiOjE2Nzk3Mjg2ODEsImp0aSI6ImI2RFc1TnBXVWc3bWJPd3MiLCJzdWIiOjQsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.j3XBkTO-kH9Iu45jW_RJTb2nZiApiA01vwDZUCLqOQ4",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

#### 3. Forget

> POST `http://localhost:8000/api/auth/forget`
```
email: required
```

Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "email sent successfully",
    "data": []
}
```

#### 4. Logout

> POST `http://localhost:8000/api/auth/logout`
Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "Successfully logged out",
    "data": []
}
```

#### 5. Token Refresh

> POST `http://localhost:8000/api/auth/refresh`
Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "JWT Token refresh Successfully",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9yZWZyZXNoIiwiaWF0IjoxNjg4MjAwOTY1LCJleHAiOjE2ODgyMDQ1OTIsIm5iZiI6MTY4ODIwMDk5MiwianRpIjoiaU9FcGlTeUNFUXJid0ZKVSIsInN1YiI6MywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.SLL3kTdpZ7c9t5PKg0pswHx20-_1KPB0uKUmkbRA3PU",
        "token_type": "bearer",
        "expires_in": 3600
    }
}
```

#### 6. Me

> GET `http://localhost:8000/api/auth/me`
Example suceess Responds:
```JSON
{
    "id": 3,
    "name": "fajar Rivaldi Chan",
    "email": "fajarrivaldi2015@gmail.com",
    "email_verified_at": null,
    "photo": "avatar.png",
    "created_at": "2023-06-30T18:50:12.000000Z",
    "updated_at": "2023-06-30T18:51:04.000000Z"
}
```

### CRUD 

#### 1. Read

> GET `http://localhost:8000/api/user`

Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "Read all user",
    "data": [
        {
            "id": 1,
            "Name": "fajar Rivaldi Chan",
            "Email": "fajar@gmail.com",
            "Photo": "avatar.png",
            "Created_at": "2023-06-30T15:02:08.000000Z",
            "Updated_at": "2023-06-30T15:02:08.000000Z"
        },
        {
            "id": 2,
            "Name": "Sukma Rizky",
            "Email": "sukma@gmail.com",
            "Photo": "avatar.png",
            "Created_at": "2023-06-30T18:50:12.000000Z",
            "Updated_at": "2023-06-30T18:51:04.000000Z"
        }
    ]
}
```
