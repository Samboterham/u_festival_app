<!DOCTYPE html>
<html lang="nl">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>LoveU Festival - Welcome</title>
   <?php include 'theme-init.php' ?>
   <link rel="stylesheet" href="style.css" class="stylesheet">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
      href="https://fonts.googleapis.com/css2?family=Sansation:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
      rel="stylesheet">
</head>

<body>
   <header>
      <?php include 'header.php' ?>
   </header>
   <main>
      <section class="welcome-page">
         <div class="welcome-hero">
            <p class="welcome-kicker">LoveU Festival 2026</p>
            <h1>Welcome to <span>LoveU Festival</span></h1>
            <p class="welcome-text">
               Alles wat je nodig hebt op een plek: line-up, terrein map en praktische info.
               Klaar voor jouw festivaldag?
            </p>
            <div class="welcome-actions">
               <a class="welcome-btn primary" href="lineup.php">Bekijk Line-up</a>
               <a class="welcome-btn" href="map.php">Open Map</a>
               <a class="welcome-btn" href="info.php">Festival Info</a>
            </div>
         </div>

         <div class="welcome-cards">
            <article class="welcome-card">
               <h2>Line-up</h2>
               <p>Bekijk per dag alle stages en tijden in het blokkenschema.</p>
            </article>
            <article class="welcome-card">
               <h2>Map + GPS</h2>
               <p>Vind podia en faciliteiten snel terug op de interactieve kaart.</p>
            </article>
            <article class="welcome-card">
               <h2>Handige Info</h2>
               <p>Lees alles over bereikbaarheid, lockers, FAQ en regels.</p>
            </article>
         </div>
      </section>
   </main>
   <footer>
      <?php include 'footer.php' ?>
   </footer>
</body>

</html>