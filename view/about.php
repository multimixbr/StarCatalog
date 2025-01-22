<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Star Wars Films</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: #fff;
        }
        h1 {
            color: #e50914;
            font-weight: bold;
        }
        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .content-box {
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
        }
        p {
            font-size: 1.1rem;
            color: #ccc;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="text-center mb-4">About Star Wars Films</h1>
    <div class="content-box">
        <p>
            Welcome to the <strong>Star Wars Films</strong> catalog. Our mission is to provide Star Wars enthusiasts with a comprehensive collection of all movies in the franchise.
        </p>
        <p>
            Using data sourced from the official Star Wars API, this project allows users to explore each film's details, including character information, production details, and historical significance.
        </p>
        <h3>Project Features:</h3>
        <ul>
            <li>Detailed movie catalog with release dates.</li>
            <li>Character lists with additional insights.</li>
            <li>Search and filter functionality.</li>
            <li>Logging system to track API requests.</li>
        </ul>
        <p>Enjoy exploring the galaxy far, far away!</p>
    </div>
</div>

</body>
</html>
