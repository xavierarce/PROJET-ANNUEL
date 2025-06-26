import { myFetch } from './fetch.js';

// Avec les modules on doit attacher la fonction accueil à la fenêtre du DOM
window.accueil = accueil;
window.closeModal = closeModal;

function closeModal() {
	document.getElementById('modalFormContainer').innerHTML = '';
    document.getElementById('myModal').style.display = "none";
}

export function accueil() {
	manageLoginArea();
}

function manageLoginArea() {
	// On va appeler le serveur pour consulter l'état de la session
	// Et afficher un module de login/logout en conséquence
	myFetch(null, afficheLoginZone, 'api.php?route=Session', 'GET');
}

const afficheLoginZone = function(sessionInfo) {
	console.log(sessionInfo);
	const loginArea = document.getElementById("loginArea");
	loginArea.innerHTML = ""; // Conchita martinez fée du logis
	if (sessionInfo.isLogged) {
		console.log("Faire la partie pour se logout");
		let callback = function(event) { doLogout(); }; // Le callback sur le submit
        let aHrefLogin = document.createElement('a');
        aHrefLogin.textContent = "Se déconnecter";
        aHrefLogin.addEventListener('click', function(event) {
            event.preventDefault();
            callback(event);
        } );
        loginArea.appendChild(aHrefLogin);
	} else {
		let callback = function(event) { doLogin(); }; // Le callback sur le submit
		let aHrefLogin = document.createElement('a');
		aHrefLogin.textContent = "S'identifier";
		aHrefLogin.addEventListener('click', function(event) {
			event.preventDefault();
			callback(event);
		} );
		loginArea.appendChild(aHrefLogin);
	}
}

function doLogout() {
	const dataCallback = function(data) {
		accueil();
	};
	myFetch(null, dataCallback, 'api.php?route=Logout', 'GET');
}

function doLogin() {
	const container = prepareModal(); // Conchita ? Ménach
	const form = document.createElement('form');
	form.id = 'loginForm';

	let input = document.createElement('input');
	input.type = 'email';
	input.name = 'login';
	input.placeholder = 'Votre Email';
	input.setAttribute("required", "");
	form.appendChild(input);

	input = document.createElement('input');
	input.type = 'password';
	input.name = 'password';
	input.placeholder = 'Votre Mot de passe';
	input.setAttribute("required", "");
	form.appendChild(input);

	input = document.createElement('input');
	input.type = 'hidden';
	input.name = 'route';
	input.value = 'Login';
	form.appendChild(input);

	const submitButton = document.createElement('button');
	submitButton.type = 'submit';
	submitButton.textContent = "Se connecter";
	form.appendChild(submitButton);
	form.addEventListener('submit', function(event) {
		event.preventDefault(); // désaction du comportement par défaut
		// Appel de la fetch API en POST
		const dataCallback = function(data) {
			closeModal();
			accueil();
		};
		const errorCallback = function(error) {
    		console.log(error.message);
			if ("Invalid Credential" == error.message) {
				alert("Votre login ou password est invalide");
			}
		}
		myFetch(new FormData(form), dataCallback, 'api.php', 'POST', errorCallback);
// solution 2 myFetch(new FormData(form), dataCallback, form.action, form.method);

	});
	container.appendChild(form);
}

function prepareModal() {
	document.getElementById('myModal').style.display = "block";
	const container = document.getElementById('modalFormContainer');
	container.innerHTML = '';
	return container;
}


