<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    $maxSizeFile = 1000000;
    $uploadDir = "uploads/";
    $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtension = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $newFileName = uniqid(basename($_FILES['avatar']['name']), $fileExtension);


    if ((!in_array($fileExtension, $authorizedExtension))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxSizeFile) {
        $errors[] = "Votre fichier doit faire moins de 1Mo !";
    }
    if (empty($errors)) {

        $filePath = $uploadDir . $newFileName;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath);
    }

    if (!isset($_POST['firstname']) || trim($_POST['firstname']) === '')
        $errors[] = 'Please enter a firstname';

    if (!isset($_POST['lastname']) || trim($_POST['lastname']) === '')
        $errors[] = 'Please enter a lastname';

    if (!isset($_POST['age']) || trim($_POST['age']) === '')
        $errors[] = 'Please enter your age';
        
}

?>

<?php 
    if (!empty($errors)){ ?>
        <ul>
            <?php foreach ($errors as $error){ ?>
            <li><?=$error?></li>
        <?php } 
    }
?>
<?php

    if (isset($filePath)){ ?>
        <p> Hi! <?= $_POST['firstname'] .'  ' . $_POST ['lastname'] . ', '?> welcome on FYL! <br> you have <?= $_POST['age'] . 'years'?>. u are goin to meet people who are here to find love have fun.<br>
        do you like ur pfp ? : <br> <img src= "<?=$filePath ?>" alt = "votre avatar"/>.
    <?php } ?>


<?php ?>

<form method="post" enctype="multipart/form-data">
    <label for="firstname"> firstname</label>
    <input type="text" name="firstname" />
    <label for="lastname"> lastname</label>
    <input type="text" name="lastname" />
    <label for="age"> age</label>
    <input type="int" name="age" />
    <label for="imageUpload">profil picture</label>
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
