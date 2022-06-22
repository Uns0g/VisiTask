/* user area */
const userBtn = document.getElementById('user-button');
const userOptionsCtn = document.getElementById('user-options');

userBtn.addEventListener('click', () =>{ userOptionsCtn.classList.toggle('hidden')});

/* Create A Project */
const addProjectBtn = document.getElementById('add-project-button');
const projectsCtn = document.querySelector('#projects ul');

addProjectBtn.addEventListener('click', createProjectEl);

function createProjectEl(){
	const projectEl = document.createElement('form');
	projectEl.setAttribute('method','POST');
	projectEl.action = 'php/insert_project.php';
	projectEl.className = 'project-item';

	projectEl.innerHTML = `<i class="ri-file-2-line project-item__icon"></i> <input class="project-item__name" type="text" name="projectName" placeholder="Dê um nome para o projeto"> <span class="project-item__buttons"><button class="project-item__edit-button" disabled><i class="ri-file-edit-fill"></i></button><button class="project-item__delete-button" disabled><i class="ri-close-fill"></i></button></span>`;
	
	/* getting the username */
	let userInput = document.createElement('input');
	userInput.className = 'hidden';
	userInput.name='user';
	userInput.value = document.querySelector('#user-button').textContent;

	projectsCtn.appendChild(projectEl);
	projectEl.appendChild(userInput);
	
	const projectNameInput = projectEl.querySelector('.project-item__name');
	projectNameInput.focus();
	projectNameInput.addEventListener('keydown', insertProject);
};

function insertProject(ev){
	if(ev.key == 'Enter'){
		ev.target.parentElement.submit();
	}
}

/* Editting and deleting A Project*/
const changeProjectName = function(ev){
	const nameInput = ev.target.offsetParent.querySelector('input');
	const editBtn = ev.target.offsetParent.querySelector('.project-item__edit-button');
	const deleteBtn = ev.target.offsetParent.querySelector('.project-item__delete-button');
	
	nameInput.removeAttribute('disabled');
	nameInput.focus();
	nameInput.addEventListener('keydown',insertProject);

	editBtn.setAttribute('disabled', 'true');
	deleteBtn.setAttribute('disabled','true');
}

const projectEditBtns = document.querySelectorAll('.project-item__edit-button');
projectEditBtns.forEach(editBtn => editBtn.addEventListener('click', changeProjectName));

const deleteProject = function(ev){
	ev.target.offsetParent.setAttribute('action', 'php/delete_project.php');
	ev.target.offsetParent.submit();
}

const projectDeleteBtns = document.querySelectorAll('.project-item__delete-button');
projectDeleteBtns.forEach(deleteBtn => deleteBtn.addEventListener('click', deleteProject));

/* Entering in a project */
function enterProject(ev){
	if(ev.target.tagName != 'INPUT'){
		let formEl = ev.target.parentElement;

		if(formEl.tagName == 'UL'){
			formEl = ev.target;	
		}

		if(formEl.tagName != 'SPAN' && formEl.tagName != 'BUTTON'){
			window.location.href = `user_panel.php?id=${formEl.dataset.id}`;
		}
	}
}

const projectElements = projectsCtn.children;
for(const projectEl of projectElements){ 
	projectEl.style.cursor = 'pointer';
	projectEl.addEventListener('click', enterProject)
}
