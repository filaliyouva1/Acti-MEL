window.addEventListener("load",dessinerCarte);


// fonction de mise en place de la carte.
// Suppose qu'il existe dans le document
// un élément possédant id="cartecampus"
function dessinerCarte(){
    // cette carte sera dessinée dans l'élément HTML "cartecampus"
    var map = L.map('cartecampus').setView([50.60976, 3.13909], 16);

    // ajout du fond de carte OpenStreetMap
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    // Création des marqueurs et des popups :
    placerMarqueurs(map);
    // Mise en place d'une gestionnaire d'évènement : activerBouton se déclenchera à chaque ouverture de popup
    var marker = L.marker([51.5, -0.09]).addTo(map).bindPopup('fuuck');
    map.on("popupopen",activerBouton);

}


// cette fonction parcourt la table et crée un marqueur pour chaque ligne, avec un popup associé
function placerMarqueurs(map) {
   var l = document.querySelectorAll("table#entreprises>tbody>tr"); //liste de toutes les lignes
   var pointList= [];
   for (var i=0; i<l.length; i++){ // pour chaque ligne, insertion d'un marqueur sur la carte
        //nom de la commune :
        var nom = l[i].querySelector("td.nomen_long").textContent;
        var categorie=l[i].querySelector("td.categorie").textContent;
        var adresse=l[i].querySelector("td.l6_normalisee").textContent;
        var libtefet=l[i].querySelector("td.libtefet").textContent;
        var siret = l[i].dataset.siret;
        var texte = nom +"\n" + adresse + "\n" + libtefet + "\n" + categorie +"\n"+ " <button value=\""+siret+"\">Choisir</button>";
        // insertion du marqueur selon les coordonnées trouvées dans les attributs data-lat et data-lon :
        var point = [l[i].dataset.lat, l[i].dataset.lon];
        L.marker(point).addTo(map).bindPopup(texte);
        pointList.push(point);
   }
   // ajustement de la zone d'affichage de la carte aux points marqués
    map.fitBounds(pointList);
}
// gestionnaire d'évènement (déclenché lors de l'ouverture d'un popup)
// cette fonction va rendre actif le bouton inclus dans le popup en lui associant un gestionnaire d'évènement
function activerBouton(ev) {
    var noeudPopup = ev.popup._contentNode; // le noeud DOM qui contient le texte du popup
    var bouton = noeudPopup.querySelector("button"); // le noeud DOM du bouton inclu dans le popup
    bouton.addEventListener("click",modifieListe); // en cas de click, on déclenche la fonction boutonActive
}
