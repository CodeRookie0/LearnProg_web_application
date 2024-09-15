<?php
$current_page = basename($_SERVER['PHP_SELF']); 

$is_fixed_bottom = ( $current_page === 'logout.php' || $current_page === 'lesson-completion.php');

?>
<footer class="py-5 bg-dark <?php echo $is_fixed_bottom ? 'fixed-bottom' : ''; ?>">
	<div class="container px-5">
		<p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
	</div>
</footer>