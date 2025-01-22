<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Star Wars Films - Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
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

        .favorite-icon {
            cursor: pointer;
            font-size: 1.8rem;
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }

        .favorite-icon.white {
            color: #fff;
        }

        .favorite-icon.gold {
            color: gold;
        }

        .film-card {
            background-color: #222; 
            border: none;
            margin-bottom: 2rem;
        }

        .film-image-container {
            position: relative;
        }

        .film-card img {
            width: 100%;
            height: 360px;
            object-fit: contain;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            background-color: #000;
        }

        .film-card-body {
            padding: 0.8rem;
        }

        .film-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
        }

        .film-card-text {
            font-size: 0.9rem;
            color: #ccc;
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

        .form-label {
            color: #ccc; 
        }

        .btn-primary {
            background-color: #e50914;
            border: none;
        }

        .btn-primary:hover {
            background-color: #f40612;
        }

        .btn-secondary {
            background-color: #333;
            border: none;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #444;
        }
        
        .poster-placeholder {
            background-color: #444;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 360px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div id="custom-alerts" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>
    <div class="container">
        <h1 class="text-center mb-4">Star Wars Films</h1>
          
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <label for="search-bar" class="form-label">Search</label>
                <input type="text" id="search-bar" class="form-control" placeholder="Search for a film..." />
            </div>
            <div class="col-6 col-md-3">
                <label for="start-date" class="form-label">Start Date</label>
                <input type="date" id="start-date" class="form-control" />
            </div>
            <div class="col-6 col-md-3">
                <label for="end-date" class="form-label">End Date</label>
                <input type="date" id="end-date" class="form-control" />
            </div>
            <div class="col-12 col-md-2 d-flex align-items-end">
                <button id="filter-date" class="btn btn-primary w-100 me-1">
                  Filter
                </button>
                <button id="reset-filters" class="btn btn-secondary w-100">
                  Reset
                </button>
            </div>
        </div>
        <div class="row" id="film-list"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#start-date').on('click focus', function() {
                this.showPicker && this.showPicker();
            });
            $('#end-date').on('click focus', function() {
                this.showPicker && this.showPicker();
            });

            const apiUrl = '/processo_Seletivo/api/swapi.php';
            const controllerUrl = '/processo_Seletivo/controller/FilmController.php';
            var userId = "<?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : ''; ?>";
            let allFilms = [];

            function formatDateToEnglish(dateString) {
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${month}/${day}/${year}`;
            }

            function truncateSynopsis(synopsis, maxLength = 100) {
                if (!synopsis) return '';
                if (synopsis.length > maxLength) {
                    return synopsis.substring(0, maxLength) + '...';
                }
                return synopsis;
            }

            function displayFilms(films) {
                const filmList = $('#film-list');
                filmList.empty();

                if (films.length === 0) {
                    filmList.append(`
                        <div class="col-12">
                            <p class="text-warning text-center">No films match your search.</p>
                        </div>`);
                    return;
                }

                films.forEach((film, index) => {
                    const favoriteClass = film.isFavorite ? 'gold' : 'white';
                    const truncatedCrawl = truncateSynopsis(film.opening_crawl, 120);

                    let posterImage = '';

                    if (film.poster_path) {
                        posterImage = `
                            <img 
                                src="../${film.poster_path}" 
                                alt="Poster of ${film.title}" 
                            />
                        `;
                    } else {
                        posterImage = `
                            <div class="poster-placeholder">
                                <span>No Poster Available</span>
                            </div>
                        `;
                    }

                    filmList.append(`
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card film-card">
                                <div class="film-image-container">
                                    ${posterImage}
                                    <span 
                                        class="favorite-icon ${favoriteClass}" 
                                        data-film-id="${film.episode_id}"
                                    >
                                        &#9733;
                                    </span>
                                </div>
                                <div class="film-card-body">
                                    <h5 class="film-card-title">${film.title}</h5>
                                    <p class="film-card-text">
                                        ${truncatedCrawl}
                                    </p>
                                    <p class="film-card-text">
                                        <strong>Release Date:</strong> ${formatDateToEnglish(film.release_date)}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="film_details.php?film_id=${film.episode_id}" class="btn btn-primary btn-sm">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });

                $('.favorite-icon').off('click').on('click', function () {
                    if (!userId) {
                        customAlert('You need to be logged in to favorite a movie!', 'warning');
                        return;
                    }
                
                    const filmId = $(this).data('film-id');
                    const isCurrentlyGold = $(this).hasClass('gold');
                    toggleFavorite(filmId, !isCurrentlyGold, $(this));
                });
            }

            function toggleFavorite(filmId, isFavorite, element) {
                $.post(controllerUrl, {
                    action: 'setFavoriteFilm',
                    film_id: filmId,
                    user_id: userId,
                    is_favorite: isFavorite
                }, function (response) {
                    if (response.success) {
                        if (isFavorite) {
                            element.removeClass('white').addClass('gold');
                        } else {
                            element.removeClass('gold').addClass('white');
                        }
                        customAlert('Favorite status updated successfully!', 'success');
                    } else {
                        customAlert('Failed to update favorite status.', 'danger');
                    }
                }, 'json').fail(function () {
                    customAlert('Error communicating with the server.', 'danger');
                });
            }

            function filterFilms() {
                const searchTerm = $('#search-bar').val().toLowerCase();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();

                let filteredFilms = allFilms;

                if (searchTerm) {
                    filteredFilms = filteredFilms.filter(film =>
                        film.title.toLowerCase().includes(searchTerm)
                    );
                }

                if (startDate && endDate) {
                    filteredFilms = filteredFilms.filter(film => {
                        const releaseDate = new Date(film.release_date);
                        return (
                            releaseDate >= new Date(startDate) &&
                            releaseDate <= new Date(endDate)
                        );
                    });
                }

                displayFilms(filteredFilms);
            }

            $('#search-bar').on('input', function() {
                filterFilms();
            });
            $('#filter-date').on('click', function() {
                filterFilms();
            });
            $('#reset-filters').on('click', function () {
                $('#search-bar').val('');
                $('#start-date').val('');
                $('#end-date').val('');
                displayFilms(allFilms);
            });

            function fetchFilms() {
                $.get(apiUrl, function (data) {
                    if (data.error) {
                        $('#film-list').html(`
                            <div class="col-12">
                                <p class="text-danger text-center">${data.error}</p>
                            </div>`);
                        return;
                    }
                    allFilms = data;
                    displayFilms(allFilms);
                }).fail(function () {
                    $('#film-list').html(`
                        <div class="col-12">
                            <p class="text-danger text-center">
                                Failed to load films. Please try again later.
                            </p>
                        </div>`);
                });
            }

            fetchFilms();
            
            function customAlert(message, type = 'danger', autoClose = true) {
                const alertId = 'alert-' + new Date().getTime();
                const alertHtml = `
                    <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show shadow-lg" role="alert">
                        <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                $('#custom-alerts').append(alertHtml);

                if (autoClose) {
                    setTimeout(() => {
                        $(`#${alertId}`).fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 4000);
                }
            }
        });
    </script>
</body>
</html>
