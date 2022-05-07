<?php


use WebtoonLike\Site\core\Router;
use WebtoonLike\Site\pageManager\ImportManager;

ImportManager::CheckNull();

require dirname(__DIR__, 2) . '/components/header.php';


?>

<div aria-describedby="#s1-title" id="app">
    <?= WebtoonLike\Site\pageManager\MessageManager::getMessages() ?>
    <?= WebtoonLike\Site\pageManager\MessageManager::getErrors() ?>

    <svg xmlns="http://www.w3.org/2000/svg" width="976" height="100" viewBox="0 0 976 130" fill="none" id="completion">
        <style>
            :root {
                --svg-primary: #656D6D;
                --svg-accent: #9FABAB;
            }

            svg .svg-txt {
                text-anchor: middle;
            }

            svg .svg-step {
                fill: black;
                font-size: 2.25rem;
                font-weight: bolder;
            }

            svg .svg-details { fill: var(--text-primary); }

            stop {
                transition: stop-color .3s ease;
            }

            svg .svg-switch {
                stop-color: var(--svg-primary);
                offset: 0;
            }

            svg.switched .svg-switch {
                stop-color: var(--svg-accent) !important;
                offset: 20%;
            }
        </style>
        <text x="27.5%" y="95%" class="svg-details svg-txt">Création du webtoon</text>
        <text x="72.5%" y="95%" class="svg-details svg-txt">Ajout des premiers chapitres</text>
        <mask id="mask0_139_252" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="976" height="100">
            <text x="27.5%" y="48%" class="svg-step svg-txt">1</text>
            <text x="72.5%" y="48%" class="svg-step svg-txt">2</text>
            <circle cx="269" cy="50" r="45" transform="rotate(-90 269 50)" stroke="#656D6D" stroke-width="10"/>
            <circle cx="707" cy="50" r="45" stroke="#656D6D" stroke-width="10"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M756.753 55C756.916 53.3555 757 51.6875 757 50C757 48.3125 756.916 46.6445 756.753 45H971C973.761 45 976 47.2386 976 50C976 52.7614 973.761 55 971 55H756.753ZM657.247 55H318.753C318.916 53.3555 319 51.6875 319 50C319 48.3125 318.916 46.6445 318.753 45H657.247C657.084 46.6445 657 48.3125 657 50C657 51.6875 657.084 53.3555 657.247 55ZM5 45H219.247C219.084 46.6445 219 48.3125 219 50C219 51.6875 219.084 53.3555 219.247 55H5.00001C2.23858 55 0 52.7614 0 50C0 47.2386 2.23858 45 5 45Z" fill="#656D6D"/>
        </mask>
        <g mask="url(#mask0_139_252)">
            <rect x="-2" y="-5" width="980" height="110" fill="url(#paint0_linear_139_252)"/>
        </g>
        <defs>
            <linearGradient id="paint0_linear_139_252" x1="0" y1="0" x2="976" y2="0" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="var(--svg-accent)"/>
                <stop offset="15%" stop-color="var(--svg-accent)"/>
                <stop offset="35%" class="svg-switch"/>
                <stop offset="55%" class="svg-switch"/>
                <stop offset="75%" class="svg-switch"/>
                <stop offset="1" stop-color="var(--svg-primary)"/>
            </linearGradient>
        </defs>
    </svg>


<?php ImportManager::getStep()?>





</div>

/*Todo: Supprimer*/
<script src="/assets/scripts/importFormController.js"></script>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
