<div align='center'>
  <h1>Projet Webtoon-Like</h1>
  <img width='60%' src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/76465f85-d3e9-4096-b69e-5bf50d71053d/d70k492-b4f05538-6ddd-4621-9c85-99a2422abbee.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwic3ViIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsImF1ZCI6WyJ1cm46c2VydmljZTpmaWxlLmRvd25sb2FkIl0sIm9iaiI6W1t7InBhdGgiOiIvZi83NjQ2NWY4NS1kM2U5LTQwOTYtYjY5ZS01YmY1MGQ3MTA1M2QvZDcwazQ5Mi1iNGYwNTUzOC02ZGRkLTQ2MjEtOWM4NS05OWEyNDIyYWJiZWUucG5nIn1dXX0.nk__ENkUpuqs7eOF_lSgvthXgT4G1ZAjoy-CsOxZmRA"></img>
</div>
<br>
Aujourd'hui, le cycle de publication des webtoons (manga en ligne) dans les pays étrangers est particlièrement long car la truduction doit être faite et insérée manuellement. C'est pourquoi nous proposons un service qui automatise en partie cette tâche ardue en proposant en plus un système communautaire pour l'amélioration des traductions.

&nbsp;<br>
*Ceci est un projet universitaire realisé dans le cadre du second semestre de L1 informatique et ne servira exclusivement qu'à des fins d'apprentissage. Nous vous rappelons qu'il est illégal de diffuser du contenu dont vous ne disposez pas des droits. Si fork il y a, utilisez-le à bon escient.*


---
<a name="technologies-et-planification"></a>
## Technologies utilisés (planification)
### Backend
- PHP 
- SQL (MySql)
- API de traduction utilisée : Azure Cognitive Student : Translation

### Frontend
- HTML / CSS
- Pure Javascript (V1)
- ReactJS pour un comportement réactif (V2)

Pour l'**installation**, consultez [setup.md](SETUP.md)<br>
Prototype du design : [Figma](https://www.figma.com/file/9Wa0rJtEdahhpfkFgCEbSF/UI?node-id=0%3A1)

## Avancement du projet
V1 est l'objectif de l'état du projet à la fin de semestre.
### V0
- [ ] Réaliser un lecteur de webtoon
- [X] Traduire le webtoon à partir de données préalablement extraites (via API)
- [ ] Masquage basique des images
- [ ] Réécriture des traductions
### V1
- [ ] Système d'utilisateur (Connection par services externes)
- [ ] Propositions d'amélioration de la traduction par les utilisateurs
- [ ] Repport d'erreur de masquage des images
- [ ] Masquage ligne par ligne des images
### V2
- [ ] Ajout et traitement automatique d'un webtoon
- [ ] Système de catégories
- [ ] Savegarde du dernier chapitre lu / manga pour les utilisateurs connectés
- [ ] Ajout d'une option de connection interne
- [ ] Lecture infinie avec le prochain chapitre automatiquement chargé à la fin
- [ ] Options utilisateur
