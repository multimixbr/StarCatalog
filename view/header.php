<?php
session_start();
?>

<style>
    body {
        background-color: #141414;
        color: #fff;
    }

    .navbar {
        background-color: #222;
        padding: 0.5rem 1rem;
    }

    .navbar-brand {
        color: #e50914 !important;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .nav-link {
        color: #fff !important;
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .nav-link:hover {
        color: #e50914 !important;
    }

    .btn-primary {
        background-color: #e50914;
        border: none;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #f40612;
    }
    
    .user-info {
        color: #fff;
        font-size: 1rem;
        margin-right: 1rem;
    }

</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="index.php">Star Wars Films</a>
    <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav"
            aria-controls="navbarNav" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Catalog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>

            <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item">
                    <span class="nav-link user-info">
                        Welcome, <?= htmlspecialchars($_SESSION['user']['full_name']); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="../controller/AuthController.php" method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="logout">
                        <button type="submit" class="btn btn-outline-light">Logout</button>
                    </form>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a href="login.php" class="btn btn-primary">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>