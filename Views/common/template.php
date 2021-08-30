<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pageDescription; ?>">
    <title><?= $pageTitle; ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <?php require_once(PATH_VIEW . "/common/menu.php"); ?>

	<?php
		if(!empty($_SESSION['alert'])) :
			foreach($_SESSION['alert'] as $alert) :
	?>
				<div class="alert <?= $alert['type'] ?> m-0" role="alert">
					<div class="container">
						<?= $alert['text'] ?>
					</div>
				</div>
	<?php 
			endforeach;
		unset($_SESSION['alert']);
		endif; 
	?>


	<div class="container">
    	<?= $pageContent; ?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>