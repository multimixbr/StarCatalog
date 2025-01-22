<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../controller/FilmController.php';

session_start();

header('Content-Type: application/json');

$filmController = new FilmController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

    if (isset($_GET['film_id'])) {
        echo json_encode($filmController->getFilmDetails($_GET['film_id']));
    } else {
        echo json_encode($filmController->getFilms($userId));
    }
} else {
    echo json_encode(['error' => 'Method not supported']);
}
?>
