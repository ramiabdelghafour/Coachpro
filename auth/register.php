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
    input, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      transition: border 0.3s;
    }
    input:focus, select:focus {
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
    @media (max-width: 420px) {
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
    <form action="register_process.php" method="POST">
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
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Téléphone :</label>
        <input type="text" name="telephone" placeholder="+212 6..." required>
      </div>
      <div class="form-group">
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Rôle :</label>
        <select name="role" required>
          <option value="" selected disabled>-- Choisissez votre rôle --</option>
          <option value="sportif">Sportif</option>
          <option value="coach">Coach</option>
        </select>
      </div>
      <button type="submit" class="btn">S’inscrire</button>
      <p class="login-link">Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </form>
  </div>
</body>
</html>
