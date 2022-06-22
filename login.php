<?php session_start();?>
<html lang="pt-BR">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="styles/core.css">
		<link rel="stylesheet" type="text/css" href="styles/forms.css">
		<title>Entre</title>
	</head>
	<body>
		<form id="entry-form" action="php/check_user.php" method="POST">
			<h1 id="entry-form__title">Entre Com Seu Usuário</h1>
			<?php
				if(isset($_SESSION["unexisting_user"])){?>
					<input type="text" name="user-input" id="entry-form__username--error" placeholder="Nome de usuário inexistente!" required>
			<?php	}
				else{?> 
					<input type="text" name="user-input" id="entry-form__username" placeholder="Seu nome de usuário" required>
			<?php	}
				unset($_SESSION["unexisting_user"]);

				if(isset($_SESSION["wrong_password"])){?>
					<input type="password" id="entry-form__password--wrong" name="password-input" placeholder="Senha Errada!">
			<?php	}
				else{?> 
					<input type="password" id="entry-form__password" name="password-input" placeholder="Sua Senha" >
			<?php	}
				unset($_SESSION["wrong_password"]);?>
			<input type="submit" value="Entre" id="entry-form__submit">
		</form>
		<p>Não tem uma conta? <a href="index.php">Cadastre-se!</a></p>
	</body>
</html>
