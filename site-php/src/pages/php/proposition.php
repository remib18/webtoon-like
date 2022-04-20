<div id="app">
    <span class="logged-as">
        <span>Connecté en tant que :</span>
        <label for="profile" class="profile">
            <input type="checkbox" name="profile" id="profile">
            <img src="https://via.placeholder.com/50" alt="profile">
            <span class="name">John Doe</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 16 16">
                <path d="M12 5.5L14.5 8M14.5 8L12 10.5M14.5 8H5.96875M10 5.5V4.25C10 3.91848 9.8683 3.60054 9.63388 3.36612C9.39946 3.1317 9.08152 3 8.75 3H2.75C2.41848 3 2.10054 3.1317 1.86612 3.36612C1.6317 3.60054 1.5 3.91848 1.5 4.25V11.75C1.5 12.0815 1.6317 12.3995 1.86612 12.6339C2.10054 12.8683 2.41848 13 2.75 13H8.75C9.08152 13 9.39946 12.8683 9.63388 12.6339C9.8683 12.3995 10 12.0815 10 11.75V10.5V5.5Z" class="stroke" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </label>
    </span>
    <div class="grid-container">
        <p class="title-small-1">Texte original</p>
        <pre class="false-input small-1">
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt fuga harum perspiciatis quis sequi soluta totam. Ab ad at commodi id illum ipsum, iusto molestias, numquam odit reiciendis repellendus voluptates.
            </pre>
        <p class="title-small-2">Traduction actuelle</p>
        <pre class="false-input small-2">
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium cupiditate dicta doloremque eligendi exercitationem nemo nulla officia, quam repudiandae tempora, totam veritatis. Dolorem maxime neque temporibus tenetur voluptatum. Nihil, sapiente.
            </pre>
        <label class="title-large" for="proposition">Proposition</label>
        <textarea class="large-1" name="proposition" id="proposition" cols="100" rows="10">
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, commodi consequuntur cumque dicta, eos expedita ipsam magni molestias natus necessitatibus neque nobis pariatur provident quaerat, quo ratione rerum sunt suscipit.
            </textarea>
        <input type="submit" value="Valider" class="action large">
    </div>
</div>