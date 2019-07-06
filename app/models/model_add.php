<?php
class Model_Add extends Model
{
	private static $sql_add_post = "INSERT INTO articles VALUES (NULL, :uid, :description, NOW(), 0)";

	public function create_article()
	{
		if (($result = $this->_auth()) !== Model::SUCCESS)
			return $result;
		if (!isset($_POST['description']))
			return Model::INCOMPLETE_DATA;
		if (!is_uploaded_file($_FILES['image_upload']['tmp_name']))
			return Model::UNUPLOADED_FILE;
		try
		{
			$id = $this->_insert_to_table();
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
		if (($result = $this->_insert_to_ftp($id)) === Model::SUCCESS)
			return Model::SUCCESS;
		else
			return $result;
	}

	private function _insert_to_table()
	{
		$arr = array(
			'uid' => $_SESSION['uid'],
			'description' => mb_strimwidth($_POST['description'], 0, 250)
		);
		try
		{
			include "config/database.php";
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Add::$sql_add_post);
			$stmt->execute($arr);
			$id = $pdo->lastInsertId();
			return $id;
		}
		catch (PDOException $ex)
		{
			throw $ex;
		}
	}

	private function _insert_to_ftp($id)
	{
		include "config/database.php";
		$type = exif_imagetype($_FILES['image_upload']['tmp_name']);
		switch ($type)
		{
			case IMAGETYPE_JPEG:
				$src_img = imagecreatefromjpeg($_FILES['image_upload']['tmp_name']);
				break;
			case IMAGETYPE_GIF:
				$src_img = imagecreatefromgif($_FILES['image_upload']['tmp_name']);
				break;
			case IMAGETYPE_PNG:
				$src_img = imagecreatefrompng($_FILES['image_upload']['tmp_name']);
				break;
			default:
				return Model::FORBIDDEN_FILETYPE;
		}
		$img = imagescale($src_img, 600, 600);
		if (imagejpeg($img, "ftp://$ftp_user:$ftp_pass@$ftp_host/photos/$id.jpg"))
			return Model::SUCCESS;
		else
			return Model::DB_ERROR;
	}

	/*
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
	*/
}