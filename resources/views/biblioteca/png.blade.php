<?php 

$imageFile = __DIR__.'/images/praia.png';

$watermarkFile = __DIR__. '/images/image.png';

$image = imagecreatefrompng($imageFile);

$watermark = imagecreatefrompng($watermarkFile);

imagecopy($image, $watermark,0,0,0,0,400,400);

header('Content-type image/png');

imagepng($image);

imagedestroy($image);
imagedestroy($watermark);

?>