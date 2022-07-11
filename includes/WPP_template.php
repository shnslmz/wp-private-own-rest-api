<?php
	get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post" class="hentry">
				<div class="entry-content">

					<?php 
					if(!isset($this->WPP_front) or !$this->WPP_front) 
						die('<h2>Data could not get.</h2>');
					else
						echo $this->WPP_front;
					?>

				</div>
				<br /><br />
			</article>
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
	get_footer();
?>