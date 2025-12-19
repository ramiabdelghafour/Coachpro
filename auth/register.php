<?php
include('../config/config.php');

if (isLoggedIn()) {
    redirectToDashboard();
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password) && !empty($role)) {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $msg = "Cet email est déjà utilisé.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (nom, prenom, email, telephone, password, role)
                      VALUES ('$nom', '$prenom', '$email', '$telephone', '$hashed_password', '$role')";
            if (mysqli_query($conn, $query)) {
                $msg = "Inscription réussie ! Vous pouvez vous connecter.";
            } else {
                $msg = "Erreur lors de l'inscription.";
            }
        }
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
    <title>Inscription | CoachPro</title>
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
        <p><?php echo $msg ?></p>

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
            <button type="submit" class="btn">S’inscrire</button>
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

            let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            let phoneRegex = /^[0-9]{10}$/;
            let passwordRegex = /^.{8,}$/;


            if (!emailRegex.test(email)) {
                emailError.textContent = "Adresse email invalide.";
                valid = false;
            }

            if (!phoneRegex.test(phone)) {
                phoneError.textContent = "Numéro invalide. Format: +2126XXXXXXXX";
                valid = false;
            }

            if (!passwordRegex.test(password)) {
                passwordError.textContent = "Mot de passe faible (8 caractères, 1 majuscule et 1 chiffre).";
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    </script>
</body>

</html>