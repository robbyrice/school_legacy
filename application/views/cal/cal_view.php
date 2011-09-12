			<div id="schedule">

				<div class="cal_nav">
<?php echo cal_nav('cal/afficher/'.$type.'/', $month_info->month, $month_info->name, $month_info->year, 5); ?>
				</div>

				<div id="cal_show" data="<?php echo $type; ?>">
<?php echo $this->calendrier->generate($month_info, $cell_data, 5); ?>
				</div>

				<div class="cal_nav">
<?php echo cal_nav('cal/afficher/'.$type.'/', $month_info->month, $month_info->name, $month_info->year, 5); ?>
				</div>

			</div>
