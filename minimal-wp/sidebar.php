<?php
	if (is_active_sidebar(1) ) {
		echo '<section class="sidebar widget-area">';
			dynamic_sidebar('sidebar');
		echo '</section>';
	}
?>