<?php
session_start();
require_once "config.php";

// Tabelle anlegen, falls noch nicht existiert
$db->exec("CREATE TABLE IF NOT EXISTS ideas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  idea TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Neue Idee speichern
if (isset($_POST['submit']) && !empty($_POST['idea'])) {
  $stmt = $db->prepare("INSERT INTO ideas (idea) VALUES (?)");
  $stmt->execute([$_POST['idea']]);
  $message = "✅ Idee gespeichert – danke für deinen Vorschlag!";
}

// Admin-Login
$PASS = "jugendkreis2025";
if (isset($_POST['admin_login']) && $_POST['password'] === $PASS) {
  $_SESSION['admin'] = true;
}
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: ideen.php");
  exit;
}

// Löschen (nur Admin)
if (isset($_GET['delete']) && isset($_SESSION['admin'])) {
  $stmt = $db->prepare("DELETE FROM ideas WHERE id=?");
  $stmt->execute([$_GET['delete']]);
}

// Ideen abrufen
$ideas = $db->query("SELECT * FROM ideas ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ideen – Jugendkreis</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="favicon.png">
  <link rel="apple-touch-icon" href="favicon.png">
  <style>
    /* Zusatz-Styles speziell für Ideen-Seite */
    .idea-table {
      max-width: 900px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .idea-list {
      width: 100%;
      border-collapse: collapse;
      background: var(--bg-card);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
      border-radius: 8px;
      overflow: hidden;
    }

    .idea-list th,
    .idea-list td {
      padding: 0.8rem 1rem;
      border-bottom: 1px solid var(--border);
    }

    .idea-list th {
      background: var(--accent);
      color: white;
      text-align: left;
      font-weight: 600;
    }

    .idea-list tr:hover {
      background: #2c2623;
    }

    .small-admin {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
      color: var(--muted);
    }

    .small-admin a {
      color: var(--accent-light);
      cursor: pointer;
    }

    #adminLoginBox {
      display: none;
      max-width: 300px;
      margin: 1rem auto;
      background: var(--bg-card);
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>

<body>

  <header>
    <h1>Ideen</h1>
    <p>Vorschläge & kreative Einfälle für kommende Jugendkreis-Abende</p>
    <a href="index.php" class="admin-link">← Zurück</a>
  </header>

  <main>
    <?php if (isset($message)): ?>
      <p style="text-align:center;color:var(--accent-light);"><?= $message ?></p>
    <?php endif; ?>

    <section class="new-event">
      <h2>Neue Idee einreichen</h2>
      <form method="post">
        <textarea name="idea" placeholder="Deine Idee..." required></textarea>
        <button name="submit">Senden</button>
      </form>
    </section>

    <section class="idea-table">
      <h2>Bisherige Ideen</h2>
      <?php if (empty($ideas)): ?>
        <p style="color:var(--muted);text-align:center;">Noch keine Ideen eingetragen.</p>
      <?php else: ?>
        <table class="idea-list">
          <thead>
            <tr>
              <th>Idee</th>
              <th>Datum</th>
              <?php if (isset($_SESSION['admin'])): ?><th>Aktion</th><?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ideas as $i): ?>
              <tr>
                <td><?= nl2br(htmlspecialchars($i['idea'])) ?></td>
                <td><?= date("d.m.Y", strtotime($i['created_at'])) ?></td>
                <?php if (isset($_SESSION['admin'])): ?>
                  <td><a href="?delete=<?= $i['id'] ?>" class="delete-btn" onclick="return confirm('Löschen?')">Löschen</a></td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>

    <div class="small-admin">
      <?php if (!isset($_SESSION['admin'])): ?>
        <a onclick="document.getElementById('adminLoginBox').style.display='block'">Admin-Login</a>
        <div id="adminLoginBox">
          <form method="post">
            <input type="password" name="password" placeholder="Passwort">
            <button name="admin_login">Login</button>
          </form>
        </div>
      <?php else: ?>
        <a href="?logout=1">Logout</a>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    <p>© Jugendkreis-Team · <a href="impressum.html">Impressum</a></p>
  </footer>

</body>

</html>