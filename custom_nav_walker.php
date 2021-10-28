

<?php


// don't work this link like 'http://batch24.xyz/megamenu/script.txt'

// HOw can i get the code? 


class Custom_Nav_Walker_Menu extends Walker {


    /**
	 * What the class handles.
	 *
	 * @since 3.0.0
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

    public $megamenu;


	/**
	 * Database fields to use.
	 *
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 *
	 * @see Walker::$db_fields
	 */
	public $db_fields = array(
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	);

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );



		// Default class.
		$classes = array( 'submenu');

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
        

        if($item->megamenu == 'Megamenu'){
            $megamenu = 'megamenu';
        }

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}

}
?>
<?php 




// Another work for megamenu



add_filter('wp_setup_nav_menu_item', 'add_new_fied');

function add_new_fied( $item ){
    $item->megamenu = get_post_meta($item->ID, 'new_select_option', true);

    return $item;
}


add_filter('wp_update_nav_menu_item', 'save_add_new_fied', 10, 3);

function save_add_new_fied($menu_id, $db_id, $arg){
    
    if(is_array($_REQUEST['menu-item-megamenu'])){
        $database_id     = $_REQUEST['menu-item-megamenu'];
        update_post_meta($db_id, 'new_select_option', $database_id );
    }
}

add_filter('wp_edit_nav_menu_walker', 'nav_menu_edit');


function nav_menu_edit(){
    return 'new_calss_name';
}

class new_calss_name extends Walker_Nav_Menu{

    public function start_lvl( &$output, $depth = 0, $args = array() ) {

    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {

	}

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        ob_start(); ?>

        <li id="menu-item-<?php echo $item->ID; ?>" class="menu-item menu-item-depth-0 menu-item-page menu-item-edit-inactive pending" style="">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
					<label class="item-title" for="menu-item-checkbox-<?php echo $item->ID; ?>">
						<input id="menu-item-checkbox-<?php echo $item->ID; ?>" type="checkbox" class="menu-item-checkbox" data-menu-item-id="<?php echo $item->ID; ?>" disabled="disabled">
						<span class="menu-item-title"><?php echo $item->title; ?></span>
						<span class="is-submenu" style="display: none;">sub item</span>
					</label>
					<span class="item-controls">
						<span class="item-type">Page</span>
						<span class="item-order hide-if-js">
							<a href="http://localhost/comet/wp-admin/nav-menus.php?action=move-up-menu-item&amp;menu-item=<?php echo $item->ID; ?>&amp;_wpnonce=a014028f3f" class="item-move-up" aria-label="Move up">↑</a>							|
							<a href="http://localhost/comet/wp-admin/nav-menus.php?action=move-down-menu-item&amp;menu-item=<?php echo $item->ID; ?>&amp;_wpnonce=a014028f3f" class="item-move-down" aria-label="Move down">↓</a>						</span>
						<a class="item-edit" id="edit-<?php echo $item->ID; ?>" href="http://localhost/comet/wp-admin/nav-menus.php?edit-menu-item=<?php echo $item->ID; ?>#menu-item-settings-<?php echo $item->ID; ?>" aria-label="Process. Menu item 1 of 1."><span class="screen-reader-text">Edit</span></a>					</span>
				</div>
			</div>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo $item->ID; ?>">
								<p class="description description-wide">
					<label for="edit-menu-item-title-<?php echo $item->ID; ?>">
						Navigation Label<br>
						<input type="text" id="edit-menu-item-title-<?php echo $item->ID; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item->ID; ?>]" value="Process">
					</label>
				</p>
				<p class="field-title-attribute field-attr-title description description-wide hidden-field">
					<label for="edit-menu-item-attr-title-<?php echo $item->ID; ?>">
						Title Attribute<br>
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item->ID; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item->ID; ?>]" value="">
					</label>
				</p>
				<p class="field-link-target description hidden-field">
					<label for="edit-menu-item-target-<?php echo $item->ID; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item->ID; ?>" value="_blank" name="menu-item-target[<?php echo $item->ID; ?>]">
						Open link in a new tab					</label>
				</p>
				<p class="field-css-classes description description-thin hidden-field">
					<label for="edit-menu-item-classes-<?php echo $item->ID; ?>">
						CSS Classes (optional)<br>
						<input type="text" id="edit-menu-item-classes-<?php echo $item->ID; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item->ID; ?>]" value="">
					</label>
				</p>
				<p class="field-xfn description description-thin hidden-field">
					<label for="edit-menu-item-xfn-<?php echo $item->ID; ?>">
						Link Relationship (XFN)<br>
						<input type="text" id="edit-menu-item-xfn-<?php echo $item->ID; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item->ID; ?>]" value="">
					</label>
				</p>
				<p class="field-description description description-wide hidden-field">
					<label for="edit-menu-item-description-<?php echo $item->ID; ?>">
						Description<br>
						<textarea id="edit-menu-item-description-<?php echo $item->ID; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item->ID; ?>]"></textarea>
						<span class="description">The description will be displayed in the menu if the current theme supports it.</span>
					</label>
				</p>

				
				<fieldset class="field-move hide-if-no-js description description-wide" style="display: none;">
					<span class="field-move-visual-label" aria-hidden="true">Move</span>
					<button type="button" class="button-link menus-move menus-move-up" data-dir="up" style="display: none;">Up one</button>
					<button type="button" class="button-link menus-move menus-move-down" data-dir="down" style="display: none;">Down one</button>
					<button type="button" class="button-link menus-move menus-move-left" data-dir="left" style="display: none;"></button>
					<button type="button" class="button-link menus-move menus-move-right" data-dir="right" style="display: none;"></button>
					<button type="button" class="button-link menus-move menus-move-top" data-dir="top" style="display: none;">To the top</button>
				</fieldset>

				<div class="menu-item-actions description-wide submitbox">
											<p class="link-to-original">
							Original: <a href="http://localhost/comet/process/">Process</a>						</p>
					
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item->ID; ?>" href="http://localhost/comet/wp-admin/nav-menus.php?action=delete-menu-item&amp;menu-item=<?php echo $item->ID; ?>&amp;_wpnonce=2f79d2ae99">Remove</a>					<span class="meta-sep hide-if-no-js"> | </span>
					<a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item->ID; ?>" href="http://localhost/comet/wp-admin/nav-menus.php?edit-menu-item=<?php echo $item->ID; ?>&amp;cancel=1630149656#menu-item-settings-<?php echo $item->ID; ?>">Cancel</a>				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item->ID; ?>]" value="<?php echo $item->ID; ?>">
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item->ID; ?>]" value="<?php echo $item->object_id; ?>">
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item->ID; ?>]" value="<?php echo $item->object; ?>">
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item->ID; ?>]" value="<?php echo $item->manu_item_parent; ?>">
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item->ID; ?>]" value="<?php echo $item->menu_order; ?>">
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item->ID; ?>]" value="<?php echo $item->item_type; ?>">
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		</li>


        <?php $output .= ob_get_clean();
    }
}