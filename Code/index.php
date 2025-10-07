<?php
require_once "config.php";
$events = $db->query("SELECT * FROM events WHERE date <> '0000-00-00' ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jugendkreis Aulendorf</title>
  <link rel="icon" href="favicon.png" type="image/png">
  <link rel="manifest" href="manifest.webmanifest">
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header>
    <h1>Jugendkreis Programm</h1>
    <p class="top-info">Evangelische Jugend Aulendorf</p>
    <p class="top-info">Ab der Konfi · Mittwoch 19–21 Uhr · Dobelmühle</p>
    <a href="admin.php" class="admin-link">Admin Login</a>
  </header>

  <main>
    <section class="intro">
      <h2>Programmübersicht</h2>
      <p>Hier findest du alle kommenden Jugendkreis-Abende – kompakt & übersichtlich.</p>
    </section>

    <div class="button-row">
      <a href="ideen.php" class="btn">💡 Ideen für Programm-Planung sammeln</a>
      <a href="ics_all.php" class="btn">📅 Alle Termine als .ics</a>
      <a href="contact.php" class="btn">✉️ Kontakt</a>
    </div>

    <?php if (count($events) === 0): ?>
      <p class="empty-msg">Keine Termine eingetragen.</p>
    <?php else: ?>
      <div class="event-list">
        <?php foreach ($events as $e):
          $date = strtotime($e["date"]);
          $day = date("d", $date);
          $month = strftime("%b", $date);
        ?>
          <div class="event-row">
            <div class="event-date">
              <div class="day"><?= $day ?></div>
              <div class="month"><?= $month ?></div>
            </div>
            <div class="event-content">
              <h3><?= htmlspecialchars($e["title"]) ?></h3>
              <p><?= nl2br(htmlspecialchars($e["desc"])) ?></p>
              <p class="time">🕖 19–21 Uhr · Dobelmühle</p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <footer>
    <p>© Jugendkreis-Team · <a href="impressum.html">Impressum</a></p>
  </footer>

  <script>
    // sanfte Einblendung der Event-Zeilen
    document.addEventListener("DOMContentLoaded", () => {
      const rows = document.querySelectorAll(".event-row");
      rows.forEach((row, i) => {
        setTimeout(() => row.classList.add("visible"), i * 100);
      });
    });
  </script>
</body>

</html>
