<?php
session_start();
require_once "config.php";

$PASS = "jugendkreis2025"; // Passwort hier anpassen

if (isset($_POST['login'])) {
    if ($_POST['password'] === $PASS) $_SESSION['admin'] = true;
    else $error = "Falsches Passwort.";
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['admin'])) {
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login – Jugendkreis Admin</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="favicon.png">
  <link rel="apple-touch-icon" href="favicon.png">
</head>
<body>
<header><h1>Admin-Login</h1></header>
<main>
  <form method="post" class="login-form">
    <input type="password" name="password" placeholder="Passwort" required>
    <button name="login">Login</button>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
  </form>
</main>
</body>
</html>
<?php
exit;
}

// Aktionen
if (isset($_POST['add'])) {
    $stmt = $db->prepare("INSERT INTO events (date, title, `desc`) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['date'], $_POST['title'], $_POST['desc']]);
}

if (isset($_POST['edit'])) {
    $stmt = $db->prepare("UPDATE events SET date=?, title=?, `desc`=? WHERE id=?");
    $stmt->execute([$_POST['date'], $_POST['title'], $_POST['desc'], $_POST['id']]);
}

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM events WHERE id=?");
    $stmt->execute([$_GET['delete']]);
}

$events = $db->query("SELECT * FROM events ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin – Jugendkreis</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <h1>Adminbereich</h1>
  <a href="?logout=1" class="logout">Logout</a>
</header>
<main>
  <section class="new-event">
    <h2>Neuer Termin</h2>
    <form method="post">
      <input type="text" name="date" placeholder="Datum (z.B. 09.10.2025)" required>
      <input type="text" name="title" placeholder="Titel" required>
      <textarea name="desc" placeholder="Beschreibung"></textarea>
      <button name="add">Hinzufügen</button>
    </form>
  </section>

  <section>
    <h2>Vorhandene Termine</h2>
    <?php foreach ($events as $e): ?>
      <div class="event admin-event">
        <form method="post">
          <input type="hidden" name="id" value="<?= $e['id'] ?>">
          <input type="text" name="date" value="<?= htmlspecialchars($e['date']) ?>" required>
          <input type="text" name="title" value="<?= htmlspecialchars($e['title']) ?>" required>
          <textarea name="desc"><?= htmlspecialchars($e['desc']) ?></textarea>
          <button name="edit">Speichern</button>
          <a href="?delete=<?= $e['id'] ?>" onclick="return confirm('Löschen?')" class="delete-btn">Löschen</a>
        </form>
      </div>
    <?php endforeach; ?>
    <?php if (empty($events)): ?>
      <p>Noch keine Termine vorhanden.</p>
    <?php endif; ?>
  </section>
</main>
</body>
</html>
