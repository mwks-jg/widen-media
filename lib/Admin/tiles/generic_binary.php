<?php
/**
 * Results tile for an Office file (.doc, .xls, etc).
 */

declare( strict_types = 1 );

namespace Masonite\WP\Widen_Media;

// If this file is called directly, abort.
defined( 'WPINC' ) || die();

$file_id         = $item['id'] ?? '';
$file_filename   = $item['filename'] ?? '';
$description_arr = $item['metadata']['fields']['description'] ?? [];
$description     = implode( ' ', $description_arr );
$fields_arr      = $item['metadata']['fields'] ?? [];
$fields          = wp_json_encode( $fields_arr );
$templated_url   = $item['embeds']['templated']['url'] ?? '';

$original_url  = $item['embeds']['original']['url'] ?? '';
$thumbnail_url = $item['embeds']['document_thumbnail']['url'] ?? '';
$skeleton_url  = $item['embeds']['document_thumbnail']['url'] ?? '';

$placeholder_img = plugin_dir_url( __DIR__ ) . '../../dist/img/placeholder.jpg';

// Remove query string from url.
$original_url  = Util::remove_query_string( $original_url );
$thumbnail_url = Util::remove_query_string( $thumbnail_url );
$skeleton_url  = Util::remove_query_string( $skeleton_url );

// Check if the file has already been added.
$already_added = Util::attachment_exists( $original_url );
$attachment_id = $already_added ? Util::get_attachment_id( $original_url ) : '';

$file_ext = pathinfo( $original_url );
$file_ext = $file_ext['extension'];
?>
<div class="tile file <?php echo esc_attr( $already_added ) ? 'added' : ''; ?>">
	<div class="tile__wrapper">
		<div class="tile__header" aria-hidden="true">
			<img
				class="tile__image blur-up lazyload"
				src="<?php echo $thumbnail_url ? esc_url( $thumbnail_url ) : esc_attr( Util::placeholder_image_url() ); ?>"
				data-src="<?php echo $thumbnail_url ? esc_url( $thumbnail_url ) : esc_attr( Util::placeholder_image_url() ); ?>"
				alt="<?php echo esc_attr( $description ); ?>"
			/>
		</div>
		<div class="tile__content">
			<p class="tile__title"><?php echo esc_attr( $file_filename ); ?></p>

			<?php if ( $already_added ) : ?>

				<div class="tile__button-wrapper">
					<a class="button-link" href="<?php echo esc_url( admin_url( "upload.php?item=$attachment_id" ) ); ?>"><?php esc_html_e( 'View In Media Library', 'widen-media' ); ?></a>
				</div>

				<?php else : ?>

				<div class="tile__button-wrapper">
					<button
						class="button add-to-library"
						data-type="generic"
						data-ext="<?php echo esc_attr( $file_ext ); ?>"
						data-id="<?php echo esc_attr( $file_id ); ?>"
						data-filename="<?php echo esc_attr( $file_filename ); ?>"
						data-description="<?php echo esc_attr( $description ); ?>"
						data-url="<?php echo esc_attr( $original_url ); ?>"
						data-templated-url="<?php echo esc_attr( Util::sanitize_image_url( $templated_url ) ); ?>"
						data-thumbnail-url="<?php echo esc_attr( Util::sanitize_image_url( $thumbnail_url ) ); ?>"
						data-fields="<?php echo esc_attr( $fields ); ?>"
					><?php esc_html_e( 'Add to Media Library', 'widen-media' ); ?></button>
					<span class="spinner"></span>
				</div>

			<?php endif; ?>

		</div>
	</div>
</div>
