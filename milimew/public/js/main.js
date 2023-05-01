//let card = document.getElementsByClassName("card")
//console.log("aze")
/*
card.addEventListener('click', function(){
    console.log("event")
     //innerHTML = "Ajouter au panier !"
})
*/
let card = document.querySelectorAll('.price')
card.forEach(
    element => element.addEventListener("mouseover", function(){
        element.innerHTML = "Voir la page"
    })
);

   /*card.addEventListener("mouseover", function(){
        console.log("coucou louou")
    })*/