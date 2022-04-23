<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<div aria-describedby="#s1-title" id="app">

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

    <form action="" method="post" onsubmit="submit(event)">

        <section class="panel current" id="step-1">
            <h2 id="s1-title">Importer un nouveau webtoon</h2>
            <input type="text" name="title" id="title" aria-label="Titre" placeholder="Titre" required class="large">
            <textarea name="desc" id="desc" cols="30" rows="10" aria-label="Description"
                      placeholder="Description" required class="large"></textarea>
            <label for="cover" class="file">
                Importer une cover
                <input type="file" name="cover" id="cover" required accept="image/jpeg,image/png">
            </label>
            <button type="button" class="large" onclick="next()">Suivant</button>
        </section>

        <section class="panel" id="step-2">
            <div class="cols-2">
                <div class="col">
                    <h2>Importer un nouveau chapitre</h2>
                    <input type="text" name="chapter-x-title" id="chapter-title" aria-label="Titre du chapitre" required
                           placeholder="Titre">
                    <input type="number" name="chapter-x-number" id="chapter-number" aria-label="Numéro du chapitre"
                           required placeholder="Numéro" min="1" value="1">
                    <div class="form-group">
                        <label for="chapter-img" class="file">
                            Importer une cover
                            <input type="file" name="chapter-x-img" id="chapter-img" accept="image/jpeg,image/png" required>
                        </label>
                        <label for="chapter-img" class="file">
                            Importer une cover
                            <input type="file" name="chapter-x-parts" id="chapter-parts" multiple accept="image/jpeg,image/png" required>
                        </label>
                    </div>
                    <input type="submit" value="Ajouter le chapitre">
                </div>
                <div class="col">
                    <h3>Liste des chapitres importés</h3>
                    <ul class="list">
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            Chapitre x
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="icon">
                                    <path d="M27 6H21V4.5C21 3.83696 20.7366 3.20107 20.2678 2.73223C19.7989 2.26339 19.163 2 18.5 2H13.5C12.837 2 12.2011 2.26339 11.7322 2.73223C11.2634 3.20107 11 3.83696 11 4.5V6H5C4.73478 6 4.48043 6.10536 4.29289 6.29289C4.10536 6.48043 4 6.73478 4 7C4 7.26522 4.10536 7.51957 4.29289 7.70711C4.48043 7.89464 4.73478 8 5 8H6.0625L7.25 27.0575C7.33875 28.7356 8.625 30 10.25 30H21.75C23.3831 30 24.6437 28.7638 24.75 27.0625L25.9375 8H27C27.2652 8 27.5196 7.89464 27.7071 7.70711C27.8946 7.51957 28 7.26522 28 7C28 6.73478 27.8946 6.48043 27.7071 6.29289C27.5196 6.10536 27.2652 6 27 6ZM12.0356 26H12C11.7408 26.0002 11.4917 25.8997 11.3052 25.7198C11.1187 25.5399 11.0092 25.2946 11 25.0356L10.5 11.0356C10.4906 10.7704 10.5868 10.5123 10.7677 10.3181C10.9486 10.1239 11.1992 10.0094 11.4644 10C11.7296 9.99055 11.9877 10.0868 12.1819 10.2677C12.3761 10.4486 12.4906 10.6992 12.5 10.9644L13 24.9644C13.0048 25.0957 12.9836 25.2267 12.9377 25.3499C12.8918 25.473 12.8221 25.5859 12.7325 25.6821C12.6429 25.7783 12.5353 25.8559 12.4157 25.9104C12.2961 25.965 12.167 25.9954 12.0356 26ZM17 25C17 25.2652 16.8946 25.5196 16.7071 25.7071C16.5196 25.8946 16.2652 26 16 26C15.7348 26 15.4804 25.8946 15.2929 25.7071C15.1054 25.5196 15 25.2652 15 25V11C15 10.7348 15.1054 10.4804 15.2929 10.2929C15.4804 10.1054 15.7348 10 16 10C16.2652 10 16.5196 10.1054 16.7071 10.2929C16.8946 10.4804 17 10.7348 17 11V25ZM19 6H13V4.5C12.9992 4.43413 13.0117 4.36877 13.0365 4.30777C13.0614 4.24677 13.0982 4.19135 13.1448 4.14477C13.1913 4.09819 13.2468 4.06139 13.3078 4.03652C13.3688 4.01166 13.4341 3.99925 13.5 4H18.5C18.5659 3.99925 18.6312 4.01166 18.6922 4.03652C18.7532 4.06139 18.8087 4.09819 18.8552 4.14477C18.9018 4.19135 18.9386 4.24677 18.9635 4.30777C18.9883 4.36877 19.0008 4.43413 19 4.5V6ZM21 25.0356C20.9908 25.2946 20.8813 25.5399 20.6948 25.7198C20.5083 25.8997 20.2592 26.0002 20 26H19.9638C19.8325 25.9953 19.7034 25.9648 19.5839 25.9102C19.4644 25.8557 19.3568 25.7781 19.2673 25.6819C19.1778 25.5857 19.1081 25.4728 19.0623 25.3497C19.0164 25.2266 18.9952 25.0957 19 24.9644L19.5 10.9644C19.5047 10.8331 19.5352 10.7039 19.5898 10.5844C19.6443 10.4649 19.7219 10.3573 19.8181 10.2677C19.9143 10.1782 20.0271 10.1084 20.1502 10.0625C20.2733 10.0166 20.4043 9.99532 20.5356 10C20.6669 10.0047 20.7961 10.0352 20.9156 10.0898C21.0351 10.1443 21.1427 10.2219 21.2323 10.3181C21.3218 10.4143 21.3916 10.5271 21.4375 10.6502C21.4834 10.7733 21.5047 10.9043 21.5 11.0356L21 25.0356Z" class="fill"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <input type="submit" value="Sauvegarder">
        </section>
    </form>
</div>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
