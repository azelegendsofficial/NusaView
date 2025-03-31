<?php
$target_dir = "uploads/";
$maxFileSize = 2 * 1024 * 1024 * 1024 * 1024; // 2TB dalam byte

// Pastikan direktori uploads ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Periksa apakah file adalah video
$allowedTypes = array("mp4", "avi", "mov", "wmv", "flv", "mkv");
if (!in_array($fileType, $allowedTypes)) {
    echo "Maaf, hanya format video yang diperbolehkan.";
    $uploadOk = 0;
}

// Periksa ukuran file
if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
    echo "Maaf, ukuran file melebihi 2TB.";
    $uploadOk = 0;
}

// Periksa apakah $uploadOk bernilai 0 karena kesalahan
if ($uploadOk == 0) {
    echo "Maaf, file Anda tidak dapat diunggah.";
// Jika semua baik, coba unggah file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $downloadLink = "https://nusa-view.vercel.app/" . $target_file;
        echo "File ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " telah diunggah.";
        echo "Tautan unduhan: <a href='$downloadLink'>$downloadLink</a>";
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
    }
}
?>
