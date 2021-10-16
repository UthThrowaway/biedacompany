<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM faktury WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn)){
        header("location: faktury.php");
    } else {
        header("location: blad.php");
    }

} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>BiedaCompany</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"
            integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">BiedaCompany</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                    <a class="nav-link active" aria-current="page" href="faktury.php">Faktury</a>
                    <a class="nav-link" aria-current="page" href="wyszukaj.php">Wyszukaj</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-light bg-gradient">
        <form action="usun.php" method="post">
            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
            <div class="container">
                <div class="align-middle py-4">
                    <h4 class="text-center">
                        Czy napewno chcesz usunąć fakturę? Tej operacji nie można cofnąć.
                    </h4>
                    <div class="py-2 row justify-content-center">
                        <div class="col-2">
                            <input class="px-4 btn btn-primary" type="button" onclick="history.back();" value="Zaniechaj">
                        </div>
                        <div class="col-2">
                            <input class="px-4 btn btn-danger" type="submit" value="Usuń">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>


