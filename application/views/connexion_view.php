			<div id="connect_div">
				<h1>Se connecter</h1>
				<?php echo form_open('connexion', array('accept-charset' => 'utf-8'))."\n"; ?>
					<?php echo validation_errors(); ?>
					<p>
						<?php echo form_label('Pseudo :', 'name')."\n"; ?>
						<?php echo form_input('pseudo', set_value('pseudo'), 'autofocus id="name" tabindex="1"')."\n" ?>
					</p>
					<p>
						<?php echo form_label('Mot de passe :', 'password')."\n"; ?>
						<?php echo form_password('password', '', 'id="password" tabindex="10"')."\n"; ?>
					</p>
					<input name="goto" type="hidden" value="<?php echo $goto; ?>">
					<?php echo form_submit('submit', 'Connexion', 'tabindex="20"')."\n" ?>
				<?php echo form_close()."\n"; ?>
			</div>
