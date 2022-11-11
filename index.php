<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="file" name="file[]" value="" multiple>
        <br><br><br>
        <input type="submit" name="submit" value="Upload">
    </form>
</body>

</html>
<?php
$isUploaded = false;
if (isset($_POST["submit"])) {
    $filesCount = count($_FILES["file"]["name"]);
    for ($i = 0; $i < $filesCount; $i++) {
        $file_name = $_FILES["file"]["name"][$i];
        $file_tem = $_FILES["file"]["tmp_name"][$i];
        $file_size = $_FILES["file"]['size'][$i];
        $file_type = $_FILES["file"]['type'][$i];

        // We can replace this file blocked extensions with allowed extensions
        $blocked_extensions = array('exe', 'msi', 'php', 'dll');
        $allowed_mimes = array('image/jpeg', 'image/gif', 'image/png');
        $file_name_splitted = explode('.', $file_name);
        $file_ex = end($file_name_splitted);
        $mimetype = mime_content_type($file_tem);

        // Here also we can should do a validation on the file size and other things also
        if (!in_array($file_ex, $blocked_extensions) && in_array($mimetype, $allowed_mimes)) {
            $file_ex = strtolower($file_ex);
            $newFileName = rand(100000, 900000) . '.' . $file_ex;
            $target = "uploadedFiles/" . $newFileName;
            $upload = move_uploaded_file($file_tem, $target);
            $isUploaded = true;
        } else {
            die("Blocked File Type");
        }
    }
    if ($isUploaded) {
        die("Upload successfully");
    } else {
        die("Upload unsuccessfully");
    }
} else {
    die("There is no file to upload.");
}
?>