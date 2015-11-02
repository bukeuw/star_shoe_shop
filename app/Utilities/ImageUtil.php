<?php

namespace App\Utilities;

use Storage;
use Illuminate\Http\Request;

trait ImageUtil
{
	/**
	 * Resize source to given size
	 * 
	 * @todo create general image format support
	 *       currently only support jpeg image format
	 * 
	 * @param  string $src_img the souce image
	 * @param  string $des_img the output filename
	 * @param  int $new_width      new image width
	 * @param  int $new_height     new image height
	 * @return void
	 */
	protected function resizeImage($src_img, $des_img, $new_width, $new_height) {
		list($src_width, $src_height) = getimagesize($src_img);

		$dest = imagecreatetruecolor($new_width, $new_height);
		$source = imagecreatefromjpeg($src_img);

		$dest_img = imagecopyresampled($dest, $source, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height);

		if ($dest_img) {
			// write output image
			imagejpeg($dest, $des_img);
		}
	}

	/**
	 * Scale the given image to size 900x1200 pixel
	 * note: source image must have size 3120 x 4160 pixel
	 * 
	 * @param  string $filename
	 * @return void
	 */
	protected function saveImage($filename) {
		$img_name = $filename . '_large.jpg';

		$this->resizeImage(
			$this->getTempPath() . $filename,
			$this->getUploadPath() . $img_name, 900, 1200);
	}

	/**
	 * Create the thumnail image from given image
	 * the output thumbnail has size 250x333 pixel
	 * note: source image must have size 3120 x 4160 pixel
	 * 
	 * @param  string $filename
	 * @return void
	 */
	protected function createThumbnailImage($filename) {
		$thumb_name = $filename . '_thumb.jpg';
		
		$this->resizeImage(
			$this->getTempPath(). $filename,
			$this->getUploadPath() . '/thumbnail/' . $thumb_name, 250, 333);
	}

	/**
	 * Get the temporary upload path
	 * 
	 * @return string
	 */
	protected function getTempPath()
	{
		return public_path('temp/');
	}

	/**
	 * Get the upload path
	 * 
	 * @return string
	 */
	protected function getUploadPath()
	{
		return public_path('data/products/');
	}

	/**
	 * Resize and upload image to server
	 * 
	 * @param  Illuminate\Http\Request $request
	 * @return void
	 */
	protected function handleUploadedImage(Request $request)
	{
		$img = $request->file('product_img');
        
        $img_name = $request->input('name');

        // $_SERVER['DOCUMENT_ROOT']
        // $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/data/products/';
        // $temp_path = $_SERVER['DOCUMENT_ROOT'] . '/temp/';

        if(!file_exists($this->getUploadPath() . $img_name . '_large.jpg')) {
            $img->move($this->getTempPath(), $img_name);

            $this->saveImage($img_name);
            $this->createThumbnailImage($img_name);

            // clear up the temporary file
            unlink(public_path('temp/') . $img_name);
        }
	}
}