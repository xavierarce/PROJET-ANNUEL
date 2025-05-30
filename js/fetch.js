import { AuthenticationException } from './exceptions.js';

const defaultResponseCallback = function(response) {
    if (!response.ok) {
		console.log("Status Text : " + response.statusText + " || code : " + response.status);
		let statusText = response.statusText; // On attend que le texte soit complètement reçu
		let split = statusText.split(":");
		if (split.length == 2) {
			statusText = split[1].trim(); // Tableau numéroté à partir de zéro
		} else {
			statusText = ""; // Rien à extraire
		}
		// console.log("[" + statusText + "]"); // A supprimer quand on sera sûr
		switch (response.status) {
		case 499 : throw new AuthenticationException(statusText);
		}
		// L'ultime erreur de la dernière chance, j'aurai pu mettre ça dans le default... au choix
        throw new Error('Network response was not ok ' + response.statusText);
    }
    return response.json();
}

function cleanBody(body) {
	return body.slice(1, -1); // supprime la première et la dernière
}

const defaultDataCallback = function(data) {
    console.log("Data :\n", data);
}

const defaultErrorCallback = function(error) {
    console.error('Erreur:', error);
}

export function myFetch(formData, dataCallback, url, method, errorCallback = null, 
						responseCallback = null, contentType = 'application/x-www-form-urlencoded') {
    fetch(url, {
        method: method,
        headers: { 'Content-Type': contentType },
		// DELETE et GET n'ont pas de body, les paramètres passent dans l'URL
        body: method == 'GET' || method == 'DELETE' ? null : new URLSearchParams(formData).toString() 
    })
    .then(response => (responseCallback == null ? defaultResponseCallback(response) : responseCallback(response) ) )
    .then(data => (dataCallback == null ? defaultDataCallback(data) : dataCallback(data) ))
    .catch(error => (errorCallback == null ? defaultErrorCallback(error): errorCallback(error) ));
}
