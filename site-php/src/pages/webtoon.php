<?php
namespace WebtoonLike\Site\page;
require_once dirname(__DIR__,2) . '/vendor/autoload.php';
use WebtoonLike\Site\pageManager\WebtoonManager;
?>

<div id="app">
    <aside>
        <div class="header">
            <h2 class="title"><?= WebtoonManager::getName() ?></h2>
            <a href="" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 16" class="icon">
                    <path d="M9.65885 7.7513L12.6276 4.78255C12.7685 4.6419 12.8477 4.45104 12.8479 4.25196C12.8481 4.05288 12.7692 3.86188 12.6285 3.72099C12.4879 3.58009 12.297 3.50084 12.0979 3.50066C11.8989 3.50049 11.7079 3.5794 11.567 3.72005L8.59822 6.6888L5.62947 3.72005C5.48858 3.57915 5.29748 3.5 5.09822 3.5C4.89897 3.5 4.70787 3.57915 4.56697 3.72005C4.42608 3.86095 4.34692 4.05204 4.34692 4.2513C4.34692 4.45056 4.42608 4.64165 4.56697 4.78255L7.53572 7.7513L4.56697 10.72C4.42608 10.8609 4.34692 11.052 4.34692 11.2513C4.34692 11.4506 4.42608 11.6417 4.56697 11.7825C4.70787 11.9234 4.89897 12.0026 5.09822 12.0026C5.29748 12.0026 5.48858 11.9234 5.62947 11.7825L8.59822 8.8138L11.567 11.7825C11.7079 11.9234 11.899 12.0026 12.0982 12.0026C12.2975 12.0026 12.4886 11.9234 12.6295 11.7825C12.7704 11.6417 12.8495 11.4506 12.8495 11.2513C12.8495 11.052 12.7704 10.8609 12.6295 10.72L9.65885 7.7513Z" class="fill"/>
                </svg>
            </a>
        </div>
        <fieldset>
            <label for="chapter">Sélectionnez le chapitre</label>
            <span class="select">
                <select name="chapter" id="chapter">
                    <?php foreach(WebtoonManager::getNbChap() as $Chap){?>
                    <option value="<?=(int)$Chap?>" selected>Chapitre <?=$Chap?></option>
                    <?php } ?>
                </select>
            </span>
        </fieldset>
        <hr>
        <h3>Description</h3>
        <pre><?=WebtoonManager::getDescription()?></pre>
        <!--<h3>Genres</h3>
        <span class="genre">AAA</span>
        <span>•</span>
        <span class="genre">BBB</span>-->
        <a href="./import-chapter.html" class="button outlined">Importer un nouveau chapitre</a>
    </aside>
    <section aria-describedby="content">
        <!-- Todo: Javascript to load the images of the webtoon -->
    </section>
</div>