<?php
require_once '../config/database.php';
require_once '../model/LogModel.php';

class filmModel {
    private $db;
    private $logModel;

    public function __construct() {
        $this->db = dbConnect();
        $this->logModel = new LogModel();
    }

    public function getFilms($userSessionId = null) {
        $url = STAR_WARS_API_URL . 'films/';
        $this->logModel->saveLog('GET', $url, 200, 'Iniciando requisição para obter filmes.');

        $response = $this->makeRequest($url);

        if (!$response || !isset($response['results'])) {
            $errorMsg = "Falha ao obter filmes da API externa.";
            $this->logModel->saveError($url, $errorMsg);
            return ['error' => 'Falha ao obter dados dos filmes.'];
        }

        $this->logModel->saveLog('GET', $url, 200, 'Filmes obtidos com sucesso.');

        usort($response['results'], function ($a, $b) {
            return strtotime($a['release_date']) - strtotime($b['release_date']);
        });

        $favorites = [];
        if (!empty($userSessionId)) {
            $favorites = $this->getFavorites($userSessionId);
        }

        $favoritesIds = array_column($favorites, 'film_id');

        $response['results'] = array_map(function ($film) use ($favoritesIds) {
            $film['isFavorite'] = in_array($film['episode_id'], $favoritesIds);
            return $film;
        }, $response['results']);

        $favoriteFilms = array_filter($response['results'], function ($film) {
            return $film['isFavorite'];
        });
        $nonFavoriteFilms = array_filter($response['results'], function ($film) {
            return !$film['isFavorite'];
        });

        $sortedFilms = array_merge($favoriteFilms, $nonFavoriteFilms);

        return ['results' => $sortedFilms];
    }

    public function getFilmDetails($id) {
        $url = STAR_WARS_API_URL . "films/";
        $urlAud = STAR_WARS_API_URL . "films/{$id}/";
        $this->logModel->saveLog('GET', $urlAud, 200, "Obtendo detalhes do filme ID: $id");

        $films = $this->makeRequest($url);

        if (!$films || !isset($films['results'])) {
            $errorMsg = "Erro ao buscar detalhes para o filme ID: $id.";
            $this->logModel->saveError($urlAud, $errorMsg);
            return ['error' => 'Detalhes do filme não encontrados.'];
        }

        $film = array_filter($films['results'], function ($film) use ($id) {
            return $film['episode_id'] == $id;
        });

        $film = reset($film);

        if (!$film) {
            $errorMsg = "Detalhes do filme não encontrados para o ID: $id.";
            $this->logModel->saveError($urlAud, $errorMsg);
            return ['error' => 'Detalhes do filme não encontrados.'];
        }

        $this->logModel->saveLog('GET', $urlAud, 200, "Detalhes do filme ID: $id obtidos com sucesso.");

        if (!empty($film['characters'])) {
            $characters = [];
            foreach ($film['characters'] as $characterUrl) {
                $characterData = $this->makeRequest($characterUrl);
                if ($characterData && isset($characterData['name'])) {
                    $characters[] = $characterData['name'];
                }
            }
            $film['characters'] = $characters;
        }

        $releaseDate = new DateTime($film['release_date']);
        $now = new DateTime();
        $interval = $now->diff($releaseDate);

        $film['age'] = [
            'years'  => $interval->y,
            'months' => $interval->m,
            'days'   => $interval->d,
        ];

        return $film;
    }

    public function setFavoriteFilm($userSessionId, $filmId, $isFavorite) {
        if ($isFavorite) {
            $sql = "INSERT INTO favorites (user_session_id, film_id) VALUES ('{$userSessionId}', '{$filmId}') ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP";
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = "DELETE FROM favorites WHERE user_session_id = '{$userSessionId}' AND film_id = '{$filmId}'";
            $stmt = $this->db->prepare($sql);
        }
        $stmt->execute();
    }

    public function getFavorites($userSessionId) {
        $sql = "SELECT film_id FROM favorites WHERE user_session_id = '{$userSessionId}'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function makeRequest($url) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response  = curl_exec($curl);
        $httpCode  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200 || !$response) {
            $this->logModel->saveError($url, "Erro na requisição para URL: $url");
            return null;
        }

        return json_decode($response, true);
    }

    public function getFilmTrailer($filmId) {
        $sql = "SELECT trailer_url FROM film_trailers WHERE film_id = '{$filmId}'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['trailer_url'] : null;
    }

    public function getFilmPosters() {
        $sql = "SELECT episode_id, cover_path FROM film_poster";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
