<?php
include('../config/config.php');
requireLogin();

if (!isSportif()) {
    header("Location: ../coach/dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$stmt = $conn->prepare("SELECT COUNT(*) as count FROM reservations WHERE sportif_id = ? AND statut = 'en_attente'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pending_count = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as count FROM reservations WHERE sportif_id = ? AND statut = 'accepte'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$accepted_count = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as count FROM reservations WHERE sportif_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_count = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();

$stmt = $conn->prepare("SELECT r.*, u.nom, u.prenom, c.specialite 
                        FROM reservations r 
                        JOIN users u ON r.coach_id = u.id 
                        JOIN coaches c ON u.id = c.user_id 
                        WHERE r.sportif_id = ? AND r.statut = 'accepte' AND r.date_seance >= ? 
                        ORDER BY r.date_seance ASC, r.heure_debut ASC LIMIT 5");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$upcoming_sessions = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sportif - CoachPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif
        }

        body {
            background: #f4f7fa
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1)
        }

        .logo {
            color: #fff;
            font-size: 24px;
            font-weight: 700
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: .3s
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, .2)
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px
        }

        .welcome,
        .stat-card,
        .quick-actions,
        .upcoming {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
            margin-bottom: 30px
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px
        }

        .stat-card {
            text-align: center;
            transition: .3s
        }

        .stat-card:hover {
            transform: translateY(-5px)
        }

        .number {
            font-size: 36px;
            font-weight: 700;
            color: #667eea
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px
        }

        .action-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: .3s
        }

        .action-btn:hover {
            transform: translateY(-3px)
        }

        .session-card {
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px
        }

        .session-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999
        }

        @media(max-width:768px) {

            .navbar,
            .nav-links {
                flex-direction: column
            }

            .nav-links a {
                width: 100%;
                text-align: center
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">🏋️ CoachPro</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="coachs.php">Coachs</a>
            <a href="reservations.php">Mes Réservations</a>
            <a href="../auth/logout.php">Déconnexion</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome">
            <h1>👋 Bienvenue, <?php echo escape($_SESSION['prenom']); ?> !</h1>
            <p>Gérez vos réservations et trouvez le coach parfait</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="number"><?php echo $pending_count; ?></div>En attente
            </div>
            <div class="stat-card">
                <div class="number"><?php echo $accepted_count; ?></div>Confirmées
            </div>
            <div class="stat-card">
                <div class="number"><?php echo $total_count; ?></div>Total
            </div>
        </div>

        <div class="quick-actions">
            <div class="actions-grid">
                <a href="coachs.php" class="action-btn">🔍 Trouver un Coach</a>
                <a href="reservations.php" class="action-btn">📋 Mes Réservations</a>
            </div>
        </div>

        <div class="upcoming">
            <h2>Prochaines Séances</h2>
            <?php if ($upcoming_sessions->num_rows): while ($s = $upcoming_sessions->fetch_assoc()): ?>
                    <div class="session-card">
                        <strong><?php echo escape($s['prenom'] . ' ' . $s['nom']); ?></strong><br>
                        <?php echo escape($s['specialite']); ?> |
                        <?php echo date('d/m/Y H:i', strtotime($s['date_seance'] . ' ' . $s['heure_debut'])); ?>
                    </div>
                <?php endwhile;
            else: ?>
                <div class="empty-state">Aucune séance à venir</div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>