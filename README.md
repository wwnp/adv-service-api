
<p align="center"><img src="https://i.imgur.com/ePIhPeP.png" width="200" alt="Laravel Logo"></p>

# <p align="center">Advertisements Restfull API</p>
---
This advertisement management service is developed using the Laravel PHP framework based on this [test trial](https://github.com/avito-tech/adv-backend-trainee-assignment) . It enables users to store and retrieve advertisements through a JSON-based HTTP API. The service is designed for easy deployment, with Docker Compose support included. It offers the following key functionalities:

- **List Advertisements**: Users can retrieve a paginated list of advertisements with options to sort by price or creation date. Each listing includes the advertisement's name, a link to its main photo, and its price.
- **Retrieve a Single Advertisement**: Users can fetch detailed information about a specific advertisement, including its name, price, and a link to the main photo. Optionally, they can request additional fields like description and links to all photos.
- **Create Advertisement**: Users can create new advertisements by providing details such as name, description, image url and price. The service returns the ID of the newly created advertisement along with a status code indicating success or failure.

---

## Install:

Requirements:
 - [PHP](https://www.php.net/manual/en/install.php)
 - [Composer Install](https://getcomposer.org/doc/00-intro.md)
 - [Docker, Docker-Composer (or Docker-Desktop)](https://www.docker.com/get-started/)
 - [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
 - [Postman](https://www.postman.com/) or [Curl](https://curl.se/)
 - [Windows Subsystem for Linux (WSL)](https://learn.microsoft.com/en-us/windows/wsl/install) (Optional)

Install requirements according your OS.

##### Windows:
As you've installed a [WSL](https://learn.microsoft.com/en-us/windows/wsl/install) , you need to use your windows terminal to get to linux terminal. Next follow guide for linux below.


##### Linux:
Go to linux terminal, target home directory and clone the repo:
`cd ~/ && git clone https://github.com/wwnp/api-space-todos.git` 

Install laravel dependencies (sail especially):
`cd ./api-space-todos.git && composer install`

Turn on Docker-Desktop. Use command to start Docker containers defined in a docker-compose.yml file. Be patient, while Docker creates container:
`docker-composer up`

<!-- TEMP -->
<!-- Set up sail  -->
<!-- `./vendor/bin/sail up` -->

It's done! :smirk::thumbsup:. You can use software for sending requests like [Postman](https://www.postman.com/) or [Curl](https://curl.se/)




---

## Usage:

**Base URL:**
`http://localhost`

### Get List of Advertisements
> URL: `http://localhost/api/advertisements`

**Method: GET**

*Optional Query Parameters:*
- page - Page number for pagination (default is 1).
- per_page - Number of advertisements per page (default is 10).
- sort_field - **created_at** or **price**, default is created_at.
- sort_order - **asc** or **desc**


*Example Request:*
```
GET http://localhost/api/advertisements?page=1&per_page=10&sort_field=created_at&sort_order=desc
```

*Example Response:*
```
{
    "data": [
        {
            "id": 1,
            "title": "Car for Sale",
            "price": 10000,
            "url": "https://example.com/car.jpg"
        },
        {
            "id": 2,
            "title": "Apartment for Rent",
            "price": 500,
            "url": "https://example.com/apartment.jpg"
        }
    ],
    "meta": {
        "total": 2,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1
    },
    "status": "ok"
}
```


#### Get a Single Advertisement
> URL: `http://localhost/api/advertisements/{id}`

**Method: GET**

*Optional Query Parameters:*
- fields - **descr** for getting description and **images** - for full pack of images urls.

*Example Request:*
```
GET http://localhost/api/advertisements/1?fields=descr,images
```

*Example Response:*
```
{
    "data": {
        "id": 1,
        "title": "Car for Sale",
        "description": "Car in good condition.",
        "price": 10000,
        "created_at": "2023-09-18 10:00:00",
        "updated_at": "2023-09-18 10:30:00",
        "images": [
            {
                "id": 1,
                "url": "https://example.com/car.jpg"
            },
            {
                "id": 2,
                "url": "https://example.com/car-interior.jpg"
            }
        ]
    },
    "status": "ok"
}

```





#### Create an Advertisement
> URL: `http://localhost/api/advertisements`

**Method: POST**

*Optional Query Parameters:*
- title (required) - Advertisement title.
- description (required) - Advertisement description.
- price (required) - Advertisement price.
- image_urls (required) - Array of image URLs (up to 3 images).

*Example Request:*
```
POST http://localhost/api/advertisements
{
    "title": "Audi Q8",
    "description": "Car in good condition.",
    "price": 10000,
    "image_urls": [
        "https://example.com/q8.jpg",
        "https://example.com/q8-interior.jpg"
    ]
}
```

*Example Response:*
```
{
    "message": "Advertisement created",
    "id": 1
}

```
