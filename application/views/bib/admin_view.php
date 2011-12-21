			<p class="message"><?php echo $message; ?></p>
			<div id="add_book">
				<div id="instructions">
					<p>
						La capitalisation pour les titres et les noms d'auteurs est prise
						en charge largement par l'application.  Ceci veut dire que vous
						pouvez entrer un titre; ou même le nom d'un auteur, tout en minuscule
						et la capitalisation se fera automatiquement.  Toutefois, il y a
						plusieurs points à noter.
					</p>
					<ol>
						<li>
							Si le prénom, surnom ou nom d'un auteur ne comporte qu'une lettre
							celle-ci sera suivi d'un point
						</li>
						<li>
							Pour avoir un mot tout en majuscule faites-le précédé d'un '\'
							(sans les apostrophes)
						</li>
						<li>
							Pour avoir un mot (autre que le premier mot d'une phrase) dont la
							première lettre est majuscule faites-le précédé d'un '_' (sans
							les apostrophes)
						</li>
						<li>
							Les mots suivants commencent toujours par un majuscule
							<ul>
								<li>Bible</li>
								<li>Les noms de Dieu</li>
								<li>La lettre "i" toute seule</li>
							</ul>
						</li>
					</ol>
				</div>
<?php echo validation_errors(); ?>
				<form action="" accept-charset="utf-8" method="post">
					<div>
						<p>
							<label>Titre : </label><input autofocus id="titre" name="titre" />
						</p>
						<p>
							<label>Sous-titre : </label><input id="sous_titre" name="sous_titre" />
						</p>
						<input name="livre_id" type="hidden" />
					</div>
					<div>
						<p>
							<label>Prénom : </label><input class="prenom" name="prenom[]" />
						</p>
						<p>
							<label>Surnom : </label><input class="surnom" name="surnom[]" />
						</p>
						<p>
							<label>Nom : </label><input class="nom" name="nom[]" />
						</p>
						<img id="add" src="img/001_01.png" />
					</div>
					<input name="action" type="submit" value="Ajouter" />
				</form>
			</div>
