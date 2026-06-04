<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>LoveU Festival - Blokkenschema</title>
    <?php include 'theme-init.php' ?>
    <link rel="stylesheet" href="style.css" class="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sansation:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .lineup-page {
            font-family: 'Sansation', sans-serif;
        }

        .schedule-header {
            text-align: center;
            margin: 40px 0 8px;
        }

        .schedule-header h1 {
            font-size: 42px;
            letter-spacing: 2px;
            line-height: 1.15;
        }

        .schedule-header .subtitle {
            color: var(--text-subtle);
            font-size: 15px;
            font-weight: 400;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .day-selector {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin: 28px 0 20px;
            flex-wrap: wrap;
        }

        .day-btn {
            background: var(--day-btn-bg);
            border: 2px solid var(--day-btn-border);
            color: var(--day-btn-color);
            padding: 12px 36px;
            font-size: 17px;
            font-weight: bold;
            font-style: italic;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Sansation', sans-serif;
        }

        .day-btn.active {
            background: var(--day-btn-active-bg);
            color: var(--day-btn-active-color);
            border-color: var(--day-btn-active-bg);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .day-btn:hover:not(.active) {
            opacity: 0.9;
        }

        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin: 0 0 20px;
        }

        .dj-filter-btn {
            background: var(--day-btn-bg);
            border: 2px solid var(--day-btn-border);
            color: var(--day-btn-color);
            padding: 10px 24px;
            font-size: 15px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Sansation', sans-serif;
        }

        .dj-filter-btn.active {
            background: var(--day-btn-active-bg);
            color: var(--day-btn-active-color);
            border-color: var(--day-btn-active-bg);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .search-group {
            position: relative;
        }

        .search-input {
            min-width: 220px;
            max-width: 320px;
            width: 100%;
            border: 2px solid var(--day-btn-border);
            background: var(--day-btn-bg);
            color: var(--day-btn-color);
            padding: 10px 42px 10px 16px;
            font-size: 15px;
            border-radius: 50px;
            transition: border-color 0.25s, background 0.25s;
            font-family: 'Sansation', sans-serif;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--day-btn-active-bg);
        }

        .search-clear-btn {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--day-btn-color);
            font-size: 18px;
            width: 28px;
            height: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-clear-btn:hover {
            color: var(--day-btn-active-color);
        }

        .favorite-filter-btn {
            background: var(--day-btn-bg);
            border: 2px solid var(--day-btn-border);
            color: var(--day-btn-color);
            padding: 10px 24px;
            font-size: 15px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Sansation', sans-serif;
        }

        .favorite-filter-btn.active {
            background: var(--day-btn-active-bg);
            color: var(--day-btn-active-color);
            border-color: var(--day-btn-active-bg);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .favorite-filter-btn:hover:not(.active) {
            opacity: 0.9;
        }

        .no-results {
            padding: 24px 18px;
            text-align: center;
            color: var(--text-subtle);
            font-size: 15px;
        }

        .gantt-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            cursor: grab;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            margin: 0 0 16px;
            padding-bottom: 12px;
            background: var(--gantt-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .gantt-wrapper:active {
            cursor: grabbing;
        }

        .gantt-inner {
            --hour-width: 130px;
            min-width: calc(60px + 14 * var(--hour-width));
            padding: 16px 16px 20px;
        }

        .gantt-time-axis,
        .gantt-row {
            display: grid;
            grid-template-columns: 60px calc(14 * var(--hour-width));
        }

        .gantt-time-axis {
            margin-bottom: 8px;
            padding-left: 0;
        }

        .gantt-time-axis .axis-spacer {
            grid-column: 1;
            border-right: 1px solid var(--border-color);
        }

        .gantt-time-track {
            position: relative;
            height: 28px;
            border-bottom: 1px solid var(--border-color);
        }

        .gantt-time-label {
            position: absolute;
            transform: translateX(-50%);
            font-size: 11px;
            color: var(--text-subtle);
            font-weight: 700;
            top: 4px;
            white-space: nowrap;
        }

        .gantt-time-label:first-of-type {
            transform: translateX(0);
        }

        .gantt-rows {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .gantt-row {
            align-items: stretch;
            min-height: 80px;
        }

        .gantt-stage-label {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: var(--color-cerulean);
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            text-align: center;
            border-right: 1px solid var(--border-color);
            padding: 8px 4px;
            white-space: nowrap;
            letter-spacing: 0.5px;
        }

        .gantt-track {
            position: relative;
            background: var(--gantt-track-bg);
            border-radius: 8px;
            min-height: 80px;
            width: calc(14 * var(--hour-width));
            overflow: hidden;
        }

        .gantt-track::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                90deg,
                transparent,
                transparent calc(100% / 14 - 1px),
                var(--gantt-grid-line) calc(100% / 14 - 1px),
                var(--gantt-grid-line) calc(100% / 14)
            );
            pointer-events: none;
        }

        .gantt-block {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            position: absolute;
            top: 6px;
            bottom: 6px;
            border-radius: 8px;
            padding: 6px 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            background: var(--block-bg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
            z-index: 1;
        }

        .gantt-block:hover {
            transform: scale(1.02);
            z-index: 2;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
        }

        .gantt-block.headliner {
            border-width: 2px;
            border-color: rgba(255, 255, 255, 0.45);
            box-shadow: 0 0 12px var(--block-glow, rgba(233, 69, 96, 0.4));
        }

        .gantt-block-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            overflow: hidden;
            padding-right: 18px;
        }

        .gantt-block .block-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #ffffff;
        }

        .gantt-block.headliner .block-name {
            font-size: 15px;
        }

        .gantt-block .block-time {
            font-size: 11px;
            opacity: 0.9;
            margin-top: 2px;
            white-space: nowrap;
            color: rgba(255, 255, 255, 0.9);
        }

        .gantt-block.narrow .block-name {
            font-size: 10px;
        }

        .gantt-block.narrow .block-time {
            display: none;
        }

        /* Heart buttons inside blocks */
        .block-favorite-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 5;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.45);
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .block-favorite-btn:hover {
            transform: translateY(-50%) scale(1.15);
            color: var(--color-white);
        }

        .block-favorite-btn.active {
            color: var(--color-vermilion);
        }

        .block-favorite-btn svg {
            width: 17px;
            height: 17px;
            fill: currentColor;
            stroke: var(--color-white);
            stroke-width: 2.2;
        }

        .block-favorite-btn.active svg {
            fill: var(--color-vermilion);
            stroke: var(--color-vermilion);
        }

        .gantt-block.narrow .block-favorite-btn {
            display: none;
        }

        .stage-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px 24px;
            margin: 20px 0 8px;
            font-size: 13px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .scroll-hint {
            text-align: center;
            margin-top: 8px;
            color: var(--text-subtle);
            font-size: 12px;
        }

        .schedule-header h1 span {
            color: var(--subtitle-grey);
        }

        /* Artist Detail SPA Page View */
        .artist-detail-page {
            width: min(520px, 100%);
            margin: 0 auto;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .artist-hero-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .artist-photo-container {
            width: 100%;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, var(--color-cerulean), var(--color-vermilion));
        }

        .artist-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .artist-hero-card:hover .artist-photo {
            transform: scale(1.02);
        }

        .artist-detail-body {
            padding: 24px 20px;
        }

        .artist-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .artist-name-title {
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--color-cerulean);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .artist-favorite-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            color: rgba(0, 0, 0, 0.25);
            transition: transform 0.2s, color 0.2s;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        html[data-theme="dark"] .artist-favorite-btn {
            color: rgba(255, 255, 255, 0.25);
        }

        .artist-favorite-btn:hover {
            transform: scale(1.15);
        }

        .artist-favorite-btn.active {
            color: var(--color-vermilion);
        }

        .artist-favorite-btn svg {
            width: 28px;
            height: 28px;
            fill: currentColor;
            stroke: currentColor;
            stroke-width: 1.5;
        }

        .artist-favorite-btn.active svg {
            fill: var(--color-vermilion);
            stroke: var(--color-vermilion);
        }

        .artist-meta {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 16px;
            font-weight: 400;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .artist-youtube {
            margin-bottom: 16px;
        }

        .artist-youtube a {
            color: var(--color-cerulean);
            font-weight: 600;
            text-decoration: none;
        }

        .artist-youtube a:hover {
            text-decoration: underline;
        }

        .artist-bio {
            font-size: 1.05rem;
            line-height: 1.6;
            font-weight: 400;
            color: var(--text-primary);
            margin: 0;
        }

        @media (max-width: 768px) {
            .schedule-header h1 {
                font-size: 28px;
            }

            .day-btn {
                padding: 10px 24px;
                font-size: 14px;
            }

            .gantt-inner {
                --hour-width: 100px;
            }

            .gantt-row {
                min-height: 68px;
            }

            .gantt-track {
                min-height: 68px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php' ?>
    </header>

    <main class="lineup-page">
        <div id="lineupMainContent">
        <div class="schedule-header">
            <h1><span style="color: grey;">LINE - UP</span></h1>
            <h1>SCHEDULE</h1>
            <p class="subtitle" data-i18n="lineup.subtitle">Voorlopig blokkenschema · LoveU Festival 2026 · 10:00 – 23:45</p>
        </div>

        <div class="day-selector">
            <button class="day-btn active" data-day="saturday" type="button" data-i18n="lineup.saturday">Zaterdag</button>
            <button class="day-btn" data-day="sunday" type="button" data-i18n="lineup.sunday">Zondag</button>
        </div>

        <div class="filter-bar">
            <div class="search-group">
                <input id="artistSearchInput" class="search-input" type="search" placeholder="Zoek artiest..." aria-label="Zoek artiest">
                <button id="searchClearBtn" type="button" class="search-clear-btn" aria-label="Wis zoekopdracht">&times;</button>
            </div>
            <button id="djFilterBtn" type="button" class="dj-filter-btn">Toon DJ sets</button>
            <button id="favoriteFilterBtn" type="button" class="favorite-filter-btn">Toon favorieten</button>
        </div>

        <div class="stage-legend" id="stageLegend"></div>

        <div class="gantt-wrapper" id="ganttWrapper">
            <div class="gantt-inner" id="ganttChart"></div>
        </div>

        <p class="scroll-hint">← Veeg of scroll naar rechts voor het volledige schema →</p>
        </div>

        <!-- Artist Detail SPA View -->
        <div id="artistDetailView" style="display: none;" class="artist-detail-page">
            <div class="artist-hero-card">
                <div class="artist-photo-container" id="artistPhotoContainer">
                    <img id="artistDetailImage" src="" alt="Artist Photo" class="artist-photo">
                </div>
                <div class="artist-detail-body">
                    <div class="artist-title-row">
                        <h2 id="artistDetailName" class="artist-name-title"></h2>
                        <button type="button" class="artist-favorite-btn" id="artistDetailFavoriteBtn" aria-label="Favoriet">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="artist-meta" id="artistDetailMeta"></div>
                    <div class="artist-youtube" id="artistDetailYoutubeContainer" style="display:none;">
                        <a id="artistDetailYoutubeLink" href="#" target="_blank" rel="noopener noreferrer"></a>
                    </div>
                    <p class="artist-bio" id="artistDetailBio" data-bio-nl="" data-bio-en=""></p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>

    <script>
        const DAY_START_MIN = 10 * 60;
        const DAY_END_MIN = 23 * 60 + 45;
        const DAY_SPAN = DAY_END_MIN - DAY_START_MIN;

        const STAGES = [
            { id: 'podium', name: 'Podium', color: '#247BA0', bg: 'linear-gradient(135deg, #247BA0, #1b6282)', glow: 'rgba(36, 123, 160, 0.45)' },
            { id: 'lake', name: 'The Lake', color: '#247BA0', bg: 'linear-gradient(135deg, #247BA0, #1b6282)', glow: 'rgba(36, 123, 160, 0.45)' },
            { id: 'club', name: 'The Club', color: '#247BA0', bg: 'linear-gradient(135deg, #247BA0, #1b6282)', glow: 'rgba(36, 123, 160, 0.45)' },
            { id: 'hanggar', name: 'Hangar', color: '#247BA0', bg: 'linear-gradient(135deg, #247BA0, #1b6282)', glow: 'rgba(36, 123, 160, 0.45)' }
        ];

        const saturdaySchedule = {
            podium: [
                { 
                    name: 'Armin van Buuren', start: '10:30', end: '12:00', headliner: true, image: 'images/armin.png',
                    youtube_url: 'https://www.youtube.com/watch?v=EIL4UJBvxuM',
                    bio_nl: 'Armin van Buuren is een wereldberoemde Nederlandse DJ en producer van trancemuziek. Hij werd maar liefst vijf keer uitgeroepen tot nummer 1 DJ van de wereld en is bekend van hits als "This Is What It Feels Like".',
                    bio_en: 'Armin van Buuren is a world-renowned Dutch DJ and trance music producer. He has been crowned the world\'s number one DJ a record five times and is famous for anthems like "This Is What It Feels Like".'
                },
                { 
                    name: 'Kensington', start: '12:30', end: '14:15', headliner: true, image: 'images/kensington.png',
                    youtube_url: 'https://www.youtube.com/watch?v=ZoQO7e2THIw&list=RDZoQO7e2THIw&start_radio=1',
                    bio_nl: 'Kensington is een van de succesvolste Nederlandse rockbands van het afgelopen decennium, bekend om hun meeslepende gitaarriffs en epische stadionshows met hits zoals "War" en "Sorry".',
                    bio_en: 'Kensington is one of the most successful Dutch rock bands of the past decade, known for their gripping guitar riffs and epic stadium shows featuring hits like "War" and "Sorry".'
                },
                { 
                    name: 'De Staat', start: '15:00', end: '16:45', headliner: true, image: 'images/destaat.png',
                    youtube_url: 'https://www.youtube.com/watch?v=0ttGgIQpAUc&list=RD0ttGgIQpAUc&start_radio=1',
                    bio_nl: 'De Staat is een Nederlandse alternatieve rockband uit Nijmegen. De band staat bekend om hun energieke, ritmische en humoristische rocktracks en legendarische festivalshows.',
                    bio_en: 'De Staat is a Dutch alternative rock band from Nijmegen. They are famous for their energetic, rhythmic, and humorous rock tracks and legendary festival performances.'
                },
                { 
                    name: 'Navarone', start: '17:15', end: '18:30', headliner: true, image: 'images/navarone.png',
                    youtube_url: 'https://www.youtube.com/watch?v=48PZSz2VV9k',
                    bio_nl: 'Navarone is een Nederlandse rockband die bekend staat om hun energieke liveshows en een unieke mix van 70s rock en moderne alternatieve rock.',
                    bio_en: 'Navarone is a Dutch rock band known for their energetic live shows and a unique mixture of 70s rock and modern alternative rock.'
                },
                { 
                    name: 'Dotan', start: '19:00', end: '21:00', headliner: true, image: 'images/dotan.png',
                    youtube_url: 'https://www.youtube.com/watch?v=w2ZB7WF_Hko&list=RDw2ZB7WF_Hko&start_radio=1',
                    bio_nl: 'Dotan is een Nederlandse singer-songwriter die bekendstaat om zijn sfeervolle indie-folk en emotionele, krachtige ballads zoals "Home".',
                    bio_en: 'Dotan is a Dutch singer-songwriter known for his atmospheric indie-folk and emotional, powerful ballads like "Home".'
                },
                { 
                    name: 'Froukje', start: '21:30', end: '23:45', headliner: true, image: 'images/froukje.png',
                    youtube_url: 'https://www.youtube.com/watch?v=1Eubp_a4zSg&list=RD1Eubp_a4zSg&start_radio=1',
                    bio_nl: 'Froukje is een jonge, getalenteerde Nederlandse zangeres en songschrijver. Met haar maatschappelijk geëngageerde en dansbare Nederlandstalige popmuziek wist ze in korte tijd de harten van vele muziekliefhebbers te veroveren.',
                    bio_en: 'Froukje is a young, talented Dutch singer-songwriter. With her socially engaged and danceable Dutch-language pop music, she quickly captured the hearts of music fans nationwide.'
                }
            ],
            lake: [
                { name: 'Talent set 1', start: '10:00', end: '11:15', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 2', start: '11:45', end: '13:00', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 3', start: '14:00', end: '15:30', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 4', start: '16:00', end: '17:30', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 5', start: '18:00', end: '19:15', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 6', start: '19:45', end: '21:00', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 7', start: '21:15', end: '22:45', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' }
            ],
            club: [
                { name: 'Comedy', start: '12:15', end: '13:30', bio_nl: 'Lachen gieren brullen met bekende en onbekende comedians.', bio_en: 'Have a laugh with popular local and international comedians.' },
                { name: 'Lecture', start: '14:30', end: '15:45', bio_nl: 'Inspirerende verhalen en discussies over kunst en cultuur.', bio_en: 'Inspiring stories and cultural lectures by various speakers.' },
                { name: 'Theater', start: '16:15', end: '18:00', bio_nl: 'Prachtige live performances en intiem modern theater.', bio_en: 'Beautiful live performances and intimate modern theater.' },
                { name: 'Movie', start: '18:30', end: '20:15', bio_nl: 'Geniet van artistieke korte films en documentaires.', bio_en: 'Enjoy indie short films and documentaries on the big screen.' },
                { name: 'Performance', start: '20:30', end: '21:45', bio_nl: 'Verrassende kunst en experimentele live acts.', bio_en: 'Surprise live performances and experimental art acts.' },
                { name: 'Illusionist', start: '22:15', end: '23:30', bio_nl: 'Een adembenemende show vol goochelkunst en illusie.', bio_en: 'A breathtaking show filled with magic and illusions.' }
            ],
            hanggar: [
                { name: 'DJ set 1', start: '10:00', end: '11:15', bio_nl: 'Non-stop house en techno beats om de dag goed te beginnen.', bio_en: 'Non-stop house and techno beats to kickstart your day.' },
                { name: 'DJ set 2', start: '11:45', end: '13:15', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 3', start: '13:45', end: '15:15', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 4', start: '15:45', end: '17:15', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 5', start: '17:45', end: '19:15', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 6', start: '19:45', end: '21:15', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 7', start: '21:45', end: '23:15', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 8', start: '23:30', end: '23:45', bio_nl: 'Lekker dansen tot het einde van de avond.', bio_en: 'Dance and party until the night ends.' }
            ]
        };

        const sundaySchedule = {
            podium: [
                { 
                    name: 'Martin Garrix', start: '10:45', end: '12:45', headliner: true, image: 'images/garrix.png',
                    youtube_url: 'https://www.youtube.com/watch?v=AN2cMkRpvyg',
                    bio_nl: 'Martin Garrix is een Nederlandse DJ en producer die op 17-jarige leeftijd wereldwijd doorbrak met zijn megahit "Animals". Sindsdien is hij een vaste headliner op de grootste festivals ter wereld.',
                    bio_en: 'Martin Garrix is a Dutch DJ and producer who achieved global fame at the age of 17 with his chart-topping hit "Animals". He is now a staple headliner at the world\'s largest music festivals.'
                },
                { 
                    name: 'Within Temptation', start: '13:45', end: '15:45', headliner: true, image: '',
                    youtube_url: 'https://www.youtube.com/watch?v=Jf1fSWq7szk',
                    bio_nl: 'Within Temptation is een Nederlandse symfonische metalband opgericht in 1996 door Sharon den Adel en Robert Westerholt. Ze zijn wereldwijd bekend om hun melodische en krachtige metal sound.',
                    bio_en: 'Within Temptation is a Dutch symphonic metal band founded in 1996 by vocalist Sharon den Adel and guitarist Robert Westerholt. They are globally renowned for their melodic and powerful metal sound.'
                },
                { 
                    name: "Chef'Special", start: '16:30', end: '18:30', headliner: true, image: '',
                    youtube_url: 'https://www.youtube.com/watch?v=lZKqbRZ1Tfc',
                    bio_nl: 'Chef\'Special is een Nederlandse indiepopband uit Haarlem, opgericht in 2008. Hun unieke mix van reggae, rock en hiphop zorgt altijd voor een energieke, positieve festival vibe.',
                    bio_en: 'Chef\'Special is a Dutch indie pop band from Haarlem, formed in 2008. Their unique blend of reggae, rock, and hip-hop consistently delivers an energetic, positive festival vibe.'
                },
                { 
                    name: 'Eefje de Visser', start: '19:15', end: '21:15', headliner: true, image: '',
                    youtube_url: 'https://www.youtube.com/watch?v=8zZch3VwM4Q',
                    bio_nl: 'Eefje de Visser is een Nederlandse zangeres en songschrijver met een betoverend mooie, melancholische indie-pop sound en een visueel verbluffende liveshow.',
                    bio_en: 'Eefje de Visser is a Dutch singer-songwriter featuring an enchantingly beautiful, melancholic indie-pop sound and a visually stunning live performance.'
                },
                { 
                    name: 'Spinvis', start: '22:00', end: '23:45', headliner: true, image: 'images/spinvis.png',
                    youtube_url: 'https://www.youtube.com/watch?v=byPbBj5zQbA',
                    bio_nl: 'Spinvis is de eenmansband van Erik de Jong. Het in 2002 uitgekomen lo-fi debuut laat poëtische teksten en melancholische melodieën horen die Spinvis op zijn zolderkamer in elkaar knutselde. Zijn unieke sound is een begrip in de Nederlandse popmuziek.',
                    bio_en: 'Spinvis is the project of Dutch indie pop artist Erik de Jong. His lo-fi debut released in 2002 features poetic lyrics and melancholic melodies recorded in his attic. His unique sound is legendary in the Dutch music scene.'
                }
            ],
            lake: [
                { name: 'Talent set 1', start: '10:00', end: '11:15', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 2', start: '11:45', end: '13:45', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 3', start: '14:15', end: '15:45', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 4', start: '16:15', end: '18:15', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 5', start: '18:45', end: '20:15', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' },
                { name: 'Talent set 6', start: '20:45', end: '22:45', bio_nl: 'Ontdek nieuw en verrassend talent op dit podium!', bio_en: 'Discover new and surprising talent on this stage!' }
            ],
            club: [
                { name: 'Comedy', start: '12:15', end: '13:30', bio_nl: 'Lachen gieren brullen met bekende en onbekende comedians.', bio_en: 'Have a laugh with popular local and international comedians.' },
                { name: 'Lecture', start: '14:15', end: '15:30', bio_nl: 'Inspirerende verhalen en discussies over kunst en cultuur.', bio_en: 'Inspiring stories and cultural lectures by various speakers.' },
                { name: 'Theater', start: '16:15', end: '17:30', bio_nl: 'Prachtige live performances en intiem modern theater.', bio_en: 'Beautiful live performances and intimate modern theater.' },
                { name: 'Movie', start: '18:00', end: '20:15', bio_nl: 'Geniet van artistieke korte films en documentaires.', bio_en: 'Enjoy indie short films and documentaries on the big screen.' },
                { name: 'Magic Show', start: '21:00', end: '22:30', bio_nl: 'Een betoverende show vol goochelkunst en verrassende trucs.', bio_en: 'A magical show featuring card tricks, illusion, and fun.' }
            ],
            hanggar: [
                { name: 'DJ set 1', start: '10:00', end: '10:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 2', start: '11:00', end: '12:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 3', start: '13:15', end: '14:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 4', start: '15:15', end: '16:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 5', start: '17:15', end: '18:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 6', start: '19:15', end: '20:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 7', start: '21:15', end: '22:45', bio_nl: 'Non-stop house en techno beats.', bio_en: 'Non-stop house and techno beats.' },
                { name: 'DJ set 8', start: '23:15', end: '23:45', bio_nl: 'Afsluiten met brute techno baslijnen.', bio_en: 'Ending the festival with heavy techno basslines.' }
            ]
        };

        function timeToMinutes(time) {
            const [h, m] = time.split(':').map(Number);
            return h * 60 + m;
        }

        function blockPosition(start, end) {
            const startMin = timeToMinutes(start);
            const endMin = timeToMinutes(end);
            const left = ((startMin - DAY_START_MIN) / DAY_SPAN) * 100;
            const width = ((endMin - startMin) / DAY_SPAN) * 100;
            return { left, width };
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function isFavorite(name) {
            try {
                const favorites = JSON.parse(localStorage.getItem('ufestival-favorites') || '[]');
                return favorites.includes(name);
            } catch (e) {
                return false;
            }
        }

        function toggleFavorite(name) {
            try {
                let favorites = JSON.parse(localStorage.getItem('ufestival-favorites') || '[]');
                if (favorites.includes(name)) {
                    favorites = favorites.filter(n => n !== name);
                } else {
                    favorites.push(name);
                }
                localStorage.setItem('ufestival-favorites', JSON.stringify(favorites));
                
                // Re-render blocks to keep hearts updated
                const scrollPos = wrapper.scrollLeft;
                const activeBtn = document.querySelector('.day-btn.active');
                const activeDay = activeBtn ? activeBtn.getAttribute('data-day') : 'saturday';
                renderGantt(activeDay);
                wrapper.scrollLeft = scrollPos;

                // Sync detail view heart if open
                updateDetailFavoriteButtonState(name);
            } catch (e) { /* ignore */ }
        }

        function updateDetailFavoriteButtonState(name) {
            const detailBtn = document.getElementById('artistDetailFavoriteBtn');
            const detailName = document.getElementById('artistDetailName')?.textContent;
            if (detailBtn && detailName === name) {
                if (isFavorite(name)) {
                    detailBtn.classList.add('active');
                } else {
                    detailBtn.classList.remove('active');
                }
            }
        }

        function renderLegend() {
            document.getElementById('stageLegend').innerHTML = STAGES.map(s =>
                `<span class="legend-item"><span class="legend-dot" style="background:${s.color}"></span>${escapeHtml(s.name)}</span>`
            ).join('');
        }

        function renderTimeAxis() {
            let labels = '';
            for (let h = 10; h <= 23; h++) {
                const min = h * 60;
                const pct = ((min - DAY_START_MIN) / DAY_SPAN) * 100;
                const label = `${String(h).padStart(2, '0')}:00`;
                labels += `<span class="gantt-time-label" style="left:${pct}%">${label}</span>`;
            }
            return `
                <div class="gantt-time-axis">
                    <div class="axis-spacer"></div>
                    <div class="gantt-time-track">${labels}</div>
                </div>`;
        }

        function renderBlock(act, stage) {
            const { left, width } = blockPosition(act.start, act.end);
            const narrow = width < 5;
            const classes = ['gantt-block', act.headliner ? 'headliner' : '', narrow ? 'narrow' : ''].filter(Boolean).join(' ');
            const timeLabel = `${act.start} – ${act.end}`;
            const favorited = isFavorite(act.name);
            
            const heartHtml = `
                <button type="button" class="block-favorite-btn ${favorited ? 'active' : ''}" 
                        data-artist="${escapeHtml(act.name)}" aria-label="Favoriet">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
            `;

            return `
                <div class="${classes}"
                     style="left:${left}%;width:${width}%;--block-bg:${stage.bg};--block-glow:${stage.glow}"
                     role="button" tabindex="0"
                     data-name="${escapeHtml(act.name)}"
                     data-stage="${escapeHtml(stage.name)}"
                     data-time="${escapeHtml(timeLabel)}"
                     title="${escapeHtml(act.name)} · ${timeLabel}">
                    <div class="gantt-block-content">
                        <span class="block-name">${escapeHtml(act.name)}</span>
                        <span class="block-time">${escapeHtml(timeLabel)}</span>
                    </div>
                    ${heartHtml}
                </div>`;
        }

        function findArtistByName(name) {
            // Search saturday
            for (const stageId in saturdaySchedule) {
                const act = saturdaySchedule[stageId].find(a => a.name === name);
                if (act) return { ...act, stageName: STAGES.find(s => s.id === stageId)?.name || stageId };
            }
            // Search sunday
            for (const stageId in sundaySchedule) {
                const act = sundaySchedule[stageId].find(a => a.name === name);
                if (act) return { ...act, stageName: STAGES.find(s => s.id === stageId)?.name || stageId };
            }
            return null;
        }

        function updateArtistBioLanguage() {
            const bioEl = document.getElementById('artistDetailBio');
            if (!bioEl) return;
            const lang = typeof getStoredLanguage === 'function' ? getStoredLanguage() : 'nl';
            const bioText = lang === 'en' ? bioEl.dataset.bioEn : bioEl.dataset.bioNl;
            bioEl.textContent = bioText || '';
        }

        function showArtistDetail(name) {
            const act = findArtistByName(name);
            if (!act) return;

            const view = document.getElementById('artistDetailView');
            const mainContent = document.getElementById('lineupMainContent');
            const headerTitle = document.getElementById('headerTitle');
            const backBtn = document.getElementById('headerBackBtn');
            const detailName = document.getElementById('artistDetailName');
            const detailImage = document.getElementById('artistDetailImage');
            const detailMeta = document.getElementById('artistDetailMeta');
            const detailBio = document.getElementById('artistDetailBio');
            const detailFav = document.getElementById('artistDetailFavoriteBtn');

            if (!view || !mainContent) return;

            // Set content
            detailName.textContent = act.name;
            detailMeta.innerHTML = `Stage: <strong>${escapeHtml(act.stageName)}</strong> &nbsp;·&nbsp; Tijd: <strong>${escapeHtml(act.start)} – ${escapeHtml(act.end)}</strong>`;
            
            detailBio.dataset.bioNl = act.bio_nl || '';
            detailBio.dataset.bioEn = act.bio_en || '';
            updateArtistBioLanguage();

            // Set image or fall back to gradient design
            const photoContainer = document.getElementById('artistPhotoContainer');
            if (act.image) {
                detailImage.src = act.image;
                detailImage.style.display = 'block';
                if (photoContainer) photoContainer.classList.add('has-image');
            } else {
                detailImage.src = '';
                detailImage.style.display = 'none';
                if (photoContainer) photoContainer.classList.remove('has-image');
            }

            const youtubeContainer = document.getElementById('artistDetailYoutubeContainer');
            const youtubeLink = document.getElementById('artistDetailYoutubeLink');
            if (youtubeContainer && youtubeLink) {
                if (act.youtube_url) {
                    youtubeLink.href = act.youtube_url;
                    youtubeLink.textContent = 'Bekijk officiële video op YouTube';
                    youtubeContainer.style.display = 'block';
                } else {
                    youtubeContainer.style.display = 'none';
                }
            }

            // Set favorite button active state
            if (isFavorite(act.name)) {
                detailFav.classList.add('active');
            } else {
                detailFav.classList.remove('active');
            }

            // Wire up favorite click inside detail
            detailFav.onclick = () => {
                toggleFavorite(act.name);
            };

            // Switch layout to SPA detail mode
            mainContent.style.display = 'none';
            view.style.display = 'block';
            document.body.classList.add('artist-detail-active');
            if (headerTitle) headerTitle.textContent = 'FESTIVAL';

            // Wire up header back button click
            if (backBtn) {
                backBtn.onclick = () => {
                    hideArtistDetail();
                };
            }
        }

        function hideArtistDetail() {
            const view = document.getElementById('artistDetailView');
            const mainContent = document.getElementById('lineupMainContent');
            const headerTitle = document.getElementById('headerTitle');

            if (!view || !mainContent) return;

            view.style.display = 'none';
            mainContent.style.display = 'block';
            document.body.classList.remove('artist-detail-active');
            if (headerTitle) headerTitle.textContent = 'U FESTIVAL';

            // Refresh blocks to ensure favorites icons update correctly
            const activeBtn = document.querySelector('.day-btn.active');
            const activeDay = activeBtn ? activeBtn.getAttribute('data-day') : 'saturday';
            renderGantt(activeDay);
        }

        // Listen for global language toggle clicks to update detail bios dynamically
        document.getElementById('languageToggleBtn')?.addEventListener('click', () => {
            setTimeout(updateArtistBioLanguage, 50);
        });

        document.querySelectorAll('.day-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                renderGantt(this.getAttribute('data-day'));
            });
        });

        const wrapper = document.getElementById('ganttWrapper');
        let isDown = false;
        let startX;
        let scrollLeft;

        wrapper.addEventListener('mousedown', (e) => {
            isDown = true;
            wrapper.style.cursor = 'grabbing';
            startX = e.pageX - wrapper.offsetLeft;
            scrollLeft = wrapper.scrollLeft;
        });

        wrapper.addEventListener('mouseleave', () => {
            isDown = false;
            wrapper.style.cursor = 'grab';
        });

        wrapper.addEventListener('mouseup', () => {
            isDown = false;
            wrapper.style.cursor = 'grab';
        });

        wrapper.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - wrapper.offsetLeft;
            wrapper.scrollLeft = scrollLeft - (x - startX) * 2;
        });

        let showFavoritesOnly = false;
        let showDjSetsOnly = false;

        function getSearchQuery() {
            const input = document.getElementById('artistSearchInput');
            return input ? input.value.trim().toLowerCase() : '';
        }

        function updateFavoriteFilterButton() {
            const filterBtn = document.getElementById('favoriteFilterBtn');
            if (!filterBtn) return;
            if (showFavoritesOnly) {
                filterBtn.classList.add('active');
                filterBtn.textContent = 'Alle artiesten';
            } else {
                filterBtn.classList.remove('active');
                filterBtn.textContent = 'Toon favorieten';
            }
        }

        function updateDjFilterButton() {
            const filterBtn = document.getElementById('djFilterBtn');
            if (!filterBtn) return;
            if (showDjSetsOnly) {
                filterBtn.classList.add('active');
                filterBtn.textContent = 'Alle artiesten';
            } else {
                filterBtn.classList.remove('active');
                filterBtn.textContent = 'Toon DJ sets';
            }
        }

        function renderGantt(day) {
            const schedule = day === 'saturday' ? saturdaySchedule : sundaySchedule;
            const chart = document.getElementById('ganttChart');
            const searchQuery = getSearchQuery();

            let rows = renderTimeAxis();
            rows += '<div class="gantt-rows">';

            STAGES.forEach(stage => {
                const acts = schedule[stage.id] || [];
                const blocks = acts
                    .filter(act => {
                        if (showFavoritesOnly && !isFavorite(act.name)) return false;
                        if (showDjSetsOnly && !act.name.toLowerCase().includes('dj set')) return false;
                        if (!searchQuery) return true;
                        const name = act.name.toLowerCase();
                        const bioNl = (act.bio_nl || '').toLowerCase();
                        const bioEn = (act.bio_en || '').toLowerCase();
                        return name.includes(searchQuery) || bioNl.includes(searchQuery) || bioEn.includes(searchQuery);
                    })
                    .map(act => renderBlock(act, stage)).join('');
                rows += `
                    <div class="gantt-row">
                        <div class="gantt-stage-label" style="--stage-color:${stage.color}">${escapeHtml(stage.name)}</div>
                        <div class="gantt-track">${blocks}</div>
                    </div>`;
            });

            rows += '</div>';
            chart.innerHTML = rows;

            const visibleBlocks = chart.querySelectorAll('.gantt-block').length;
            if (visibleBlocks === 0) {
                let message = 'Geen artiesten gevonden voor deze dag.';
                if (searchQuery && showFavoritesOnly) {
                    message = 'Geen favoriete artiesten gevonden voor deze zoekopdracht.';
                } else if (searchQuery) {
                    message = 'Geen artiesten gevonden voor deze zoekopdracht.';
                } else if (showFavoritesOnly) {
                    message = 'Geen favorieten gevonden voor deze dag.';
                }
                chart.querySelector('.gantt-rows').innerHTML = `<div class="no-results">${message}</div>`;
            }

            // Wire block event listeners
            chart.querySelectorAll('.gantt-block').forEach(block => {
                const artistName = block.dataset.name;

                // Click block -> details view
                block.addEventListener('click', (e) => {
                    // Ignore clicks that target the favorite button inside the block
                    if (e.target.closest('.block-favorite-btn')) return;
                    showArtistDetail(artistName);
                });

                // Keypress block -> details view
                block.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        if (e.target.closest('.block-favorite-btn')) return;
                        e.preventDefault();
                        showArtistDetail(artistName);
                    }
                });

                // Toggling favorites on block heart click
                const favBtn = block.querySelector('.block-favorite-btn');
                if (favBtn) {
                    favBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        toggleFavorite(artistName);
                    });
                }
            });
        }

        document.getElementById('favoriteFilterBtn')?.addEventListener('click', () => {
            showFavoritesOnly = !showFavoritesOnly;
            const activeBtn = document.querySelector('.day-btn.active');
            const activeDay = activeBtn ? activeBtn.getAttribute('data-day') : 'saturday';
            renderGantt(activeDay);
            updateFavoriteFilterButton();
        });

        document.getElementById('djFilterBtn')?.addEventListener('click', () => {
            showDjSetsOnly = !showDjSetsOnly;
            const activeBtn = document.querySelector('.day-btn.active');
            const activeDay = activeBtn ? activeBtn.getAttribute('data-day') : 'saturday';
            renderGantt(activeDay);
            updateDjFilterButton();
        });

        document.getElementById('artistSearchInput')?.addEventListener('input', () => {
            const activeBtn = document.querySelector('.day-btn.active');
            const activeDay = activeBtn ? activeBtn.getAttribute('data-day') : 'saturday';
            renderGantt(activeDay);
        });

        document.getElementById('searchClearBtn')?.addEventListener('click', () => {
            const input = document.getElementById('artistSearchInput');
            if (!input) return;
            input.value = '';
            input.focus();
            const activeBtn = document.querySelector('.day-btn.active');
            const activeDay = activeBtn ? activeBtn.getAttribute('data-day') : 'saturday';
            renderGantt(activeDay);
        });

        renderLegend();
        updateFavoriteFilterButton();
        updateDjFilterButton();
        renderGantt('saturday');
    </script>
</body>

</html>
