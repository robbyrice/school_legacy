<?php
	if($this->current_user->has_role('Library'))
	{
		$this->load->view('bib/admin_view');
	}
	$this->load->view('bib/search_view');
?>
