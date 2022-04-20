# Webtoon Like
Projet de second semestre de L1 informatique.

## Description
Aujourd'hui, le cycle de publication des webtoons (manga en ligne) dans les pays étrangers est particlièrement long car la truduction doit être faite et insérée manuellement. C'est pourquoi nous proposons un service qui automatise en partie cette tâche ardue en proposant en plus un système communautaire pour l'amélioration des traductions.

Prototype du design : [Figma](https://www.figma.com/file/9Wa0rJtEdahhpfkFgCEbSF/UI?node-id=0%3A1)

## Avancement du projet
V1 est l'objectif de l'état du projet à la fin de semestre.
### V0
- [ ] Réaliser un lecteur de webtoon
- [x] Traduire le webtoon à partir de données préalablement extraites (via API)
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

## Technologies utilisés (planification)
### Backend
- PHP (potentiellement laravel)
- SQL (sqlite pour tester rapidement)
- API de traduction utilisée : Azure Cognitive Student : Translation

### Frontend
- HTML / CSS
- Pure Javascript (V1)
- ReactJS pour un comportement réactif (V2)
