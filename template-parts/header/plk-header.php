<?php
/**
 * The header for our theme.
 *
 * Displays all of the header nav section and menu.
 *
 * @package PLK
 */

$top_banner = get_field( 'top_banner', 'option' );
$email      = get_field( 'email', 'option' );
$phone      = get_field( 'phone', 'option' );
?>

<header class="header
	<?php
	if ( isset( $top_banner ) && $top_banner ) :
		echo ' bar-shown" style="--header-banner-height:45px';
	endif;
	?>
">
	<?php
	if ( isset( $top_banner ) && $top_banner ) :
		?>
		<div class="header__banner">
			<div class="container">
				<div class="header__banner-text text-small text-reset"><?php echo esc_html( $top_banner ); ?></div><button class="header__banner-close" aria-label="Close Banner"></button>
			</div>
		</div>
		<?php
	endif;
	?>
	<div class="header__nav">
		<div class="container">
			<a class="header__logo-link" href="/" aria-label="Header Logo">
				<svg width="215" height="39" viewBox="0 0 215 39" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M64.8328 21.0261H77.6147C78.0544 19.685 78.4035 16.1217 76.2824 12.5972C73.801 8.47389 70.2105 8.53308 68.7223 8.55761C68.6203 8.55929 68.5283 8.56081 68.4471 8.56081C65.7826 8.56081 58.8706 10.4998 58.8706 17.4778C58.8706 24.4557 59.9918 29.1384 69.3836 29.4418C71.393 29.4813 76.1241 28.6899 76.1241 28.6899C76.1241 28.6899 76.0713 25.4186 76.0713 24.6931C76.0713 24.6931 69.1462 25.4713 67.4974 24.6931C65.8485 23.9148 65.0966 23.3476 64.8328 21.0261ZM64.9251 16.9237H72.2196C72.0569 15.4991 71.1142 12.6288 68.6449 12.5444C66.1756 12.46 65.1362 15.4288 64.9251 16.9237Z" fill="#3D3D3D"/>
					<path d="M40.1528 9.04889H33.0825C35.7295 14.6681 40.9838 26.4053 40.8255 28.3997C40.6672 30.3942 36.9166 32.4317 35.0611 33.2012L36.5649 38.1081C36.5649 38.1081 40.7453 36.2123 43.6747 33.3726C48.4102 28.7823 51.8881 14.3076 53.1984 9.04889H47.4604L43.9781 22.6881L40.1528 9.04889Z" fill="#3D3D3D"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M0 28.9273H6.30518V19.2717C10.6845 19.5355 19.9761 18.0951 20.0499 10.4866C20.1238 2.87822 13.9031 1.41141 7.88807 1.41141H0.0131908L0 28.9273ZM6.27876 5.63247V14.6418C8.72784 14.9012 13.6497 14.2724 13.7447 9.68203C13.8397 5.09165 8.80698 5.06966 6.27876 5.63247Z" fill="#3D3D3D"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M19.2454 10.1833C20.4589 9.52815 23.6432 8.27854 26.6718 8.52125C30.4575 8.82464 34.7841 9.93266 34.7709 15.6047C34.7603 20.1423 34.7665 26.4123 34.7709 28.9801H29.6265V26.6981C29.1253 27.6522 27.2311 29.5552 23.6643 29.5341C19.2058 29.5077 17.3591 25.9067 17.2932 22.2133C17.2272 18.5198 22.0023 15.6047 25.1285 15.6047H28.9538C29.134 14.5978 28.8192 12.555 26.1178 12.4389C23.4163 12.3228 20.4106 13.3842 19.2454 13.9295V10.1833ZM28.9802 19.3113V22.9255C28.668 23.7434 27.5872 25.3817 25.7616 25.3922C23.4796 25.4054 23.0707 23.1102 23.0707 22.3979C23.0707 21.6856 23.6775 19.3772 26.3288 19.3113C28.4499 19.2585 28.9802 19.2893 28.9802 19.3113Z" fill="#3D3D3D"/>
					<rect x="52.8818" width="6.19965" height="28.9405" fill="#3D3D3D"/>
					<path d="M90.4358 9.2995L89.7103 13.5469C88.9144 13.1688 86.9851 12.4231 85.6343 12.4653C83.9459 12.518 82.64 13.8635 83.0489 15.1034C83.4579 16.3434 91.4119 17.8339 91.3591 22.6749C91.3063 27.5159 88.0614 28.9801 83.5634 29.4418C79.9649 29.8111 77.3857 29.112 76.5459 28.7163L77.7331 23.8093C80.8593 25.5109 85.1858 25.5637 85.7794 23.6906C86.373 21.8175 80.6218 20.4688 79.2896 19.4696C78.6564 18.9947 75.7281 15.1958 78.6432 10.9747C80.9753 7.59789 87.4766 8.4509 90.4358 9.2995Z" fill="#3D3D3D"/>
					<path d="M103.969 9.2995L103.244 13.5469C102.448 13.1688 100.519 12.4231 99.168 12.4653C97.4796 12.518 96.1737 13.8635 96.5826 15.1034C96.9915 16.3434 104.946 17.8339 104.893 22.6749C104.84 27.5159 101.595 28.9801 97.0971 29.4418C93.4986 29.8111 90.9194 29.112 90.0796 28.7163L91.2668 23.8093C94.393 25.5109 98.7195 25.5637 99.3131 23.6906C99.9067 21.8175 94.1555 20.4688 92.8233 19.4696C92.1901 18.9947 89.2618 15.1958 92.1769 10.9747C94.509 7.59789 101.01 8.4509 103.969 9.2995Z" fill="#3D3D3D"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M137.461 10.1833C138.675 9.52815 141.859 8.27854 144.888 8.52125C148.673 8.82464 153 9.93266 152.987 15.6047C152.976 20.1423 152.982 26.4123 152.987 28.9801H147.842V26.6981C147.341 27.6522 145.447 29.5552 141.88 29.5341C137.422 29.5077 135.575 25.9067 135.509 22.2133C135.443 18.5198 140.218 15.6047 143.344 15.6047H147.17C147.35 14.5978 147.035 12.555 144.334 12.4389C141.632 12.3228 138.626 13.3842 137.461 13.9295V10.1833ZM147.196 19.3113V22.9255C146.884 23.7434 145.803 25.3817 143.978 25.3922C141.696 25.4054 141.287 23.1102 141.287 22.3979C141.287 21.6856 141.893 19.3772 144.545 19.3113C146.666 19.2585 147.196 19.2893 147.196 19.3113Z" fill="#8CB35D"/>
					<path d="M111.422 1.05527H105.196V28.8746H111.422V19.5487L114.047 17.1876L120.352 28.8746H127.462L118.228 13.2567L127.396 1.05527H119.983L111.422 13.2567V1.05527Z" fill="#8CB35D"/>
					<path d="M125.642 28.8614V9.11485L131.063 9.03571V12.3466C131.39 9.7612 136.036 8.64878 137.949 8.41574V13.4018C134.234 13.7817 132.153 15.9345 131.947 16.9633V28.8614H125.642Z" fill="#8CB35D"/>
					<path d="M161.481 3.28452L155.268 5.0125V8.98292H152.221L152.313 13.5601H155.268V20.538C155.158 21.8439 155.331 25.0624 156.903 27.4895C158.476 29.9166 163.231 29.8463 165.411 29.5077V24.3501C165.293 24.3589 164.694 24.3712 163.248 24.3501C161.802 24.329 161.467 22.8992 161.481 22.1869V13.5601H165.82V8.98292H161.481V3.28452Z" fill="#8CB35D"/>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M175.133 8.62677C178.391 8.69273 184.456 10.5684 184.657 18.4407C184.857 26.3129 178.057 29.1076 174.632 29.5209C171.15 29.4945 164.681 27.4658 164.66 18.6649C164.639 9.86406 171.633 8.3058 175.133 8.62677ZM174.658 25.4054C176.829 25.4054 178.589 22.5648 178.589 19.0607C178.589 15.5566 176.829 12.7159 174.658 12.7159C172.487 12.7159 170.727 15.5566 170.727 19.0607C170.727 22.5648 172.487 25.4054 174.658 25.4054Z" fill="#8CB35D"/>
					<path d="M184.288 29.0592V9.03569H189.854V11.2649C190.316 10.2888 192.16 8.33658 195.843 8.33658C199.526 8.33658 201.141 10.6142 201.488 11.753C201.787 10.5702 203.538 8.23106 208.15 8.33658C212.761 8.44211 214.472 12.2674 214.811 14.1933C215.15 16.1191 214.93 28.9405 214.93 28.9405H208.809L208.651 15.7498C208.625 14.8704 207.807 13.4546 205.683 13.4546C203.234 13.4546 202.579 14.9935 202.504 15.8289V29.1384L196.225 29.0592V15.7498C195.856 14.9232 195.395 13.4546 193.482 13.4546C192.136 13.4546 190.683 14.3516 190.54 15.7498C190.397 17.148 190.54 29.0592 190.54 29.0592H184.288Z" fill="#8CB35D"/>
				</svg>	
			</a>

			<div class="header__nav-wrapper">
				<div class="header__nav-search mobile-hide">
					<?php aws_get_search_form( true ); ?>
				</div>
				<a class="btn btn--small btn--transparent header__nav-btn header__nav-private" href="/my-account/" aria-label="My Account">
					<?php
					if ( is_user_logged_in() ) :
						global $current_user;
						?>
						<span class="header__nav-btn-text">My Account</span>
						<?php
					else :
						?>
						<span class="header__nav-btn-text">Sign in </span>
						<?php
					endif;
					?>
					<span class="header__nav-btn-icon icon-private desktop-hide"></span>
				</a>
				<a class="btn btn--small btn--primary header__nav-btn header__nav-basket-btn" href="/cart/" aria-label="Cart Button">
					<?php $items_count = WC()->cart->get_cart_contents_count(); ?>
					<span class="header__nav-btn-text">Cart</span>
					<span class="header__nav-backet-count woo-cart-items-count"><?php echo esc_attr( $items_count ? $items_count : '0' ); ?></span>
					<span class="header__nav-btn-icon icon-basket"></span>
				</a>
				<button class="header__nav-burger desktop-hide" aria-label="NAV BURGER DELUXE">
					<span class="header__nav-burger-line header__nav-burger-line--top"></span>
					<span class="header__nav-burger-line header__nav-burger-line--bottom"></span>
				</button>
			</div>
		</div>
	</div>
	<!-- NEW DIV FOR THE NAV MENU -->
<div class="container container__desktop-nav">
<nav class="header__nav-block desktop-only <?php echo $top_banner ? 'header__nav-block--top-lg' : ''; ?>">
				<div class="header__nav-search desktop-hide">
					<?php aws_get_search_form( true ); ?>
				</div>
				<?php
				$url = '';
				if ( isset( $_SERVER['REQUEST_URI'] ) ) :
					$url = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
				endif;
				$url_absolute    = home_url() . $url;
				$menu_locationss = get_nav_menu_locations();
				$menu_id         = $menu_locationss['header_menu'] ?? null;
				$header_menu     = wp_get_menu_array( $menu_id ) ?? null;
				?>
				<?php if ( $header_menu ) { ?>
				<style>.mt{margin-top:10px}</style>
				<ul class="header__nav-list list-reset">
					<?php foreach ( $header_menu as $nav_item ) { ?>
						<?php $class = $url === $nav_item['url'] || $url_absolute === $nav_item['url'] ? 'active' : ''; ?>
						<?php if ( isset( $nav_item['submenu'] ) && $nav_item['submenu'] ) { ?>
							<li class="header__nav-item <?php echo esc_attr( $class ); ?>">
								<?php
								$needle_array       = array( ' - 2cols', ' - 3cols', ' - 4cols' );
								$repl_array         = array( '', '', '' );
								$mlink              = new Link(
									array(
										'url'    => $nav_item['url'],
										'target' => $nav_item['target'],
										'title'  => str_replace( $needle_array, $repl_array, $nav_item['title'] ),
									)
								);
								$mlink->class       = 'header__nav-link link-reset';
								$mlink->wrapper_end = '<span class="icon-arrow-up mobile-hide"></span><span class="icon-nav-arrow desktop-hide"></span>';
								echo $mlink->a();
								?>
								<div class="header__nav-dropdown">
									<?php
									$additional_class = '';
									if ( strpos( $nav_item['title'], ' - 2cols' ) !== false ) :
										$additional_class = ' header__nav-dropdown-wrapper_2col';
									endif;
									if ( strpos( $nav_item['title'], ' - 3cols' ) !== false ) :
										$additional_class = ' header__nav-dropdown-wrapper_3col';
									endif;
									if ( strpos( $nav_item['title'], ' - 4cols' ) !== false ) :
										$additional_class = ' header__nav-dropdown-wrapper_4col';
									endif;
									?>
									<div class="header__nav-dropdown-wrapper<?php echo esc_attr( $additional_class ); ?>">
										<div class="header__nav-dropdown-back desktop-hide"><button class="header__nav-dropdown-back-link btn btn--arrow"><span class="icon-nav-arrow"></span><span>Back to the main menu</span></button></div>
										<?php
										foreach ( $nav_item['submenu'] as $submenu_item ) {
											$class = $url === $submenu_item['url'] || $url_absolute === $submenu_item['url'] ? 'active' : '';
											if ( isset( $submenu_item['submenu'] ) && $submenu_item['submenu'] ) {
												$fl_submenu_before = true;
												?>
												<div class="header__nav-dropdown-inner">
													<?php
													$s_link              = new Link(
														array(
															'url' => $submenu_item['url'],
															'target' => $submenu_item['target'],
															'title' => $submenu_item['title'],
														)
													);
													$s_link->class       = esc_attr( 'header__nav-dropdown-link header__nav-dropdown-link--title link-reset heading-tiny' );
													$s_link->wrapper_end = '<span class="icon-nav-arrow header__nav-dropdown-link-icon"></span>';
													echo wp_kses_post( $s_link->a() );
													?>
													<ul class="header__nav-dropdown-list list-reset">
														<?php foreach ( $submenu_item['submenu'] as $subsubmenuitem ) { ?>
															<?php $class = $url === $subsubmenuitem['url'] || $url_absolute === $subsubmenuitem['url'] ? 'active' : ''; ?>
															<li class="header__nav-dropdown-item <?php echo esc_attr( $class ); ?>">
																<?php
																$ss_link        = new Link(
																	array(
																		'url'    => $subsubmenuitem['url'],
																		'target' => $subsubmenuitem['target'],
																		'title' => $subsubmenuitem['title'],
																	)
																);
																$ss_link->class = 'header__nav-dropdown-link nav-text link-reset';
																echo $ss_link->a();
																?>
															</li>
														<?php } ?>
													</ul>
												</div>
											<?php } else { ?>
												<?php
												$dlink         = new Link(
													array(
														'url' => $submenu_item['url'],
														'target' => $submenu_item['target'],
														'title' => str_replace( array( ' (mob)', ' (all)' ), '', $submenu_item['title'] ),
													)
												);
												$dlink->class  = 'header__nav-dropdown-link header__nav-dropdown-link--title link-reset heading-tiny' . ( strpos( $submenu_item['title'], ' (mob)' ) === false ? '' : ' desktop-hide' ) . ( $fl_submenu_before ? ' mt' : '' );
												$dlink->class .= strpos( $submenu_item['title'], ' (all)' ) === false ? '' : ' header__nav-dropdown-link_all';
												echo $dlink->a();
												$fl_submenu_before = false;
											}
										}
										?>
									</div>
								</div>
							</li>
						<?php } else { ?>
							<li class="nav-item nav-item_main <?php echo esc_attr( $class ); ?>">
								<?php
									$rlink        = new Link(
										array(
											'url'    => $nav_item['url'],
											'target' => $nav_item['target'],
											'title'  => $nav_item['title'],
										)
									);
									$rlink->class = 'header__nav-link link-reset';
									echo $rlink->a();
								?>
							</li>
						<?php } ?>
					<?php } ?>
					<?php
					$url                = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
					$url_absolute       = home_url() . $url;
					$menu_locationss    = get_nav_menu_locations();
					$menu_id            = $menu_locationss['header_menu_mobile'] ?? null;
					$header_menu_mobile = wp_get_menu_array( $menu_id ) ?? null;
					?>
					<li class="desktop-hide">
						<?php
						if ( $header_menu_mobile ) :
							?>
							<ul class="header__nav-mobile-menu list-reset">
								<?php
								foreach ( $header_menu_mobile as $nav_item ) {
									$class = $url === $nav_item['url'] || $url_absolute === $nav_item['url'] ? 'active' : '';
									echo '<li class="header__nav-mobile-menu-item ' . esc_attr( $class ) . '">';
										$vlink        = new Link(
											array(
												'url'    => $nav_item['url'],
												'target' => $nav_item['target'],
												'title'  => $nav_item['title'],
											)
										);
										$vlink->class = 'header__nav-mobile-menu-link link-reset' . ( stripos( $nav_item['title'], ' view all' ) === false ? '' : ' header__nav-dropdown-link_all' );
										echo $vlink->a();
									echo '</li>';
								}
								?>
							</ul>
							<?php
						endif;
						?>
					</li>
				</ul>
			</nav>
			<?php } ?>
	</div>

</header>
<!--HEADER ENDS-->
