<?php
function get_profile() {
    Page::write('
<div class="columns">
	<div class="column one-fourth">
		<p>Hours: ' . Util::getUser($_SESSION['bvid'])['hours'] . '</p>
	</div>
</div>
');
}
?>