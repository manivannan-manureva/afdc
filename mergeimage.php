<?php

function generateFinalImage($config) {
    //test
    if (isset($config['hd_image_url']) && filter_var($config['hd_image_url'], FILTER_VALIDATE_URL)) {
        $imageData = file_get_contents($config['hd_image_url']);
        //echo '----' . __LINE__ . '----' . __FILE__ . $imageData;
        //echo '----' . __LINE__ . '----' . __FILE__ . '<pre>' . print_r($config, true) . '</pre>';
        $tmpFileName = 'tmp_image.jpg';
        file_put_contents($tmpFileName, $imageData);
        //$size = 200;
        $im = imagecreatefromjpeg($tmpFileName);
        imagealphablending($im, true);
        $transparentcolour = imagecolorallocate($im, 255, 255, 255);
        imagecolortransparent($im, $transparentcolour);
        //$size = min(imagesx($im), imagesy($im));
        //$size = 200;
        /* Start : Crop Image */
        $im = imagecrop($im, ['x' => $config['crop_x'], 'y' => $config['crop_y'], 'width' => $config['width'], 'height' => $config['height']]);
        /* Stop : Crop Image */

        /* Start : Rotate Image */
        $im = imagerotate($im, $config['rotate_degree'], 0);
        /* Stop : Rotate Image */

        if ($config['mirror_effect']) {
            /* Start : Flip Image (Mirror effect) */
            imageflip($im, IMG_FLIP_HORIZONTAL);
            /* Stop : Flip Image (Mirror effect) */
        }

        if (isset($config['stripe_filename']) && trim($config['stripe_filename']) != '') {
            /* Start : Merge Stripe */
            $sim = imagecreatefrompng($config['stripe_filename']);
            imagecopyresampled($im, $sim, $config['crop_x'], $config['crop_y'], 0, 0, $config['width'], $config['height'], $config['width'], $config['height']);
            /* Stop : Merge Stripe */
        }

        //generate final output image
        if ($im !== FALSE) {
            imagepng($im, $config['output_filename']);
            return $config['output_filename'];
        }
        return false;
    } else {
        die('ivalid image url');
    }
}

$options = array();
//$options['hd_image_url'] = 'http://localhost/afdc/wallpapper.jpg';
//$options['hd_image_url'] = 'http://www.wallpapereast.com/static/images/HD-Wallpaper-D5D.jpg';
$options['hd_image_url'] = 'https://s-media-cache-ak0.pinimg.com/originals/32/11/13/32111359bc45a65b510d52506941f54d.jpg';
$options['crop_x'] = 0;
$options['crop_y'] = 0;
$options['width'] = 500;
$options['height'] = 500;
$options['rotate_degree'] = 90;
$options['mirror_effect'] = TRUE;
$options['stripe_filename'] = 'stripe.png';
$options['output_filename'] = 'ex-cropped.png';
$outputFile = generateFinalImage($options);
?>
<p>Source Image</p>
<img src="<?php echo $options['hd_image_url']; ?>"/>
<p>Final Image</p>
<img src="/afdc/<?php echo $outputFile; ?>"/>