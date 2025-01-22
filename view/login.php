<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Star Wars Films - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #141414; 
            color: #fff;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 2rem;
            background-color: #222;
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        h1 {
            color: #e50914; 
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
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
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #f40612;
        }

        .btn-secondary {
            background-color: #333;
            border: none;
            width: 100%;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #444;
        }

        .text-center a {
            color: #e50914;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div id="custom-alerts" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>
    <?php include 'header.php'; ?>
    <div class="login-container">
        <h1>Login</h1>
        <form id="login-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" placeholder="Enter your email" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter your password" required />
            </div>
            <button type="submit" class="btn btn-primary mb-3">Login</button>
            <button type="button" class="btn btn-secondary" id="reset-form">Reset</button>
        </form>
        <p class="text-center mt-3">
            Don't have an account? <a href="register.php">Sign up</a>
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#reset-form').on('click', function () {
                $('#login-form')[0].reset();
            });

            $('#login-form').on('submit', function (e) {
                e.preventDefault();

                const email = $('#email').val().trim();
                const password = $('#password').val().trim();

                if (!email || !password) {
                    showAlert('Please fill in both fields.', 'warning');
                    return;
                }
            
                $.post('/processo_Seletivo/controller/AuthController.php', {
                    action: 'login',
                    email: email,
                    password: password
                }, function (response) {
                    if (response.success) {
                        showAlert('Login successful! Redirecting...', 'success');
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        showAlert('Invalid credentials. Please try again.', 'danger');
                    }
                }, 'json').fail(function () {
                    showAlert('Error connecting to the server.', 'danger');
                });
            });
            
            function showAlert(message, type = 'danger', autoClose = true) {
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
