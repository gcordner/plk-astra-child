<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <main class="root...">.
 *
 * @package PLK
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="format-detection" content="telephone=no">
	<?php
	$google_map_key = get_field( 'google_map_key', 'option' );
	if ( $google_map_key ) :
		?>
		<meta name="GOOGLE_API_KEY" content="<?php echo esc_html( $google_map_key ); ?>">
		<?php
	endif;
	?>
	<?php
	$favicon = get_field( 'favicon', 'option' );
	if ( $favicon && is_array( $favicon ) ) :
		?>
		<link rel="shortcut icon" href="<?php echo esc_url( wp_get_attachment_image_src( $favicon['ID'], 'full', '' )[0] ); ?>" type="image/png">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		<?php
	endif;
	?>
	<script>
		// prettier-ignore
		! function(e, n, o) {
			function t(e, n) {
				return typeof e === n
			}

			function s() {
				return "function" != typeof n.createElement ? n.createElement(arguments[0]) : d ? n.createElementNS.call(n, "http://www.w3.org/2000/svg", arguments[0]) : n.createElement.apply(n, arguments)
			}

			function a() {
				var e = n.body;
				return e || ((e = s(d ? "svg" : "body")).fake = !0), e
			}
			var i = [],
				r = [],
				l = {
					_version: "3.6.0",
					_config: {
						classPrefix: "",
						enableClasses: !0,
						enableJSClass: !0,
						usePrefixes: !0
					},
					_q: [],
					on: function(e, n) {
						var o = this;
						setTimeout(function() {
							n(o[e])
						}, 0)
					},
					addTest: function(e, n, o) {
						r.push({
							name: e,
							fn: n,
							options: o
						})
					},
					addAsyncTest: function(e) {
						r.push({
							name: null,
							fn: e
						})
					}
				},
				f = function() {};
			f.prototype = l, f = new f;
			var c = n.documentElement,
				d = "svg" === c.nodeName.toLowerCase(),
				p = l._config.usePrefixes ? " -webkit- -moz- -o- -ms- ".split(" ") : ["", ""];
			l._prefixes = p;
			var u = l.testStyles = function(e, o, t, i) {
				var r, l, f, d, p = "modernizr",
					u = s("div"),
					h = a();
				if (parseInt(t, 10))
					for (; t--;)(f = s("div")).id = i ? i[t] : p + (t + 1), u.appendChild(f);
				return (r = s("style")).type = "text/css", r.id = "s" + p, (h.fake ? h : u).appendChild(r), h.appendChild(u), r.styleSheet ? r.styleSheet.cssText = e : r.appendChild(n.createTextNode(e)), u.id = p, h.fake && (h.style.background = "", h.style.overflow = "hidden", d = c.style.overflow, c.style.overflow = "hidden", c.appendChild(h)), l = o(u, e), h.fake ? (h.parentNode.removeChild(h), c.style.overflow = d, c.offsetHeight) : u.parentNode.removeChild(u), !!l
			};
			f.addTest("touchevents", function() {
				var o;
				if ("ontouchstart" in e || e.DocumentTouch && n instanceof DocumentTouch) o = !0;
				else {
					var t = ["@media (", p.join("touch-enabled),("), "heartz", ")", "{#modernizr{top:9px;position:absolute}}"].join("");
					u(t, function(e) {
						o = 9 === e.offsetTop
					})
				}
				return o
			}),
				function() {
					var e, n, o, s, a, l;
					for (var c in r)
						if (r.hasOwnProperty(c)) {
							if (e = [], (n = r[c]).name && (e.push(n.name.toLowerCase()), n.options && n.options.aliases && n.options.aliases.length))
								for (o = 0; o < n.options.aliases.length; o++) e.push(n.options.aliases[o].toLowerCase());
							for (s = t(n.fn, "function") ? n.fn() : n.fn, a = 0; a < e.length; a++) 1 === (l = e[a].split(".")).length ? f[l[0]] = s : (!f[l[0]] || f[l[0]] instanceof Boolean || (f[l[0]] = new Boolean(f[l[0]])), f[l[0]][l[1]] = s), i.push((s ? "" : "no-") + l.join("-"))
						}
				}(),
				function(e) {
					var n = c.className,
						o = f._config.classPrefix || "";
					if (d && (n = n.baseVal), f._config.enableJSClass) {
						var t = new RegExp("(^|\\s)" + o + "no-js(\\s|$)");
						n = n.replace(t, "$1" + o + "js$2")
					}
					f._config.enableClasses && (n += " " + o + e.join(" " + o), d ? c.className.baseVal = n : c.className = n)
				}(i), delete l.addTest, delete l.addAsyncTest;
			for (var h = 0; h < f._q.length; h++) f._q[h]();
			e.Modernizr = f
		}(window, document);
	</script>
	<style>
		a.added_to_cart.wc-forward {
			display: none;
		}
		.agy .box .box-right div {
			color: #1c1c1c;
			text-transform: uppercase;
			letter-spacing: 0.07em;
			border-bottom: 1px solid #eee;
			padding-bottom: 1em;
			margin: 10px auto;
			font-size: 1.2rem;
		}
	</style>
	<?php wp_head(); ?>
</head>
<body>
<?php
if ( is_page_template( 'page-landing-page.php' ) ) {
	get_template_part( 'template-parts/header/landing-page', 'header' );
} else {
	get_template_part( 'template-parts/header/plk', 'header' );

}
?>


<main class="root 
<?php
if ( isset( $top_banner ) && $top_banner ) :
	echo 'root-mg';
endif;
?>
"
	<?php
	if ( is_page( 104524 ) ) :
		?>
			itemscope itemtype="https://schema.org/FAQPage"
		<?php
	endif;
	?>
	>