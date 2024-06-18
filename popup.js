function hideCategoriePopup () {
    let popup = document.getElementById("popup");
    if(popup.classList.contains("show"))
        popup.classList.remove("show");
    popup.classList.toggle("hide");

    setTimeout(() => {
        popup.style.display="none";
        returnToCategories();
    }, 500);
}

function returnToCategories () {
    document.getElementById("titleText").innerHTML="Categories";
    document.getElementById("subCategorie").style.display ="none" ;
    document.getElementById("categories").style.display="flex";
    document.getElementById("returnCat").style.visibility="hidden";
}

function openCategories() {
    let popup = document.getElementById("popup");
    if(popup.classList.contains("hide"))
        popup.classList.remove("hide");
    popup.style.display = "flex";
    popup.classList.add("show")
}

function openSubcategories(title,id,list) {
    document.getElementById("categories").style.display="none";
    document.getElementById("titleText").innerHTML=title;
    document.getElementById("subCategorie").innerHTML="";
    document.getElementById("returnCat").style.visibility="visible";
    for(let i=0; i<list.children.length;i++) {
        let item = document.createElement("li");
        let icon = document.createElement("img");
        icon.src="./categorieIcons/"+id+".png";
        item.appendChild(icon);
        let text = document.createElement("span");
        text.innerHTML=list.children[i].innerText;
        item.appendChild(text);
        item.addEventListener("click", selectCategorie);
        document.getElementById("subCategorie").appendChild(item);
    }

    document.getElementById("subCategorie").style.display ="block" ;
}

function selectCategorie() {
    let categorie = [];
    categorie.push(document.getElementById("titleText").innerHTML);
    categorie.push(this.children[1].innerHTML.split('(')[0].trim());
    document.getElementById("categorieInput").value=categorie.join(">");
    document.getElementById("popup").style.display='none';
    returnToCategories()
}