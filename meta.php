<?php
echo "<pre>";
$tags = exif_read_data('media/image/IMG_0069.CR2');

var_dump($tags);