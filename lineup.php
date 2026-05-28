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
            color: var(--text-primary);
            padding: 12px 36px;
            font-size: 17px;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Sansation', sans-serif;
        }

        .day-btn.active {
            background: var(--day-btn-active-bg);
            color: #ffffff;
            border-color: var(--day-btn-active-bg);
            box-shadow: 0 0 16px rgba(36, 123, 160, 0.4);
        }

        .day-btn:hover:not(.active) {
            background: rgba(36, 123, 160, 0.15);
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
            /* ~130px per hour → blocks read wider on screen */
            --hour-width: 130px;
            min-width: calc(110px + 14 * var(--hour-width));
            padding: 16px 16px 20px;
        }

        .gantt-time-axis,
        .gantt-row {
            display: grid;
            grid-template-columns: 110px calc(14 * var(--hour-width));
        }

        .gantt-time-axis {
            margin-bottom: 8px;
            padding-left: 0;
        }

        .gantt-time-axis .axis-spacer {
            grid-column: 1;
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
            padding-right: 12px;
            font-weight: 700;
            font-size: 13px;
            line-height: 1.2;
            border-left: 4px solid var(--stage-color, var(--color-brand));
            padding-left: 10px;
            color: var(--text-primary);
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
            position: absolute;
            top: 6px;
            bottom: 6px;
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
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

        .gantt-block .block-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gantt-block.headliner .block-name {
            font-size: 15px;
        }

        .gantt-block .block-time {
            font-size: 11px;
            opacity: 0.9;
            margin-top: 2px;
            white-space: nowrap;
        }

        .gantt-block.narrow .block-name {
            font-size: 10px;
        }

        .gantt-block.narrow .block-time {
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
        <div class="schedule-header">
            <h1><span style="color: grey;">LINE - UP</span></h1>
            <h1>SCHEDULE</h1>
            <p class="subtitle">Voorlopig blokkenschema · LoveU Festival 2026 · 10:00 – 23:45</p>
        </div>

        <div class="day-selector">
            <button class="day-btn active" data-day="saturday" type="button">Zaterdag</button>
            <button class="day-btn" data-day="sunday" type="button">Zondag</button>
        </div>

        <div class="stage-legend" id="stageLegend"></div>

        <div class="gantt-wrapper" id="ganttWrapper">
            <div class="gantt-inner" id="ganttChart"></div>
        </div>

        <p class="scroll-hint">← Veeg of scroll naar rechts voor het volledige schema →</p>
    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>

    <script>
        const DAY_START_MIN = 10 * 60;
        const DAY_END_MIN = 23 * 60 + 45;
        const DAY_SPAN = DAY_END_MIN - DAY_START_MIN;

        const STAGES = [
            { id: 'podium', name: 'Podium', color: '#247BA0', bg: 'linear-gradient(135deg, #247BA0, #1a5f7d)', glow: 'rgba(36, 123, 160, 0.5)' },
            { id: 'lake', name: 'The Lake', color: '#3d9ee8', bg: 'linear-gradient(135deg, #3d9ee8, #2a6fa8)', glow: 'rgba(61, 158, 232, 0.45)' },
            { id: 'club', name: 'The Club', color: '#9b59b6', bg: 'linear-gradient(135deg, #9b59b6, #6c3483)', glow: 'rgba(155, 89, 182, 0.45)' },
            { id: 'hanggar', name: 'Hanggar', color: '#f39c12', bg: 'linear-gradient(135deg, #f39c12, #d68910)', glow: 'rgba(243, 156, 18, 0.45)' }
        ];

        const saturdaySchedule = {
            podium: [
                { name: 'Armin van Buuren', start: '10:30', end: '12:00', headliner: true },
                { name: 'Kensington', start: '12:30', end: '14:15', headliner: true },
                { name: 'De Staat', start: '15:00', end: '16:45', headliner: true },
                { name: 'Navarone', start: '17:15', end: '18:30', headliner: true },
                { name: 'Dotan', start: '19:00', end: '21:00', headliner: true },
                { name: 'Froukje', start: '21:30', end: '23:45', headliner: true }
            ],
            lake: [
                { name: 'Talent set 1', start: '10:00', end: '11:15' },
                { name: 'Talent set 2', start: '11:45', end: '13:00' },
                { name: 'Talent set 3', start: '14:00', end: '15:30' },
                { name: 'Talent set 4', start: '16:00', end: '17:30' },
                { name: 'Talent set 5', start: '18:00', end: '19:15' },
                { name: 'Talent set 6', start: '19:45', end: '21:00' },
                { name: 'Talent set 7', start: '21:15', end: '22:45' }
            ],
            club: [
                { name: 'Comedy', start: '12:15', end: '13:30' },
                { name: 'Lecture', start: '14:30', end: '15:45' },
                { name: 'Theater', start: '16:15', end: '18:00' },
                { name: 'Movie', start: '18:30', end: '20:15' },
                { name: 'Performance', start: '20:30', end: '21:45' },
                { name: 'Illusionist', start: '22:15', end: '23:30' }
            ],
            hanggar: [
                { name: 'DJ set 1', start: '10:00', end: '11:15' },
                { name: 'DJ set 2', start: '11:45', end: '13:15' },
                { name: 'DJ set 3', start: '13:45', end: '15:15' },
                { name: 'DJ set 4', start: '15:45', end: '17:15' },
                { name: 'DJ set 5', start: '17:45', end: '19:15' },
                { name: 'DJ set 6', start: '19:45', end: '21:15' },
                { name: 'DJ set 7', start: '21:45', end: '23:15' },
                { name: 'DJ set 8', start: '23:30', end: '23:45' }
            ]
        };

        const sundaySchedule = {
            podium: [
                { name: 'Martin Garrix', start: '10:45', end: '12:45', headliner: true },
                { name: 'Within Temptation', start: '13:45', end: '15:45', headliner: true },
                { name: "Chef'Special", start: '16:30', end: '18:30', headliner: true },
                { name: 'Eefje de Visser', start: '19:15', end: '21:15', headliner: true },
                { name: 'Spinvis', start: '22:00', end: '23:45', headliner: true }
            ],
            lake: [
                { name: 'Talent set 1', start: '10:00', end: '11:15' },
                { name: 'Talent set 2', start: '11:45', end: '13:45' },
                { name: 'Talent set 3', start: '14:15', end: '15:45' },
                { name: 'Talent set 4', start: '16:15', end: '18:15' },
                { name: 'Talent set 5', start: '18:45', end: '20:15' },
                { name: 'Talent set 6', start: '20:45', end: '22:45' }
            ],
            club: [
                { name: 'Comedy', start: '12:15', end: '13:30' },
                { name: 'Lecture', start: '14:15', end: '15:30' },
                { name: 'Theater', start: '16:15', end: '17:30' },
                { name: 'Movie', start: '18:00', end: '20:15' },
                { name: 'Magic Show', start: '21:00', end: '22:30' }
            ],
            hanggar: [
                { name: 'DJ set 1', start: '10:00', end: '10:45' },
                { name: 'DJ set 2', start: '11:00', end: '12:45' },
                { name: 'DJ set 3', start: '13:15', end: '14:45' },
                { name: 'DJ set 4', start: '15:15', end: '16:45' },
                { name: 'DJ set 5', start: '17:15', end: '18:45' },
                { name: 'DJ set 6', start: '19:15', end: '20:45' },
                { name: 'DJ set 7', start: '21:15', end: '22:45' },
                { name: 'DJ set 8', start: '23:15', end: '23:45' }
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
            return `
                <div class="${classes}"
                     style="left:${left}%;width:${width}%;--block-bg:${stage.bg};--block-glow:${stage.glow}"
                     role="button" tabindex="0"
                     data-name="${escapeHtml(act.name)}"
                     data-stage="${escapeHtml(stage.name)}"
                     data-time="${escapeHtml(timeLabel)}"
                     title="${escapeHtml(act.name)} · ${timeLabel}">
                    <span class="block-name">${escapeHtml(act.name)}</span>
                    <span class="block-time">${escapeHtml(timeLabel)}</span>
                </div>`;
        }

        function renderGantt(day) {
            const schedule = day === 'saturday' ? saturdaySchedule : sundaySchedule;
            const chart = document.getElementById('ganttChart');

            let rows = renderTimeAxis();
            rows += '<div class="gantt-rows">';

            STAGES.forEach(stage => {
                const acts = schedule[stage.id] || [];
                const blocks = acts.map(act => renderBlock(act, stage)).join('');
                rows += `
                    <div class="gantt-row">
                        <div class="gantt-stage-label" style="--stage-color:${stage.color}">${escapeHtml(stage.name)}</div>
                        <div class="gantt-track">${blocks}</div>
                    </div>`;
            });

            rows += '</div>';
            chart.innerHTML = rows;

            chart.querySelectorAll('.gantt-block').forEach(block => {
                const showInfo = () => {
                    const name = block.dataset.name;
                    const stage = block.dataset.stage;
                    const time = block.dataset.time;
                    alert(`${name}\n${stage}\n${time}`);
                };
                block.addEventListener('click', showInfo);
                block.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        showInfo();
                    }
                });
            });
        }

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

        renderLegend();
        renderGantt('saturday');
    </script>
</body>

</html>
