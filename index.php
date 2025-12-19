<?php
include('config/config.php');
if (isLoggedIn()) {
    redirectToDashboard();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CoachPro - Trouvez votre coach sportif professionnel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #333;
      overflow-x: hidden;
    }

    /* Header & Navigation */
    header {
      position: fixed;
      top: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      padding: 15px 0;
    }

    nav {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
    }

    .logo {
      font-size: 26px;
      font-weight: 700;
      color: #667eea;
    }

    .nav-links a {
      text-decoration: none;
      color: #333;
      margin-left: 30px;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #667eea;
    }

    .btn-primary {
      background: #667eea;
      color: white;
      padding: 10px 25px;
      border-radius: 25px;
      text-decoration: none;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    }

    /* Hero Section */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 100px 30px 50px;
    }

    .hero-content h1 {
      font-size: 56px;
      font-weight: 700;
      margin-bottom: 20px;
      animation: fadeInUp 1s ease;
    }

    .hero-content p {
      font-size: 20px;
      margin-bottom: 40px;
      opacity: 0.95;
      animation: fadeInUp 1s ease 0.2s backwards;
    }

    .hero-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
      animation: fadeInUp 1s ease 0.4s backwards;
    }

    .btn {
      padding: 15px 40px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s;
      display: inline-block;
    }

    .btn-white {
      background: white;
      color: #667eea;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-white:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }

    .btn-outline {
      background: transparent;
      color: white;
      border: 2px solid white;
    }

    .btn-outline:hover {
      background: white;
      color: #667eea;
    }

    /* Features Section */
    .features {
      background: white;
      padding: 80px 30px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      font-size: 42px;
      font-weight: 700;
      margin-bottom: 20px;
      color: #333;
    }

    .section-subtitle {
      text-align: center;
      font-size: 18px;
      color: #666;
      margin-bottom: 60px;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 40px;
    }

    .feature-card {
      text-align: center;
      padding: 30px;
      border-radius: 15px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
      font-size: 50px;
      margin-bottom: 20px;
    }

    .feature-card h3 {
      font-size: 24px;
      margin-bottom: 15px;
      color: #333;
    }

    .feature-card p {
      color: #666;
      line-height: 1.6;
    }

    /* Sports Section */
    .sports {
      background: #f8f9fa;
      padding: 80px 30px;
    }

    .sports-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 30px;
      margin-top: 50px;
    }

    .sport-card {
      background: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s;
    }

    .sport-card:hover {
      transform: scale(1.05);
    }

    .sport-card .icon {
      font-size: 40px;
      margin-bottom: 15px;
    }

    .sport-card h4 {
      font-size: 18px;
      color: #333;
    }

    /* CTA Section */
    .cta {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-align: center;
      padding: 80px 30px;
    }

    .cta h2 {
      font-size: 42px;
      margin-bottom: 20px;
    }

    .cta p {
      font-size: 20px;
      margin-bottom: 40px;
      opacity: 0.95;
    }

    /* Footer */
    footer {
      background: #222;
      color: white;
      text-align: center;
      padding: 30px;
    }

    footer p {
      color: #999;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 36px;
      }

      .hero-content p {
        font-size: 16px;
      }

      .section-title {
        font-size: 32px;
      }

      .nav-links {
        display: none;
      }

      .hero-buttons {
        flex-direction: column;
        align-items: center;
      }

      .btn {
        width: 100%;
        max-width: 300px;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <nav>
      <div class="logo">🏋️ CoachPro</div>
      <div class="nav-links">
        <a href="#features">Fonctionnalités</a>
        <a href="#sports">Sports</a>
        <a href="auth/login.php" class="btn-primary">Connexion</a>
      </div>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Trouvez votre coach sportif idéal</h1>
      <p>Réservez des séances avec des coachs professionnels en football, tennis, natation, et bien plus encore</p>
      <div class="hero-buttons">
        <a href="auth/register.php" class="btn btn-white">Commencer gratuitement</a>
        <a href="auth/login.php" class="btn btn-outline">Se connecter</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="container">
      <h2 class="section-title">Pourquoi choisir CoachPro ?</h2>
      <p class="section-subtitle">Une plateforme complète pour vos besoins sportifs</p>
      
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">🎯</div>
          <h3>Coachs certifiés</h3>
          <p>Tous nos coachs sont des professionnels qualifiés et expérimentés dans leur domaine</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon">📅</div>
          <h3>Réservation simple</h3>
          <p>Réservez vos séances en quelques clics selon vos disponibilités</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon">💪</div>
          <h3>Suivi personnalisé</h3>
          <p>Bénéficiez d'un accompagnement sur-mesure adapté à vos objectifs</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon">🏆</div>
          <h3>Résultats garantis</h3>
          <p>Atteignez vos objectifs avec des programmes d'entraînement efficaces</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Sports Section -->
  <section class="sports" id="sports">
    <div class="container">
      <h2 class="section-title">Nos disciplines</h2>
      <p class="section-subtitle">Trouvez le coach parfait pour votre sport</p>
      
      <div class="sports-grid">
        <div class="sport-card">
          <div class="icon">⚽</div>
          <h4>Football</h4>
        </div>
        <div class="sport-card">
          <div class="icon">🎾</div>
          <h4>Tennis</h4>
        </div>
        <div class="sport-card">
          <div class="icon">🏊</div>
          <h4>Natation</h4>
        </div>
        <div class="sport-card">
          <div class="icon">🏃</div>
          <h4>Athlétisme</h4>
        </div>
        <div class="sport-card">
          <div class="icon">🥊</div>
          <h4>Sports de combat</h4>
        </div>
        <div class="sport-card">
          <div class="icon">💪</div>
          <h4>Préparation physique</h4>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <div class="container">
      <h2>Prêt à commencer votre transformation ?</h2>
      <p>Rejoignez des milliers de sportifs qui atteignent leurs objectifs avec CoachPro</p>
      <a href="auth/register.php" class="btn btn-white">Créer un compte gratuit</a>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>© <?php echo date("Y"); ?> CoachPro. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>