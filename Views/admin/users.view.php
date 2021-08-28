<h1 class="text-center mt-3">admin-users</h1>

<table class="table text-center">
	<thead>
		<tr>
			<th scope="col">N°</th>
			<th scope="col">Nom</th>
			<th scope="col">Email</th>
			<th scope="col">Administrateur</th>
			<th scope="col">Email validé</th>
			<th scope="col" colspan="2">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user): ?>
			<?php if((int)$userToUpdateId === (int)$user->getId()) : ?>
				<tr>
					<form action="/admin/utilisateurs/update" method="POST">
						<td scope="row" class="align-middle">
							<?= $user->getId() ?>
						</td>
						<td>
							<div class="form-group">
								<input type="text" class="form-control text-center" name="username" value="<?= htmlentities($user->getUsername()) ?>">
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="email" class="form-control text-center" name="email" value="<?= htmlentities($user->getEmail()) ?>">
							</div>
						</td>
						<td>
							<div class="form-group form-switch">
								<input class="form-check-input" type="checkbox" name="admin" <?= ($user->getAdmin())?"checked":""; ?>>
							</div>
						</td>
						<td>
							<div class="form-group form-switch">
								<input class="form-check-input" type="checkbox" name="active" <?= ($user->getActive())?"checked":""; ?>>
							</div>
						</td>
						<td>
							<input type="hidden" name="id" value="<?= $user->getId() ?>">
							<button class="btn btn-success" type="submit">Valider</button>
						</td>
					</form>
					<td>
						<form action="/admin/utilisateurs" method="GET" style="display:inline">
							<button class="btn btn-dark" type="submit">Annuler</button>
						</form>
					</td>
					
				</tr>
			<?php else : ?>
			<tr id="userId<?= $user->getId() ?>">
				<td scope="row" class="align-middle">
					<?= $user->getId() ?>
				</td>
				<td class="align-middle">
					<?= htmlentities($user->getUsername()) ?>
				</td>
				<td class="align-middle">
					<?= htmlentities($user->getEmail()) ?>
				</td>
				<td class="align-middle">					
					<?php if($user->getAdmin()) : ?>
						<div class="form-group form-switch">
							<input class="form-check-input" type="checkbox" checked disabled>
						</div>
					<?php else : ?>
						<div class="form-group form-switch">
							<input class="form-check-input" type="checkbox" disabled>
						</div>
					<?php endif ?>
				</td>
				<td class="align-middle">					
					<?php if($user->getActive()) : ?>
						<div class="form-group form-switch">
							<input class="form-check-input" type="checkbox" checked disabled>
						</div>
					<?php else : ?>
						<div class="form-group form-switch">
							<input class="form-check-input" type="checkbox" disabled>
						</div>
					<?php endif ?>
				</td>
				<td class="align-middle">
					<form action="/admin/utilisateurs/<?= (int)$user->getId() ?>" method="POST" style="display:inline">
						<button class="btn btn-warning" type="submit">Modifier</button>
					</form>
				</td>
				<td class="align-middle">
					<form action="/admin/utilisateurs/delete" method="POST" onSubmit="return confirm('Voulez-vous vraiment supprimer l\'utilisateur ?');" style="display:inline">
						<input type="hidden" name="id" value="<?= $user->getId() ?>">
            			<button class="btn btn-danger" type="submit">Supprimer</button>
					</form>
				</td>
			</tr>
			<?php endif ?>
		<?php endforeach ?>
	</tbody>
</table>