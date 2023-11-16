<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Converter</title>
    <style>
        /* CSS untuk styling */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-image: url('b.webp');
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }

        h1 {
            font-size: 36px;
            color: #333;
        }

        label {
            font-size: 16px;
            margin-top: 20px;
            display: block;
        }

        input[type="file"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition-duration: 0.4s;
        }

        button:hover {
            background-color: #45a049;
        }

        #outputImage {
            max-width: 100%;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Image Converter</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="imageInput" accept="image/*">
            <br><br>
            <label for="quality">Kualitas Kompress (0-10):</label>
            <input type="number" name="quality" min="0" max="10" step="0.10" value="0.10">
            <br><br>
            <label for="width">Lebar Gambar (px):</label>
            <input type="number" name="width" placeholder="Masukkan lebar (opsional)">
            <br><br>
            <label for="outputFormat">Format Keluaran:</label>
            <select name="outputFormat">
                <option value="image/jpeg">JPEG</option>
                <option value="image/png">PNG</option>
                <option value="image/webp">WEBP</option>
            </select>
            <br><br>
            <button type="submit" name="convert">Convert</button>
        </form>

        <h2>Hasil Konversi:</h2>
        <img id="outputImage">

        <a id="downloadLink" style="display: none;">Unduh Gambar</a>

        <?php
        if (isset($_POST['convert'])) {
            $quality = isset($_POST['quality']) ? floatval($_POST['quality']) : 0.10;
            $width = isset($_POST['width']) ? intval($_POST['width']) : null;
            $outputFormat = $_POST['outputFormat'];

            if ($_FILES['imageInput']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['imageInput']['tmp_name'])) {
                $tempFile = $_FILES['imageInput']['tmp_name'];

                list($originalWidth, $originalHeight, $imageType) = getimagesize($tempFile);

                $img = imagecreatefromstring(file_get_contents($tempFile));

                if ($width) {
                    $newWidth = $width;
                    $newHeight = ($width / $originalWidth) * $originalHeight;
                } else {
                    $newWidth = $originalWidth;
                    $newHeight = $originalHeight;
                }

                $outputImg = imagescale($img, $newWidth, $newHeight);

                ob_start();

                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        imagejpeg($outputImg, null, $quality * 100);
                        break;
                    case IMAGETYPE_PNG:
                        imagepng($outputImg, null, round(9 - $quality));
                        break;
                    case IMAGETYPE_WEBP:
                        imagewebp($outputImg, null, $quality * 100);
                        break;
                }

                $outputImageData = ob_get_clean();

                imagedestroy($img);
                imagedestroy($outputImg);

                echo '<img id="outputImage" src="data:' . $outputFormat . ';base64,' . base64_encode($outputImageData) . '">';

                $downloadLink = 'data:' . $outputFormat . ';base64,' . base64_encode($outputImageData);
                echo '<br><br><a href="' . $downloadLink . '" download="converted_image.' . pathinfo($outputFormat, PATHINFO_EXTENSION) . '">Unduh Gambar</a>';
            } else {
                echo '<p>Terjadi kesalahan saat mengunggah file gambar.</p>';
            }
        }
        ?>
    </div>
</body>

</html>
