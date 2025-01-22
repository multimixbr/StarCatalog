<?php
require_once '../model/FilmModel.php';

class FilmController {
    private $filmModel;

    public function __construct() {
        $this->filmModel = new FilmModel();
    }

    public function getFilms($userId = null) {
        $films = $this->filmModel->getFilms($userId)['results'];

        $posters = $this->filmModel->getFilmPosters();
    
        $posterMap = [];
        foreach ($posters as $poster) {
            $posterMap[$poster['episode_id']] = $poster['cover_path'];
        }
    
        foreach ($films as &$film) {
            $episodeId = $film['episode_id'];

            $film['poster_path'] = isset($posterMap[$episodeId]) 
                ? 'img/' . $posterMap[$episodeId] 
                : 'img/placeholder.jpg';
        }
         
        return $films;
    }

    public function getFilmDetails($id) {
        return $this->filmModel->getFilmDetails($id);
    }

    public function setFavoriteFilm($id, $userSessionId, $isFavorite) {
        return $this->filmModel->setFavoriteFilm($userSessionId, $id, $isFavorite);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $filmController = new FilmController();

    if ($action === 'setFavoriteFilm') {

        $filmId = $_POST['film_id'] ?? null;
        $userSessionId = $_POST['user_id'] ?? null;
        $isFavorite = filter_var($_POST['is_favorite'], FILTER_VALIDATE_BOOLEAN);

        if ($filmId !== null) {
            $result = $filmController->setFavoriteFilm($filmId, $userSessionId, $isFavorite);
            echo json_encode(['success' => true, 'result' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Film ID is required.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action.']);
    }
}
?>
