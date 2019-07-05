<?php
class Model_Add extends Model
{
	public function put_file()
	{
		if (!is_uploaded_file($_FILES['image_upload']['tmp_name']))
			return Model::UNUPLOADED_FILE;
		$type = exif_imagetype($_FILES['image_upload']['tmp_name']);
		if ($type !== IMAGETYPE_JPEG and
			$type !== IMAGETYPE_GIF and
			$type !== IMAGETYPE_PNG)
			return Model::FORBIDDEN_FILETYPE;
		$old_img = imagecreatefromjpeg($_FILES['image_upload']['tmp_name']);
		$new_img = imagescale($old_img, 600, 600);
		$res = imagejpeg($new_img, "ftp://admin:admin@172.17.0.3/jj.jpg");
		return Model::SUCCESS;
	}
}