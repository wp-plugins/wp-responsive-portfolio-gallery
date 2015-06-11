<?php 
	/**
	* Plugin Main Class
	*/
	class LA_Portfolio_Gallery  
	{
		
		function __construct()
		{
			add_action( 'admin_menu', array($this,'portfolio_admin_menu_page'));
			add_action( 'admin_enqueue_scripts', array($this,'admin_enqueuing_scripts'));
			add_action('wp_ajax_la_save_portfolio_gallery_data', array($this, 'save_photo_gallery_data'));
			add_shortcode( 'responsive-portfolio', array($this, 'render_portfolio_gallery') );
		}

		function admin_enqueuing_scripts($slug){
		if ($slug == 'toplevel_page_portfolio_gallery') {
			wp_enqueue_media();
			wp_enqueue_script( 'portfolio-gallery-admin-js', plugins_url( 'admin/admin.js' , __FILE__ ), array('jquery') );
			wp_enqueue_style( 'portfolio-gallery-style-css', plugins_url( 'admin/style.css' , __FILE__ ));
			wp_localize_script( 'portfolio-gallery-admin-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php' )));
			}
		}

		function save_photo_gallery_data(){
			if (isset($_REQUEST)) {
			update_option( 'la_portfolio_gallery', $_REQUEST );
			print_r($_REQUEST);
			echo _e( 'Data Saved', 'la-portfolio' );
		}

		die(0);
		}

		function portfolio_admin_menu_page(){
			add_menu_page( 'Responsive Portfolio Gallery', 'Responsive Portfolio Gallery', 'manage_options', 'portfolio_gallery', array($this,'render_menu_page'), 'dashicons-images-alt2');
		}

		function render_menu_page() {
			$saved_data = get_option('la_portfolio_gallery');
			
			?>
			<div class="container"> 
				<div id="accordion">
				  <h3><?php _e( 'Portfolio', 'la-portfolio' ); ?></h3>
				  <p>Add portfolio Items here. <b>[responsive-portfolio]</b> use this shortcode in your post and pages</p>
				  <div class="row">
					<button class="button button-primary saveData pull-right"> <?php _e( 'Save Portfolio', 'la-portfolio' ); ?></button>	
				  <span id="la-loader" class="pull-right"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader.gif"></span>
					<span id="la-saved"><strong><?php _e( 'Portfolio Saved!', 'la-portfolio' ); ?></strong></span>

					<p class="clearfix"></p>
					<h4><?php _e( 'General Settings', 'la-portfolio' ); ?></h4><hr>
					<table class="form-table">
						<tr>
							<td> <?php _e( 'Url Button Label', 'la-portfolio' ); ?></td>
							<td><input type="text" class="urllabel form-control" value="<?php echo $saved_data['urllable']; ?>"></td>
							<td><?php _e( 'Url Button Size', 'la-portfolio' ); ?></td>
							<td>
								<select name="urlsize" id="btnsize" class="form-control">
									<option value="btn-sm"><?php _e( 'Small', 'la-portfolio' ); ?></option>
									<option value="btn-md"><?php _e( 'Medium', 'la-portfolio' ); ?></option>
									<option value="btn-lg"><?php _e( 'Large', 'la-portfolio' ); ?></option>
								</select>
							</td>
						</tr>
					</table>
		  			<?php if (isset($saved_data['port'])) { ?>
		  			<?php foreach ($saved_data['port'] as $key => $data) { ?>
				  	<div class="col-sm-4 well clonecol">						
						<label for=""><?php _e( 'Portfolio Item Title', 'la-portfolio' ); ?> </label>
					  		<input type="text" class="form-control portTitle" value="<?php echo $data['title']; ?>">
					  	
					  	<div class="collection">
					  		<?php if ($data['portImages'] != '') {
								foreach ($data['portImages'] as $key => $value) {
									echo '<div><img src="'.$value.'"><span class="dashicons dashicons-dismiss"></span></div>';
								}
							} ?>
					  	</div>
					  	<button class="uploadImage button-primary"> <?php _e( 'Upload Image', 'la-portfolio' ); ?> </button>
					  	<label for=""><?php _e( 'Portfolio Items Content', 'la-portfolio' ); ?></label>
					  	<textarea name="" class="form-control portContent"><?php echo $data['content']; ?></textarea>
					  	<label> <?php _e( 'Portfolio Items URL', 'la-portfolio' ); ?> </label>
					  		<input type="text" class="form-control portUrl" placeholder="https://www.anylink.com" value="<?php echo $data['url']; ?>">
					  		  		
		  			<button class="button btnadd" id="add"><span title="Add New" class="dashicons dashicons-plus-alt"></span> <?php _e( 'Add Item', 'la-portfolio' ); ?></button>
		  			<button class="button btndelete" id="dell"><span class="dashicons dashicons-dismiss" title="Delete"></span> <?php _e( 'Delete', 'la-portfolio' ); ?></button>
				  	</div>  	
				  	<?php } ?>

				  	
				  </div>
				<?php } else { ?>
				
		  			
				  	<div class="col-sm-4 well clonecol">						
						<label for=""><?php _e( 'Porfolio Items Title', 'la-portfolio' ); ?>  </label>
					  		<input type="text" class="form-control portTitle" value="">
					  	
					  	<div class="collection">
					  		<?php if ($data['portImages'] != '') {
								foreach ($data['portImages'] as $key => $value) {
									echo '<div><img src="'.$value.'"><span class="dashicons dashicons-dismiss"></span></div>';
								}
							} ?>
					  	</div>
					  	<button class="uploadImage button-primary"> <?php _e( 'Upload Image', 'la-portfolio' ); ?> </button>
					  	<label for=""><?php _e( 'Portfolio Items Content', 'la-portfolio' ); ?></label>
					  	<textarea name="" class="form-control portContent"></textarea>
					  	<label for=""> <?php _e( 'Portfolio Items URL', 'la-portfolio' ); ?></label>
					  		<input type="text" class="form-control portUrl" placeholder="https://www.anylink.com" value="">
					  		  		
		  			<button class="button btnadd" id="add"><span title="Add New" class="dashicons dashicons-plus-alt"></span> <?php _e( 'Add Item', 'la-portfolio' ); ?></button>
		  			<button class="button btndelete" id="dell"><span class="dashicons dashicons-dismiss" title="Delete"></span> <?php _e( 'Delete', 'la-portfolio' ); ?></button>
				  	</div>  	
				  	

				  	
				  </div>
				</div>
			</div>
	<?php
	 } 
	}
	function render_portfolio_gallery(){
		$saved_data = get_option('la_portfolio_gallery');

		wp_enqueue_style( 'bootsrtap-css', plugins_url( 'css/bootstrap.min.css',__FILE__));
		wp_enqueue_style( 'gridfolio-css', plugins_url( 'css/jquery.wm-gridfolio-1.0.min.css',__FILE__));	
		wp_enqueue_script( 'bootstrap-js', plugins_url( 'js/bootstrap.min.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'gridfolio-js', plugins_url( 'js/jquery.wm-gridfolio-1.0.min.js', __FILE__ ), array('jquery','bootstrap-js') );
		wp_enqueue_script( 'custom-js', plugins_url( 'js/script.js', __FILE__ ), array('gridfolio-js') );
		?>
		
		<div class="wmg-container my-grid">
			<?php if (isset($saved_data['port'])) { ?>
			<?php foreach ($saved_data['port'] as $key => $data) { ?>
				<div class="wmg-item">
  				<div class="wmg-thumbnail">
  					<div class="wmg-thumbnail-content">

  						<!-- exemplo de conteudo para thumbnail -->
  						<?php if ($data['portImages'] != '') {
								foreach ($data['portImages'] as $key => $value) {
									echo '<img src="'.$value.'">';
								}
						} ?>
  						<!-- fim do exemplo -->

  					</div>
  					<div class="wmg-arrow"></div>
  				</div>
  				<div class="wmg-details">
  					<span class="wmg-close"></span>
  					<div class="wmg-details-content">
  						
  						<!-- exemplo de coteúdo para detail -->
  						<div class="exemplo" style="padding: 20px;">
  							<div class="row">
  								<div class="col-md-6">
  									<?php if ($data['portImages'] != '') {
									foreach ($data['portImages'] as $key => $value) {
									echo '<img src="'.$value.'">';
									}
								} ?>
  								</div>
		  						<div class="col-md-6">
		  							<h2><?php echo $data['title']; ?></h2><hr>
		  							<p>
		  								<?php echo $data['content']; ?>
		  							</p>
		  							<a href="<?php echo $data['url']; ?>" class="btn btn-primary <?php echo $saved_data['urlbtnsize']; ?>" title="<?php echo $saved_data['urllable']; ?>"><?php echo $saved_data['urllable']; ?></a>
		  						</div>
	  						</div>
  						</div>
  						<!-- fim do exemplo -->

  					</div>
  				</div>
  			</div><!-- .wmg-item -->
  			<?php } 
  			} ?>
		</div>
	<?php
	}
  }
  ?>




