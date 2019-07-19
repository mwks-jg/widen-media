# Widen Media

[![Widen Media on Packagist](https://img.shields.io/packagist/v/masonitedoors/widen-media.svg?style=flat)](https://packagist.org/packages/masonitedoors/widen-media)

> Search and add Widen digital assets to your WordPress media library.

This WordPress plugin lets users search for images in [Widen](https://www.widen.com/) and add them to their site's media library. This plugin does not download media from Widen but rather creates a new WordPress media attachment that refers to the Widen asset URL.
Some additional Widen metadata is captured and saved to the database on the "Add to Media Library" action. This plugin does not currently support syncing of meta data between Widen & WordPress.

## Installation

You can either [download a release zip](https://github.com/masonitedoors/widen-media/releases) and install via the WordPress plugin installer or via composer.

### Composer

```shell
composer require masonitedoors/widen-media
```

## Configuration

### WordPress

This plugin uses [V2 of the Widen API](https://widenv2.docs.apiary.io/). You will need to define your Widen API access token in `wp-config.php`.

```php
define( 'WIDEN_MEDIA_ACCESS_TOKEN', 'my-widen-api-token' );
```

### Widen

This plugin uses the `expand` property when requesting data from the V2 of the Widen API. In order for this plugin to work, you must create "Share Links" within the administration screen of your organization's Widen account that match what this plugin is expecting. This can usually be found by visiting `https://your-organiztion-name.widencollective.com/admin/imageembed`. Keep in mind that for images Widen will always be able to create a PNG, JPEG, & GIF. If another file format is uploaded such as TIFF, this plugin will take the PNG.

| Share Link    | Description                                                                                  |
| ------------- | -------------------------------------------------------------------------------------------- |
| Original PNG  | The original image as a PNG                                                                  |
| Original JPEG | The original image as a JPEG                                                                 |
| Thumbnail PNG | The original image as a 500x500 PNG. Used in the results page UI.                            |
| Skeleton PNG  | The original image as a 100x100 PNG. Used when loading larger images in the results page UI. |

## Widen Metadata

Some additional Widen metadata is captured and saved to the database on the "Add to Media Library" action. This plugin does not currently support syncing of meta data between Widen & WordPress.

### ID

```php
get_post_meta( $attachment_id, '_widen_media_id', true );
```
