<?php
include('../config/config.php');

if (isLoggedIn()) {
    redirectToDashboard();
}

$msg = "";
$msgType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password) && !empty($role)) {
        
        // ✅ SECURE: Check if email exists using prepared statement
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $msg = "Cet email est déjà utilisé.";
            $msgType = "error";
        } else {
            // Hash password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // ✅ SECURE: Insert user using prepared statement
            $stmt = $conn->prepare("INSERT INTO users (nom, prenom, email, telephone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nom, $prenom, $email, $telephone, $hashed_password, $role);
            
            if ($stmt->execute()) {
                $msg = "Inscription réussie ! Vous pouvez vous connecter.";
                $msgType = "success";
            } else {
                $msg = "Erreur lors de l'inscription.";
                $msgType = "error";
            }
        }
        $stmt->close();
    } else {
        $msg = "Veuillez remplir tous les champs.";
        $msgType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | CoachPro</title>
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

        .register-box {
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

        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .success-msg {
            background: #d4edda;
            color: #155724;
        }

        .error-msg {
            background: #f8d7da;
            color: #721c24;
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

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border 0.3s;
        }

        input:focus,
        select:focus {
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

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-txt {
            color: #d00;
            font-size: 13px;
            margin-top: 3px;
        }

        @media(max-width:420px) {
            .register-box {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="register-box">
        <h2>Créer un compte</h2>
        <p class="subtitle">Rejoignez CoachPro pour vos séances sportives</p>  
            <div class="message">
                <?php echo $msg; ?>
            </div>
        <form method="POST" id="registerForm">
            <div class="form-group">
                <label>Nom :</label>
                <input type="text" name="nom" required>
            </div>
            <div class="form-group">
                <label>Prénom :</label>
                <input type="text" name="prenom" required>
            </div>
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" id="email" required>
                <div id="emailError" class="error-txt"></div>
            </div>
            <div class="form-group">
                <label>Téléphone :</label>
                <input type="text" name="telephone" id="telephone" placeholder="+212 6..." required>
                <div id="phoneError" class="error-txt"></div>
            </div>
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="password" id="password" required>
                <div id="passwordError" class="error-txt"></div>
            </div>
            <div class="form-group">
                <label>Rôle :</label>
                <select name="role" required>
                    <option value="" disabled selected>-- Choisissez votre rôle --</option>
                    <option value="sportif">Sportif</option>
                    <option value="coach">Coach</option>
                </select>
            </div>
            <button type="submit" class="btn">S'inscrire</button>
            <p class="login-link">Déjà un compte ? <a href="login.php">Se connecter</a></p>
        </form>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let email = document.getElementById('email').value.trim();
            let phone = document.getElementById('telephone').value.trim();
            let password = document.getElementById('password').value.trim();

            let emailError = document.getElementById('emailError');
            let phoneError = document.getElementById('phoneError');
            let passwordError = document.getElementById('passwordError');

            emailError.textContent = "";
            phoneError.textContent = "";
            passwordError.textContent = "";

            let valid = true;

            // Email validation
            let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                emailError.textContent = "Adresse email invalide.";
                valid = false;
            }

            // Phone validation (Moroccan format: 10 digits)
            let phoneRegex = /^(\+212|0)[5-7][0-9]{8}$/;
            if (!phoneRegex.test(phone)) {
                phoneError.textContent = "Numéro invalide. Format: +2126XXXXXXXX ou 06XXXXXXXX";
                valid = false;
            }

            // Password validation (8+ chars, 1 uppercase, 1 digit)
            let passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (!passwordRegex.test(password)) {
                passwordError.textContent = "Mot de passe faible (8 caractères, 1 majuscule et 1 chiffre).";
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    </script>
</body>

</html>