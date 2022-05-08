
<section class="panel current" id="step-1">
    <form enctype="multipart/form-data" action="@import-webtoon" method="post" ><!--onsubmit="submit(event)"-->
        <h2 id="s1-title">Importer un nouveau webtoon</h2>
        <input type="text" name="title" id="title" aria-label="Titre" placeholder="Titre" required class="large">
        <input type="text" name="auteur" id="auteur" aria-label="auteur" placeholder="auteur" required class="large">
        <textarea name="desc" id="desc" cols="30" rows="10" aria-label="Description"
                  placeholder="Description" required class="large"></textarea>
        <label for="cover" class="file">
            Importer une cover
            <input type="file" name="cover" id="cover" required accept="image/jpeg,image/png">
        </label>
        <input type="hidden" name="step" value="2">
        <input type="submit" class="large" value="Enregistrer" >
    </form>
</section>