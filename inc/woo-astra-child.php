<?php
class Woocommerce_Astra_Child {
	public function __construct()
    {
        add_action( 'woocommerce_before_main_content', array( $this, 'astra_child_before_main_content_start' ), 99 );
		add_action( 'woocommerce_after_main_content', array( $this, 'astra_child_after_main_content_end' ), 99 );
		// add_action( 'wp', array( $this, 'init' ), 1 );
        // add_action( 'after_setup_theme', array( $this, 'remove_parent_theme_action' ), 9999 );
    }

    public function remove_parent_theme_action() {
        remove_action( 'woocommerce_before_main_content', array( 'Astra_Woocommerce', 'before_main_content_start' ), 9999 );
        remove_action( 'woocommerce_after_main_content', array( 'Astra_Woocommerce', 'before_main_content_end' ), 9999 );
    }

    public function init()
    {
        remove_action( 'woocommerce_before_main_content', 'before_main_content_start', 1 );
		remove_action( 'woocommerce_after_main_content', 'before_main_content_end', 1 );
    }

    public function astra_child_before_main_content_start() {
        // $site_sidebar = astra_page_layout();
        // if ( 'left-sidebar' == $site_sidebar ) {
        //     get_sidebar();
        // }
        ?>
        <div id="primary222" class="content-area primary xx">
            
        <?php
    }

    public function astra_child_after_main_content_end() {
        
        ?>

        </div> <!-- #primary -->
        <?php
        // $site_sidebar = astra_page_layout();
        // if ( 'right-sidebar' == $site_sidebar ) {
        //     get_sidebar();
        // }
    }
}
new Woocommerce_Astra_Child();