<?php
function get_profile() {
    Page::write('
<br>
<p>Hours: ' . Util::getUser($_SESSION['bvid'])['hours'] . '</p>
    ');
}
?>