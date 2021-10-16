<?php
require_once "config.php";

$limit = $_GET["limit"];
if (!$limit) {
    $limit = 25;
}

$strona = $_GET["strona"];
if (!$strona) {
    $strona = 1;
}


$kwerenda = "SELECT COUNT(*) as liczbaRecordow FROM faktury ORDER BY id";
$wynik = mysqli_query($conn, $kwerenda);
$dane = mysqli_fetch_assoc($wynik);
$liczbaRecordow = $dane['liczbaRecordow'];
$calkowitaLiczbaStron = ceil($liczbaRecordow / $limit)

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
                    <a class="nav-link active" aria-current="page" href="faktury.php">Faktury</a>
                    <a class="nav-link" aria-current="page" href="wyszukaj.php">Wyszukaj</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-light bg-gradient">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1>Lista faktur</h1>
                </div>
                <div class="col-auto">
                    <a href="dodaj.php" class="btn btn-primary">Dodaj fakture</a>
                </div>
            </div>
        </div>

        <div class='container'>
            <div class='row'>
                <div class='col-4'>
                    <div class='row align-items-center'>
                        <div class='col-auto'>Limit:</div>
                        <div class='col-auto'>
                            <a class='btn btn-primary mx-1<?php if ($limit == 10) echo " disabled" ?>'
                               href="faktury.php?limit=10<?php echo "&strona=" . $strona ?>">10</a>
                            <a class='btn btn-primary mx-1<?php if ($limit == 25) echo " disabled" ?>'
                               href="faktury.php?limit=25<?php echo "&strona=" . $strona ?>">25</a>
                            <a class='btn btn-primary mx-1<?php if ($limit == 50) echo " disabled" ?>'
                               href="faktury.php?limit=50<?php echo "&strona=" . $strona ?>">50</a>
                        </div>
                    </div>
                </div>
                <div class='col-4'>
                    <div class="row align-items-center">
                        <div class="col-auto">
                            Strona:
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-primary <?php if ($strona == 1) echo "disabled" ?>"
                               href="faktury.php?<?php echo "limit=" . $limit . "&strona=" . ($strona - 1) ?>"><=</a>
                            <?php
                            $poczatek = max(0, $strona - 3);
                            $koniec = min($poczatek + 5, $calkowitaLiczbaStron);

                            for ($iterator = $poczatek; $iterator < $koniec; $iterator++) {
                                $numerStrony = $iterator + 1;
                                if ($strona == $numerStrony) {
                                    $styl = "btn btn-primary disabled";
                                } else {
                                    $styl = "btn btn-primary";
                                }
                                echo "<a class=\"$styl\" href=\"faktury.php?limit=$limit&strona=$numerStrony\">$numerStrony</a>";
                            }
                            ?>
                            <a class="btn btn-primary <?php if ($calkowitaLiczbaStron < $strona + 1) echo "disabled" ?>"
                               href="faktury.php?<?php echo "limit=" . $limit . "&strona=" . ($strona + 1) ?>">=></a>
                        </div>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <div class="py-2">
                        <?php
                        $od = (($strona - 1) * $limit) + 1;
                        $do = $strona * $limit;
                        if ($do > $liczbaRecordow) {
                            $do = $liczbaRecordow;
                        }
                        ?>
                        <?php
                        echo "Wyświetlanie $od do $do z $liczbaRecordow"
                        ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="table-responsive">
                    <?php
                    $offset = $limit * ($strona - 1);
                    $kwerenda = "SELECT * FROM faktury LIMIT $limit OFFSET $offset";
                    $wynik = mysqli_query($conn, $kwerenda);

                    if (mysqli_num_rows($wynik) == 0) {
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

                        while ($rzad = mysqli_fetch_array($wynik)) {
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
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>