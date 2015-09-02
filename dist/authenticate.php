<?php
if (!isset($_SESSION['s_id'])) {
	header('HTTP/1.1 401 Unauthorized');
	exit();
}
?>