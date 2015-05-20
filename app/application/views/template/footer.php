	<footer class="footer">
      	<div class="container">
        	<p class="text-muted">© 2015 factury Inc. All Rights Reserved.</p>
      	</div>
    </footer>
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <?php
		foreach ($script as $key => $value) {
		 	echo '<script src="'.base_url().'assets/'.$value.'.js" type="text/javascript"></script>';
	 	}
	 ?>
    </body>
</html>