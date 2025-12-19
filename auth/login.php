<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion | CoachPro</title>
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
      margin-bottom: 25px;
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
    @media (max-width: 420px) {
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
    <form action="login_process.php" method="POST">
      <div class="form-group">
        <label>Email :</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn">Se connecter</button>
      <p class="register-link">Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
    </form>
  </div>
</body>
</html>