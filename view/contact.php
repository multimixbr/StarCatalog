<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Star Wars Films</title>
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
        .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .form-control:focus {
            background-color: #444;
            border-color: #e50914;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #e50914;
            border: none;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #f40612;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="text-center mb-4">Contact Us</h1>
    <div class="content-box">
        <p>If you have any questions or feedback, feel free to reach out to us using the form below.</p>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Your name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Your email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</div>

</body>
</html>
