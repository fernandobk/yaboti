var lista; // Global

async function obtener_lista_alumnos(){
		lista = await fetch('lista_alumnos.json');
		lista = await lista.json();
}

function seleccionar_lista_alumnos(){
		switch(asignatura.value){
				case 'II': cargar_lista_alumnos(lista.tercero); break;
				case 'PL': cargar_lista_alumnos(lista.cuarto); break;
				case 'POO': cargar_lista_alumnos(lista.quinto); break;
				case 'SBD': cargar_lista_alumnos(lista.quinto); break;
		}
}

function cargar_lista_alumnos(lista){
		nombre.value = null;
		lista_alumnos.innerHTML = null;
		
		let nom;
		for(let i = 0; i < lista.length; i++){
				nom = document.createElement('option');
				nom.innerText = lista[i];
				lista_alumnos.append(nom);
		}
		
}

function comprobar_nombre(){
		
		for(let i = 0; i < lista_alumnos.childElementCount; i++){
				if(lista_alumnos.children[i].innerText === nombre.value){ return true; }
		}
		
		alert('Revisar apellido y nombre');
		nombre.focus();
		return false;
}
