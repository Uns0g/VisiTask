/* menuButton */
const sidebar = document.getElementById('sidebar');
const menuBtn = document.getElementById('menu-button');
const board = document.getElementById('board');

menuBtn.addEventListener('click', (ev) =>{
	sidebar.classList.toggle('sidebar--inactive');
	board.classList.toggle('board--moved')

	menuBtn.firstElementChild.classList.toggle('hidden');
	menuBtn.lastElementChild.classList.toggle('hidden');
});

/* tasks */
const addTaskBtn = document.getElementById('tools__add-task');
const xAxisEl = document.getElementById('cursor-position__x');
const yAxisEl = document.getElementById('cursor-position__y');

addTaskBtn.addEventListener('click', () =>{
	if(!addTaskBtn.firstElementChild.classList.contains('hidden')){
		addTaskBtn.firstElementChild.classList.add('hidden');
		addTaskBtn.lastElementChild.classList.remove('hidden');

		board.classList.add('board--place-next-task');

		board.addEventListener('click', addTask);
	} 
	else{
		addTaskBtn.firstElementChild.classList.remove('hidden');
		addTaskBtn.lastElementChild.classList.add('hidden');

		board.classList.remove('board--place-next-task');

		board.removeEventListener('click', addTask);
	}
});

function addTask(el){
	if(el.target.tagName != 'BUTTON' && el.target.tagName != 'I'){
		const task = document.createElement('form')
		task.action = 'php/insert_task.php';
		task.method = 'POST';

		task.className = 'task';
		task.innerHTML = 
`<div class="task__header">
	<div class="status">
		<button class="status__button"></button>
		<div class="status__options">
			<span class="status__option">Situação Da Tarefa</span>
			<span class="status__option" data-color="var(--lighterGray)">Nenhuma</span>
			<span class="status__option" data-color="#a3b8c8">Esboço</span>
			<span class="status__option" data-color="#4974a5">Em Progresso</span>
			<span class="status__option" data-color="#404040">Permanente</span>
			<span class="status__option" data-color="#ff3531">Atrasado</span>
			<span class="status__option" data-color="#33bb33">Concluído</span>
		</div>
		<input type="text" class="status__name hidden" readonly>
	</div>
	<input type="text" class="task__title" name="title" placeholder="Título Para A Tarefa">
	<div class="task__header-buttons">
		<button class="button-move" type="button"><i class="ri-drag-move-2-fill"></i></button>
		<button class="button-remove"><i class="ri-delete-bin-2-fill"></i></button>
	</div>
</div>	
<div class="task__body">
	<textarea class="task__content" name="content" spellcheck="true"></textarea>
</div>
<div class="task__footer">
	<input type="text" class="task__positions" style="width: 100px; background: transparent; border: none; color: var(--titles);" name="position" readonly>
	<button class="task__save-button"><i class="ri-save-3-fill"></i></button>
	<input type="text" class="task__project-id hidden" name="project_ID">
	<input type="text" class="task__date" placeholder="31/12/2030">
</div>`;

		if(board.classList.contains('board--moved')){	
			task.style = `top: ${el.layerY}px; left: ${el.x}px;`;
		}
		else{
			task.style = `top: ${el.layerY}px; left: ${el.x - 370}px;`;
		}

		board.appendChild(task);
		task.querySelector('.task__positions').value = task.style.left+','+task.style.top;

		let projectID = window.location.href; // getting the id
		projectID = projectID.substring(projectID.indexOf('=')+1);
		task.querySelector('.task__project-id').value = projectID;

		task.submit();
	}
}

/****** AFTER INSERTION ******/
const tasks = document.querySelectorAll('.task');

tasks.forEach((task) =>{
	const taskStatusBtn = task.querySelector('.status__button');
	const taskDateInput = task.querySelector('.task__date');
	const taskRemoveBtn = task.querySelector('.button-remove');
	const taskMoveBtn = task.querySelector('.button-move');

	taskDateInput.addEventListener('input', () =>{
		if(taskDateInput.value.length == 2 || taskDateInput.value.length == 5){
			taskDateInput.value += '-';
		}
	});

	taskStatusBtn.addEventListener('click', () =>{
		task.querySelector('.status__options').classList.remove('hidden');
	});

	const taskStatusOptions = task.querySelectorAll('.status__option');
	taskStatusOptions.forEach((statusOption) => {
		statusOption.addEventListener('click', () => {
			task.querySelector('.status__name').value = statusOption.textContent;
			console.log(task.querySelector('.status__name').value);

			statusOption.parentElement.classList.add('hidden');	

			taskStatusBtn.style.background = statusOption.dataset.colour;
		});
	});

	taskRemoveBtn.addEventListener('click', () =>{
		task.action = "php/delete_task.php";
		task.submit();
	});

	taskMoveBtn.addEventListener('click', () =>{
		const taskHeader = task.querySelector('.task__header');

		taskHeader.classList.add('task__header--move');

		taskHeader.addEventListener('mousemove', dragTaskEl);
		taskHeader.addEventListener('mouseup', dropTaskEl);
	});
});

	// getting the movementX and Y properties of event obj
const dragTaskEl = function({movementX, movementY}){
	let taskEl = event.target.offsetParent;

	let taskElLeft = parseInt(taskEl.offsetLeft);
	let taskElTop = parseInt(taskEl.offsetTop);

	taskEl.style = `top: ${taskElTop + movementY}px; left: ${taskElLeft + movementX}px;`;
	taskEl.querySelector('.task__position').value = taskEl.style.left+','+taskEl.style.top;
};

const dropTaskEl = function(ev){
	ev.target.classList.remove('task__header--move');

	ev.target.removeEventListener('mousemove', dragTaskEl);
	ev.target.removeEventListener('mouseup', dropTaskEl);
}
