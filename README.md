
# ✅ TODO – Jugendkreis Aulendorf Website Roadmap

## 📘 Überblick

Ziel: Moderne, wartungsarme Website für den Evangelischen Jugendkreis Aulendorf
Enthält: Terminübersicht, Ideen-Tool, Kontaktformular, Adminbereich

---

## 🧭 Phase 1 – Polish & UX (Kurzfristig, 1–2 Wochen)

| Status | Aufgabe                                                                | Fällig |
| :----: | ---------------------------------------------------------------------- | :-----: |
|  [ ]  | Einheitliches Design für**alle Seiten** (Admin, Ideen, Kontakt) |        |
|  [ ]  | Buttons mit**Glow-/Pulse-Animation** aktivieren                  |        |
|  [ ]  | Header-Gradient anpassen (unten dunkler)                               |        |
|  [ ]  | `.button-row`-Abstände und Responsive-Verhalten final prüfen       |        |
|  [ ]  | Footer um Links (Mail, Impressum, Instagram) erweitern                 |        |
|  [ ]  | Formulare optisch verfeinern (Boxshadow, Fokus-Highlight)              |        |
|  [ ]  | Schriftgrößen auf Mobil optimieren                                   |        |
|  [ ]  | (Optional) sanfte Scroll-Animation für Events (AOS)                   |        |
|  [ ]  | (Optional) Hover-Scale-Effekt für Eventkarten                         |        |

---

## 🔧 Phase 2 – Funktional & Smart (1–3 Wochen)

| Status | Aufgabe                                                            | Fällig |
| :----: | ------------------------------------------------------------------ | :-----: |
|  [ ]  | ICS-Export mit**Uhrzeiten 19–21 Uhr** statt ganztägig      |        |
|  [ ]  | Zeitzone `Europe/Berlin` im ICS ergänzen                        |        |
|  [ ]  | Ideen-Upvote-Funktion mit AJAX                                     |        |
|  [ ]  | Neue Spalte `votes INTEGER DEFAULT 0` in DB hinzufügen          |        |
|  [ ]  | Sortierung nach meistgevoteten Ideen                               |        |
|  [ ]  | `mail_log`-Tabelle für Kontaktformular-Sends                    |        |
|  [ ]  | Erfolg/Fehler-Feedback visuell verbessern                          |        |
|  [ ]  | Lokales Mail-Logging aktivieren                                    |        |
|  [ ]  | SQLite-Backup-Skript (`/backups/db_YYYY-MM-DD.sqlite`) erstellen |        |
|  [ ]  | Cronjob oder manueller Backup-Button im Adminbereich               |        |

---

## 🚀 Phase 3 – Komfort & Branding (Langfristig)

| Status | Aufgabe                                                       | Fällig |
| :----: | ------------------------------------------------------------- | :-----: |
|  [ ]  | **PWA fertigstellen** (manifest, service worker, Icons) |        |
|  [ ]  | „Zum Startbildschirm hinzufügen“ testen                    |        |
|  [ ]  | Dynamischer Header (Sommer/Winter-Bilder)                     |        |
|  [ ]  | Newsletter-Tabelle und Eintragungsformular                    |        |
|  [ ]  | Cronjob „Jugendkreis diese Woche“ Mailversand               |        |
|  [ ]  | Statistik-Dashboard (Admin): Ideen, Mails, Events             |        |
|  [ ]  | CSV/PDF-Export aus Admin-Dashboard                            |        |

---

## 🔒 Phase 4 – Technik & Zukunft

| Status | Aufgabe                                               | Fällig |
| :----: | ----------------------------------------------------- | :-----: |
|  [ ]  | Einheitliche `require_once __DIR__` Pfade prüfen   |        |
|  [ ]  | `.htaccess` minimal halten (`Options -Indexes`)   |        |
|  [ ]  | Dateirechte: PHP 644 / Ordner 755                     |        |
|  [ ]  | PHPMailer aktuell halten (`composer update`)        |        |
|  [ ]  | SQLite regelmäßig `VACUUM` ausführen             |        |
|  [ ]  | JSON-API (`/api/events.json`) bereitstellen         |        |
|  [ ]  | QR-Code-Generator für Events                         |        |
|  [ ]  | Anmeldesystem für Aktionen (Ausflüge, Spieleabende) |        |
|  [ ]  | WebPush-Benachrichtigungen für Terminerinnerung      |        |

---

## 📂 Projektstruktur
