			<div id="search_form">
				<p>Veuillez entrer un terme de recherche dans la boîte ci-dessus et les résultats apparaîtront sur la droite.</p>
				<form action="bib/rechercher" accept-charset="utf-8" method="post">
					
					<input tabindex="10" type="text" value="" />
					<input tabindex="20" type="submit" />
				</form>
			</div>
			<div id="search_results">
				<ol>
<?php foreach($data as $key=>$r): ?>
					<li>
						<span id="l_<?php echo $key; ?>"><strong class="editable"><?php echo $r['title']; ?></strong> (<?php echo $r['exemplaire']; ?>)</span>
						<ul>
<?php foreach($r['authors'] as $key=>$value): ?>
							<li class="editable" id="a_<?php echo $key; ?>"><?php echo $value; ?></li>
<?php endforeach; ?>
						</ul>
					</li>
<?php endforeach; ?>
				</ol>
			</div>
