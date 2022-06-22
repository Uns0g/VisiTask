<?php 
	include("php/connection.php");
	session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Pedro Rossi">
		<link rel="stylesheet" type="text/css" href="styles/core.css">
		<link rel="stylesheet" type="text/css" href="styles/user_panel.css">
		<link rel="stylesheet" type="text/css" href="styles/tasks.css">
		<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
		<title>Nome</title>
	</head>
	<body>
		<header>
			<button id="help-button"><i class="ri-question-fill"></i></button>
			<h1>VisiTask</h1>
			<button id="user-button"><?php echo $_SESSION["user"];?></button>
			<ul id="user-options" class="hidden">
				<li class="user-option" onClick="window.location.href = 'php/logout.php';">Sair da conta</li>
				<li class="user-option" onClick="window.location.href = 'php/delete_user.php';">Excluir conta</li>
			</ul>
		</header>
		<main>
			<aside id="sidebar" class="">
				<section id="projects">
					<h3>Projetos</h3>
					<div id="project-toolbar">
						<button class="project-toolbar__button" id="add-project-button"><i class="ri-add-line"></i></button>
						<!--<button class="project-toolbar__button" id="sort-projects-button"><span>Ordem <i class="ri-arrow-up-fill"></i><i class="ri-arrow-down-fill hidden"></i></span></button>-->
					</div>
					<ul>
						<?php
							$request = "SELECT * FROM users WHERE login = '{$_SESSION["user"]}';";
						
							$response = mysqli_query($conn,$request);
							$row = mysqli_fetch_row($response);

							$request = "SELECT * FROM projects WHERE user_ID = $row[0];";
								
							$response = mysqli_query($conn, $request); 
							while($register = mysqli_fetch_assoc($response)){?>
								<form action="php/update_project.php" method="POST" class="project-item" data-id="<?php echo $register["projectID"];?>">
										<i class="ri-file-2-line project-item__icon"></i>
										<input type="text" class="project-item__name" name="projectName" placeholder="Dê um nome para o projeto" value="<?php echo $register["title"];?>" disabled>
										<span class="project-item__buttons">
											<button class="project-item__edit-button" type="button"><i class="ri-file-edit-fill"></i></button>
											<button class="project-item__delete-button" type="button"><i class="ri-close-fill"></i></button>
										</span>
										<input type="number" name="projectID" class="hidden" value="<?php echo $register["projectID"]?>"> 
								</form>
						<?php
								
							}
						?>
					</ul>
				</section>
			</aside>
			<section id="board">
				<button id="menu-button" type="button">
					<i class="ri-menu-unfold-line menu-button__unfold hidden"></i>
					<i class="ri-menu-fold-line menu-button__fold"></i>
				</button>
				<?php 
					$pID = $_GET["id"];

					if(isset($pID)){
						$request = "SELECT * FROM tasks WHERE project_id = $pID";
						
						$response = mysqli_query($conn,$request);
						if($response->num_rows < 1){?>
							<p class="board__message">Crie uma tarefa!</p>
							<div id="tools">
								<button id="tools__add-task" type="button"><i class="ri-add-circle-fill"></i><i class="ri-pushpin-fill hidden"></i></button>
							</div>
				<?php		} 
						else{
							while($register = mysqli_fetch_assoc($response)){
								$select = "SELECT * FROM status WHERE statusID={$register["status_ID"]};";
								$row = mysqli_query($conn,$select)->fetch_row();?>

								<form action="php/update_task.php" class="task" style="left: <?php echo $register["xPos"];?>; top: <?php echo $register["yPos"];?>;" method="POST">
									<div class="task__header">
										<div class="status">
										<button type="button" class="status__button" style="background: <?php echo $row[2];?>;"></button>
											<div class="status__options hidden">
												<span class="status__option">Situação Da Tarefa</span>
												<span class="status__option" data-colour="var(--lighterGray)">Nenhuma</span>
												<span class="status__option" data-colour="#a3b8c8">Esboço</span>
												<span class="status__option" data-colour="#daa520">Em Progresso</span>
												<span class="status__option" data-colour="#404040">Permanente</span>
												<span class="status__option" data-colour="#ff3531">Atrasado</span>
												<span class="status__option" data-colour="#33bb33">Concluído</span>
											</div>
											<input type="text" class="status__name hidden" name="status" value="<?php echo $row[1];?>" readonly>
										</div>
										<input type="text" class="task__title" name="title" placeholder="Título Para A Tarefa" value="<?php echo $register["title"];?>">
										<div class="task__header-buttons">
											<button class="button-move" type="button"><i class="ri-drag-move-2-fill"></i></button>
											<button class="button-remove" type="button" data-id="<?php echo $register["taskID"]?>"><i class="ri-delete-bin-2-fill"></i></button>
										</div>
									</div>	
									<div class="task__body">
										<textarea class="task__content" name="content" spellcheck="false"><?php echo $register["content"];?></textarea>
									</div>
									<div class="task__footer">
										<input type="text" class="task__position" name="position" value="<?php echo $register["xPos"].','.$register["yPos"]?>" readonly>
										<button class="task__save-button"><i class="ri-save-3-fill"></i></button>
										<input type="text" class="task__date" maxlength="10" name="deadline" placeholder="31-12-2030" value="<?php echo ($register["deadline"] == '' || $register["deadline"] == '1970-01-01') ? '' : strval(date("d-m-Y",strtotime($register["deadline"])));?>">
										<input type="text" class="task__id hidden" name="taskID" value="<?php echo $register["taskID"];?>">
									</div>
								</form>
								<h5 id="save-message">CLIQUE NO BOTÃO DE SALVAR DA TAREFA PARA SALVAR AS ALTERAÇÕES</h5>
					<?php		}?>
					
							<div id="tools">
								<button id="tools__add-task" type="button"><i class="ri-add-circle-fill"></i><i class="ri-pushpin-fill hidden"></i></button>
							</div>
					<?php			
						}
					}
					else{?>
						<p class="board__message">Selecione um projeto</p>
				<?php
					}
				?>
			</section>
		</main>
	</body>
	<script src="scripts/project.js"></script>
	<script src="scripts/board.js"></script>
</html>
