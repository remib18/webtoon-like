<?php

use WebtoonLike\Site\pageManager\ImportManager;

?>


<section class="panel current" id="step-2">
    <form action="@import-chapter" enctype="multipart/form-data" method="post">
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
                        <input type="file" name="chapter-x-img" id="chapter-img" accept="image/jpeg,image/png">
                        <!--Pas obliger de mettre required par defaut je pense que c'est mieux de mettre la covers du webtoon-->
                    </label>
                    <label for="chapter-img" class="file">
                        Importer images du chapitre
                        <input type="file" name="chapter-x-parts[]" id="chapter-parts" multiple
                               accept="image/jpeg,image/png" required>
                    </label>
                    <label>Language du chapitre:
                        <select name="language" id="langue">
                            <option value="">--Choisissez un langue--</option>
                            <?= ImportManager::languageSelect() ?>
                            <option value="autre">autre</option>
                        </select>
                    </label>
                </div>
                <input type="submit" value="Ajouter le chapitre">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            </div>
            <div class="col">
                <h3>Liste des chapitres importés</h3>
                <ul class="list">
                    <?= importManager::chaptersListForWebtoon() ?>
                </ul>
            </div>
        </div>
    </form>
</section>