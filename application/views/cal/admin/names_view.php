			<div id="name-admin">
				<h1>Gérer les noms</h1>
				<?php echo form_open('cal/admin/noms', array('accept-charset' => 'utf-8'))."\n"; ?>
					<p>
						<?php echo $message."\n"; ?>
					</p>
					<div>
						<?php echo form_error('old_id')."\n"; ?>
						<label for="old_id">Nom original:</label>
						<select autofocus id="old_id" name="old_id" tabindex="1">
							<option></option>
<?php echo dropdown_options($data, 8, $old_id); ?>
						</select>
					</div>
					<div>
						<?php echo form_error('new-name')."\n"; ?>
						<label for="new-name">Nouveau Nom:</label>
						<input id="new-name" name="new-name" tabindex="10" type="text" value="<?php echo $new_name; ?>" />
					</div>
					<div>
						<?php echo form_error('type')."\n"; ?>
						<label for="type">Type:</label>
						<select id="type" name="type" tabindex="20">
							<option></option>
<?php echo dropdown_options(array('b'=>'Chapelle', 'c'=>'Cours', 's'=>'Semaine', 'v'=>'Autres'), 8, $type); ?>
						</select>
					</div>
					<div class="choice">
						<?php echo form_error('mod')."\n"; ?>
<?php echo rad_check('radio', array('add'=>'Ajouter', 'mod'=>'Modifier', 'del'=>'Supprimer'), 'mod', 30, 7, $mod); ?>
					</div>
					<p class="submit">
						<input name="submit_name" tabindex="40" type="submit" value="Envoyer" />
					</p>
				<?php echo form_close()."\n"; ?>
			</div>
<?php
# Fin du fichier names_view.php
# Emplacement: /application/views/cal/admin/names_view.php