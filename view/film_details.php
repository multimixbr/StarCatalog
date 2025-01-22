<?php 

require_once '../config/database.php';
require_once '../model/FilmModel.php';

$film = new FilmModel();

if (!isset($_GET['film_id'])) {
    header('Location: index.php');
    exit;
}

$filmId = $_GET['film_id'];

$filmTrailer = $film->getFilmTrailer($filmId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Film Details</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #141414;
            color: #fff; 
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        #film-title {
            color: #e50914;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
        }

        .details-card {
            background-color: #222;
            border: none;
            border-radius: 10px;
            padding: 2rem;
        }

        #film-trailer iframe {
            width: 100%;
            height: 420px;
            border-radius: 10px;
        }

        .details-section {
            margin-top: 20px;
        }

        .details-section p {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .details-section strong {
            color: #ccc;
            margin-right: 5px;
        }

        #film-characters ul {
            list-style: none;
            padding: 0;
        }

        #film-characters ul li {
            background: #333;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            color: #fff;
        }

        .btn-secondary {
            background-color: #333;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #444;
        }

        @media (max-width: 576px) {
            #film-trailer iframe {
                height: 240px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="details-card">
                    <h1 id="film-title">Loading...</h1>
                    
                    <?php if ($filmTrailer): ?>
                        <div id="film-trailer" class="text-center mb-4">
                            <iframe id="trailer-video" src="<?= $filmTrailer ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>

                    <div class="details-section">
                        <p id="film-opening-crawl"></p>
                        <p id="film-episode"></p>
                        <p id="film-release-date"></p>
                        <p id="film-director"></p>
                        <p id="film-producers"></p>
                        <p id="film-age"></p>
                        <div id="film-characters"></div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-secondary">
                            Back to Catalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const filmId = urlParams.get('film_id');

            if (!filmId) {
                $('.details-card').html('<p class="text-danger">Invalid Film ID.</p>');
                return;
            }

            const apiUrl = `/processo_Seletivo/api/swapi.php?film_id=${filmId}`;

            $.get(apiUrl, function(data) {
                if (data.error) {
                    $('.details-card').html(`<p class="text-danger">${data.error}</p>`);
                    return;
                }

                $('#film-title').text(data.title);
                $('#film-episode').html(`<strong>Episode:</strong> ${data.episode_id}`);
                $('#film-opening-crawl').html(`<strong>Synopsis:</strong> ${data.opening_crawl}`);
                $('#film-release-date').html(`<strong>Release Date:</strong> ${formatDateToEnglish(data.release_date)}`);
                $('#film-director').html(`<strong>Director:</strong> ${data.director}`);
                $('#film-producers').html(`<strong>Producers:</strong> ${data.producer}`);
                $('#film-age').html(`<strong>Age:</strong> ${data.age.years} years, ${data.age.months} months, ${data.age.days} days`);

                if (data.characters && Array.isArray(data.characters)) {
                    $('#film-characters').html('<strong>Characters:</strong><ul></ul>');
                    data.characters.forEach(character => {
                        $('#film-characters ul').append(`<li>${character}</li>`);
                    });
                }
            }).fail(function() {
                $('.details-card').html('<p class="text-danger">Failed to load film details. Please try again later.</p>');
            });

            function formatDateToEnglish(dateString) {
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${month}/${day}/${year}`;
            }
        });
    </script>
</body>
</html>
