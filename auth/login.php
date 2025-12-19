<?php
include('../config/config.php');

if (isLoggedIn()) {
    redirectToDashboard();
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // ✅ SECURE: Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['email'] = $user['email'];

                if ($user['role'] == 'coach') {
                    header("Location: ../coach/dashboard.php");
                } else {
                    header("Location: ../sportif/dashboard.php");
                }
                exit();
            } else {
                $msg = "Mot de passe incorrect.";
            }
        } else {
            $msg = "Aucun compte trouvé avec cet email.";
        }
        $stmt->close();
    } else {
        $msg = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | CoachPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding-top: 60px;
        }

        .login-box {
            background: #fff;
            padding: 35px 40px;
            border-radius: 10px;
            width: 370px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        p.subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
            text-align: center;
            color: #333;
        }

        .error-msg {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border 0.3s;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #005dc1;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-txt {
            color: #d00;
            font-size: 13px;
            margin-top: 3px;
        }

        @media(max-width:420px) {
            .login-box {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Se connecter</h2>
        <p class="subtitle">Connectez-vous à CoachPro pour accéder à votre espace</p>
        
        <?php if (!empty($msg)): ?>
            <div class="error-msg"><?php echo escape($msg); ?></div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" id="email" required>
                <div id="emailError" class="error-txt"></div>
            </div>
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="password" id="password" required>
                <div id="passwordError" class="error-txt"></div>
            </div>
            <button type="submit" class="btn">Se connecter</button>
            <p class="register-link">Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let email = document.getElementById('email').value.trim();
            let password = document.getElementById('password').value.trim();

            let emailError = document.getElementById('emailError');
            let passwordError = document.getElementById('passwordError');

            emailError.textContent = "";
            passwordError.textContent = "";

            let valid = true;
            
            // Email validation
            let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                emailError.textContent = "Adresse email invalide.";
                valid = false;
            }

            // Password validation (at least 8 characters)
            if (password.length < 8) {
                passwordError.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    </script>
</body>

</html>