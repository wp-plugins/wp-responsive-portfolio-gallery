<?php 
		/*
	Plugin Name: WP Responsive Portfolio Gallery
	Description: WP Responsive Portfolio Gallery is a creatve design to display your work with a new look. 
	Plugin URI: http://labibahmed.com/wp-responsive-portfolio-gallery/
	Author: Labib Ahmed
	Author URI: http://labibahmed.com
	Version: 1.0
	License: GPL2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
	Text Domain: la-portfolio
	*/
	
	/*
	
	    Copyright (C) Year  Labib Ahmed  Email labib@najeebmediagroup.com
	
	    This program is free software; you can redistribute it and/or modify
	    it under the terms of the GNU General Public License, version 2, as
	    published by the Free Software Foundation.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program; if not, write to the Free Software
	    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/

	include_once ('plugin.class.php');
	if (class_exists('LA_Portfolio_Gallery')) {
		$object = new LA_Portfolio_Gallery;
	}
 ?>