<?php session_start();?>
<html lang="pt-BR">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="styles/core.css">
		<link rel="stylesheet" type="text/css" href="styles/forms.css">
		<title>Cadastrar Usuário</title>
	</head>
	<body>
		<form id="entry-form" action="php/insert_user.php" method="POST">
			<h1 id="entry-form__title">Cadastre-Se</h1>
			<?php
				if(isset($_SESSION["existing_user"])){?>
					<input type="text" name="user-input" id="entry-form__username--error" placeholder="Nome de usuário já em uso!" required>
			<?php	} 
				else{?>
					<input type="text" name="user-input" id="entry-form__username" placeholder="Nome de usuário" required>
			<?php	}
				unset($_SESSION["existing_user"]);?>
			<input type="password" name="password-input" id="entry-form__password" placeholder="Senha">
			<input type="submit" value="Cadastre-se" id="entry-form__submit">
		</form>
		<p>Já tem uma conta? <a href="login.php">Entre!</a></p>
	</body>
</html>
