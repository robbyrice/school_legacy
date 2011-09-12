			<p class="message"><?php echo $note; ?></p>

			<div>
				<ul>
<?php foreach($livres as $key=>$livre): ?>
					<li>
						<span id="l_<?php echo $key; ?>"><strong><?php echo $livre['title']; ?></strong> (<?php echo $livre['exemplaire']; ?>)</span>
						<ul>
<?php foreach($livre['authors'] as $key=>$value): ?>
							<li id="a_<?php echo $key; ?>"><?php echo $value; ?></li>
<?php endforeach; ?>
						</ul>
					</li>
<?php endforeach; ?>
				</ul>
			</div>
<?php
/* End of file main_view.php */
/* Location: ./application/views/admin/bib/main_view.php */
