<?php
if (!empty($_FILES['files']['name'][0])) {
    $files = $_FILES['files'];
    $uploaded = [];
    $errors = [];
    $allowedExtension = ['jpg', 'png', 'gif'];
    $uploadDir = 'assets/upload/';

    foreach ($files['name'] as $key => $file_name) {
        $file_size = $files['size'][$key];
        $file_ext = pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);
        $file_tmp = $files['tmp_name'][$key];
        $file_error = $files['error'][$key];

        if (in_array($file_ext, $allowedExtension)) {
            if (($file_size <= 1000000) && (0===$file_error)) {
                    move_uploaded_file($file_tmp, $uploadDir . uniqid('image') . '.' . $file_ext);

            } else {
                $errors['size'] = 'Le fichier ' . $file_name . ' est trop lourd.';
            }
        } else {
            $errors['ext'] = 'Les fichiers ' . $file_ext . ' ne sont pas autorisés';
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Upload files</title>
</head>
<body>
<h1 class="text-center">Upload your files !</h1>


<form action="index.php" method="post" enctype="multipart/form-data" class="text-center my-5">
    <div class="form-group">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <label for="files[]">Choisissez des images (jpg, gif, png)</label>
        <input type="file" name="files[]" multiple/>
        <input type="submit" value="Envoyer"/>
        <p class="text-danger"><?= $error['size'] ?? $error['ext'] ?? '' ?></p>

    </div>
</form>

<div class="row">
    <?php
    $uploadDir = 'assets/upload';
    $files = array_diff(scandir($uploadDir), ['..', '.']);
    foreach ($files as $file) : ?>
        <div class="card col-2">
            <img src="assets/upload/<?= $file ?>" alt="image <?= $file ?>" class="img-thumbnail">
            <div class="card-body border-0">
                <h5 class="card-title border-0"><?= $file ?></h5>
                <form action="delete.php" method="post">
                    <button type="submit" class="btn btn-primary" value="<?= $file ?>" name="file_name">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>