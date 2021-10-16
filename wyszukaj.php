<?php
require_once "config.php";
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
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link" aria-current="page" href="faktury.php">Faktury</a>
                    <a class="nav-link active" aria-current="page" href="wyszukaj.php">Wyszukaj</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-light bg-gradient">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $query = "SELECT * FROM faktury ";

            $nip_podatnika = $_POST['nip_podatnika'];
            $nazwa_podatnika = $_POST['nazwa_podatnika'];
            $miasto_podatnika = $_POST['miasto_podatnika'];

            $nip_nabywcy = $_POST['nip_nabywcy'];
            $nazwa_nabywcy = $_POST['nazwa_nabywcy'];
            $miasto_nabywcy = $_POST['miasto_nabywcy'];


            if ($nip_podatnika || $nazwa_podatnika || $miasto_podatnika ||
                $nip_nabywcy || $nazwa_nabywcy || $miasto_nabywcy) {

                $query .= "WHERE ";

                $ar = array();
                if ($nip_podatnika) {
                    $ar[] = "nip_podatnika = $nip_podatnika";
                }
                if ($nazwa_podatnika) {
                    $ar[] = "nazwa_podatnika = '$nazwa_podatnika'";
                }
                if ($miasto_podatnika) {
                    $ar[] = "miasto_podatnika = '$miasto_podatnika'";
                }

                if ($nip_nabywcy) {
                    $ar[] = "nip_nabywcy = $nip_nabywcy";
                }
                if ($nazwa_nabywcy) {
                    $ar[] = "nazwa_nabywcy = '$nazwa_nabywcy'";
                }
                if ($miasto_nabywcy) {
                    $ar[] = "miasto_nabywcy = '$miasto_nabywcy'";
                }

                $query .= implode(" AND ", $ar);
                $query .= " ORDER BY id";

            }

            $result = mysqli_query($conn, $query);

            echo '<div class="table-responsive">';
            if (mysqli_num_rows($result) == 0) {
                echo "<div>No data</div>";
            } else {
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>#</th>";
                echo "<th class='col-3' scope='col'>Podatnik</th>";
                echo "<th class='col-3' scope='col'>Nabywca</th>";
                echo "<th scope='col'>Data</th>";
                echo "<th scope='col'>Netto</th>";
                echo "<th scope='col'>Brutto</th>";
                echo "<th scope='col'>Akcje</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($rzad = mysqli_fetch_array($result)) {
                    $id = $rzad['id'];
                    echo "<tr>
                        <th scope = 'row' >" . $rzad['id'] . "</th scope = 'row' >
                        <td>" . $rzad['nazwa_podatnika'] . "</td >
                        <td>" . $rzad['nazwa_nabywcy'] . "</td >
                        <td>" . $rzad['data'] . "</td >
                        <td>" . number_format((float)$rzad['netto'], 2, '.', '') . "</td >
                        <td>" . number_format((float)$rzad['brutto'], 2, '.', '') . "</td >
                        <td>
                            <a class='text-decoration-none btn-sm btn-success' href='wyswietl.php?id=$id'>Wyświetl</a>
                            <a class='text-decoration-none btn-sm btn-warning' href='edytuj.php?id=$id'>Edytuj</a>
                            <a class='text-decoration-none btn-sm btn-danger' href='usun.php?id=$id'>Usuń</a>
                            </a>
                        </td >
                    </tr >";
                }
            }
            echo "</tbody>";
            echo "</table>";

            echo '</div>';


        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            echo '
    <form action="wyszukaj.php" method="post">
        <div class="container">
        <h1>Wyszukaj fakturę</h1>
            <div class="row">
                    <div class="col-6">
                        <h2>Podatnik</h2>
                        <div class="col-12">
                            <label for="nip_podatnika">NIP</label>
                            <input class="form-control" type="text" name="nip_podatnika" id="nip_podatnika"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                                placeholder="Nip podatnika"   
                            >
                        </div>
                        <div class="col-12">
                            <label for="nazwa_podatnika">Nazwa</label>
                            <input class="form-control" type="text" name="nazwa_podatnika" id="nazwa_podatnika" 
                                placeholder="Nazwa podatnika">
                        </div>
                        <div class="col-12">
                            <label for="miasto_podatnika">Miasto</label>
                            <input class="form-control" type="text" name="miasto_podatnika" id="miasto_podatnika"
                                placeholder="Miasto podatnika">
                        </div>        
                    </div>

                    <div class="col-6">
                        <h2>Nabywca</h2>
                        <div class="col-12">
                            <label for="nip_nabywcy">NIP</label>
                            <input class="form-control" type="text" name="nip_nabywcy" id="nip_nabywcy"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                placeholder="Nip nabywcy"
                            >
                        </div>
                        <div class="col-12">
                            <label for="nazwa_nabywcy">Nazwa</label>
                            <input class="form-control" type="text" name="nazwa_nabywcy" id="nazwa_nabywcy"
                                placeholder="Nazwa nabywcy">
                        </div>
                        <div class="col-12">
                            <label for="miasto_nabywcy">Miasto</label>
                            <input class="form-control" type="text" name="miasto_nabywcy" id="miasto_nabywcy"
                                placeholder="Miasto nabywcy">
                        </div>        
                        </div>
                </div>        
            <input class="btn btn-primary my-2" type="submit" value="Wyszukaj">
            </div>
    </form>';
        }
        ?>


    </div>
</div>
</body>
</html>

