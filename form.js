function caricamento() {
    let inputTitle = document.getElementById("titolo");
    inputTitle.onblur = function() {validateTitle(this)};
    let inputDuration = document.getElementById("durata");
    inputDuration.onblur = function() {validateDuration(this)};
    let inputDate = document.getElementById("dataRadio");
    inputDate.onblur = function() {validateDate(this)};
    let inputURL = document.getElementById("urlVideo");
    inputURL.onblur = function() {validateURL(this)};
}

function validateDate(inputDate) {
    removeChildInput(inputDate);
    if(inputDate.value.search(/^\d{2}\/d{2}/d{4}$/)!=0) {
        showError(inputDate,"Inserire la data nel formato corretto (DD/MM/AAAA)");
        inputDate.focus();
        inputDate.select();
        return false;
    }
    return true;
}

function validateDuration(inputDuration) {
    removeChildInput(inputDuration);
    if(inputDuration.value.search(/^\d{2}:\d{2}$/) != 0 || inputDuration.value > "10:00") {
        showError(inputDuration, "Inserire la durata nel formato corretto (mm:ss) o superiore a 10 minuti");
        inputDuration.focus();
        inputDuration.select();
        return false;
    }
    return true;
}

function validateURL(inputURL) {
    removeChildInput(inputURL);
    try {
        if(inputURL.value.length > 0) {
            new URL(inpurURL.value);
        }
        return true;
    } catch(err) {
        showError(inputURL, "URL non valido");
        inputURL.focus();
        inputURL.select();
        return false;
    }
}

function showError(tag, stringa) {
    const padre = tag.parentNode;
    const errore = document.createElement("strong");
    errore.className = "errorSuggestion";
    errore.appendChild(document.createTextNode(string));
    padre.appendChild(errore);
}

function removeChildInput(input) {
    padre = input.parentNode;
    if(padre.children.length == 2) {
        padre.removeChild(padre.children[1]);
    }
}

function validateExplicit(rYes, rNo) {
    removeChildInput(rNo);
    if(!(rYes.checked || rNo.checked)) {
        showError(rNo, "Selezionare una delle 2 opzioni");
        return false;
    }
    return true;
}

function validationForm() {
    let inputTitle = document.getElementById("titolo");
    let inputDuration = document.getElementById("durata");
    let inputDate = document.getElementById("dataRadio");
    let inputURL = document.getElementById("urlVideo");
    let rYes = document.getElementById("rYes");
    let rNo = document.getElementById("rNo");
    return validateTitle(inputTitle) && validateDuration(inputDuration) && validateDate(inputDate) && validateURL(inputURL) && validateExplicit(rYes, rNo);
}