# Backend-BloodConnect

> Backend-BloodConnect with JWT authentication that uses Mysql, and the Laravel framework 
## Requirements

- git
- laravel
- A browser (e.g., Firefox or Chrome)
- composser
- Mysql


## How To Start
- Install dependencies with `composser install`.
- rename the .env.example file to .env
- add mysql database information on .env
- add TOKEN_SECRET for JWT
- Run the server locally with `php artisan serve`
- run database migration with `php artisan migration`

## View local app in browser

- <http://localhost:8000>


## Routes
- POST <http://localhost:8000/api/auth/register>
- POST <http://localhost:8000/api/auth/login>
- GET <http://localhost:8000/api/getReq> (need authorization)
- GET <http://localhost:8000/api/getReq/filter/{goldar}> (need authorization)
- GET <http://localhost:8000/api/getReq/detail/{id}> (need authorization)
- GET <http://localhost:8000/api/getReq/my> (need authorization)
- POST <http://localhost:8000/api/postReq> (need authorization)
- GET <http://localhost:8000/api/pmi/jadwal> (need authorization)
- GET <http://localhost:8000/api/pmi/udd> (need authorization)
- GET <http://localhost:8000/api/pmi/stok/{udd}> (need authorization)


## Authorization
set Headers `Authorization : Baarer<YOUR_TOKEN>`
example `Authorization : BaarereyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2Mjg4ODM4Y2U5YWZhMzViMmYxNTM3YjEiLCJpYXQiOjE2NTMxMTM3OTR9.7wdHLeDIxzJCm7ZyOWJSlk1b1HPp2Y4cxIVNzcnjf5g`

## Documentation

### Authentication
#### 1. register

> POST `http://localhost:8000/api/auth/register`
```
name: required
email: required
password: required|email|unique
goldar: required
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

> POST `http://localhost:3000/api/auth/login`
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

### Request

#### 1. All Request

> GET `http://localhost:3000/api/getReq`

Example suceess Responds:
```JSON
{
    {
    "response": 200,
    "success": true,
    "message": "Fetch all",
    "data": [
        {
            "id": 1,
            "Pasien": "fajar",
            "GolonganDarah": "A+",
            "JenisDonor": "WB",
            "Rs": "RS PMI",
            "Created": null
        },
        {
            "id": 2,
            "Pasien": "wawan",
            "GolonganDarah": "O+",
            "JenisDonor": "TC",
            "Rs": "RS PMI",
            "Created": null
        }
        ]
    }
}
```

#### 2. Filter blood group

> GET `http://localhost:3000/api/getReq/filter/{goldar}`
> Example `http://localhost:3000/api/getReq/filter/A+`

Example suceess Responds:
```JSON
{
    {
    "response": 200,
    "success": true,
    "message": "Fetch all",
    "data": [
        {
            "id": 1,
            "Pasien": "fajar",
            "GolonganDarah": "A+",
            "JenisDonor": "WB",
            "Rs": "RS PMI",
            "Created": null
        }
        ]
    }
}
```

#### 3. Detail Requests

> GET `http://localhost:3000/api/getReq/detail/{id}`
> Example `http://localhost:3000/api/getReq/detail/1`

Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "Fetch detail id: 1",
    "data": {
        "id": 1,
        "Pasien": "fajar",
        "GolonganDarah": "A+",
        "JenisDonor": "WB",
        "Kebutuhan": 2,
        "Catatan": "",
        "Rs": "RS PMI",
        "Lat": "-7.998964",
        "Lng": "112.645699",
        "User": "fajar",
        "UserGoldar": "",
        "Created": null
    }
}
```

#### 4. My Requests

> GET `http://localhost:3000/api/getReq/my`

Example suceess Responds:
```JSON
{
    "response": 200,
    "success": true,
    "message": "Fetch my all",
    "data": [
        {
            "id": 4,
            "Pasien": "tes",
            "GolonganDarah": "O+",
            "JenisDonor": "WB",
            "Kebutuhan": 4,
            "Catatan": null
            "Rs": "RS PMI",
            "Lat": "-7.998964",
            "Lng": "112.645699",
            "User": "fajar",
            "UserGoldar": "O+",
            "Created": null
        },
        {
            "id": 5,
            "Pasien": "tes",
            "GolonganDarah": "O+",
            "JenisDonor": "WB",
            "Kebutuhan": 4,
            "Catatan": null
            "Rs": "RS PMI",
            "Lat": "-7.998964",
            "Lng": "112.645699",
            "User": "fajar",
            "UserGoldar": "O+",
            "Created": null
        }
    ]
}
```

#### 5. Add Req

> POST `http://localhost:8000/api/postReq`
```
rs : required
nama_pasien : required
pasien_goldar : required
jenis_donor : required
jumlah_kantong : required
kontak_peson : required
catatan : 
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

### PMI API

#### 1. schedule today Mobile unit 

> GET `http://localhost:8000/api/pmi/jadwal`

Example suceess Responds:
```JSON
{
    {
    "response": 200,
    "success": true,
    "message": "Fetch all Jadwal MU",
    "data": [
       {
            "Instansi": "KARANG TARUNA JOYUDAN BANGSALAN TERAS",
            "UDD": "UTD PMI Kabupaten Boyolali",
            "Target": 50,
            "Alamat": "Jl. Kantil 14 (RSU Boyolali)"
        }
        ]
    }
}
```

#### 2. UDD list Information 

> GET `http://localhost:8000/api/pmi/udd`

Example suceess Responds:
```JSON
{
    {
    "response": 200,
    "success": true,
    "message": "Fetch all Kontak UDD",
    "data": [
       {
            "ID": "1103",
            "UDD": "UTD PMI Kabupaten Aceh Timur",
            "Provinsi": "Aceh",
            "Telp": "(0641) 426555",
            "Alamat": "Jl. H. Agus Salim No. 22, Langsa"
        }
        ]
    }
}
```

#### 3. Blood Stock

> GET `http://localhost:8000/api/pmi/stok/{udd}`
> Example `http://localhost:3000/api/pmi/stok/1271`

Example suceess Responds:
```JSON
{
    {
    "response": 200,
    "success": true,
    "message": "Fetch all Stok UDD",
    "data": [
      {
            "Update": "2023-03-25 23:57:59",
            "Product": "AHF",
            "A_pos": 10,
            "B_pos": 6,
            "O_pos": 6,
            "AB_pos": 3,
            "A_neg": 1,
            "B_neg": 0,
            "O_neg": 0,
            "AB_neg": 0
        },
        {
            "Update": "2023-03-25 23:57:59",
            "Product": "FFP",
            "A_pos": 41,
            "B_pos": 36,
            "O_pos": 40,
            "AB_pos": 21,
            "A_neg": 1,
            "B_neg": 0,
            "O_neg": 0,
            "AB_neg": 0
        }
        ]
    }
}
```



