<?php
require_once "config.php";
$blad_data_wystawienia = $blad_nip_podatnika = $blad_nazwa_podatnika = $blad_ulica_podatnika = $blad_kod_pocztowy_podatnika =
$blad_miasto_podatnika = $blad_nip_nabywcy = $blad_nazwa_nabywcy = $blad_ulica_nabywcy = $blad_kod_pocztowy_nabywcy =
$blad_miasto_nabywcy = $blad_produkt = $blad_ilosc = $blad_stawka = $blad_netto = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_wystawienia = $_POST['data_wystawienia'];

    $nip_podatnika = $_POST['nip_podatnika'];
    $nazwa_podatnika = $_POST['nazwa_podatnika'];
    $ulica_podatnika = $_POST['ulica_podatnika'];
    $miasto_podatnika = $_POST['miasto_podatnika'];
    $kod_pocztowy_podatnika = $_POST['kod_pocztowy_podatnika'];

    $nip_nabywcy = $_POST['kod_pocztowy_nabywcy'];
    $nazwa_nabywcy = $_POST['nazwa_nabywcy'];
    $ulica_nabywcy = $_POST['ulica_nabywcy'];
    $miasto_nabywcy = $_POST['miasto_nabywcy'];
    $kod_pocztowy_nabywcy = $_POST['kod_pocztowy_nabywcy'];

    $produkt = $_POST['produkt'];
    $netto = $_POST['netto'];
    $ilosc = $_POST['ilosc'];
    $stawka = $_POST['stawka'];

    if (!$data_wystawienia) {
        $blad_data_wystawienia = true;
    }

    if (!$nip_podatnika) {
        $blad_nip_podatnika = true;
    }

    if (!$nazwa_podatnika) {
        $blad_nazwa_podatnika = true;
    }

    if (!$miasto_podatnika) {
        $blad_ulica_podatnika = true;
    }

    if (!$kod_pocztowy_podatnika) {
        $blad_kod_pocztowy_podatnika = true;
    }

    if (!$miasto_podatnika) {
        $blad_miasto_podatnika = true;
    }

//////////////////////////////////////////

    if (!$nip_nabywcy) {
        $blad_nip_nabywcy = true;
    }

    if (!$nazwa_nabywcy) {
        $blad_nazwa_nabywcy = true;
    }

    if (!$ulica_nabywcy) {
        $blad_ulica_nabywcy = true;
    }

    if (!$kod_pocztowy_nabywcy) {
        $blad_kod_pocztowy_nabywcy = true;
    }

    if (!$miasto_nabywcy) {
        $blad_miasto_nabywcy = true;
    }

////////////////////////////////////////

    if (!$produkt) {
        $blad_produkt = true;
    }

    if (!$netto) {
        $blad_netto = true;
    }

    if (!$ilosc) {
        $blad_ilosc = true;
    }

    if (!$stawka) {
        $blad_stawka = true;
    }


    if (!$blad_data_wystawienia && !$blad_nip_podatnika && !$blad_nazwa_podatnika &&
        !$blad_ulica_podatnika && !$blad_kod_pocztowy_podatnika && !$blad_miasto_podatnika &&
        !$blad_nip_nabywcy && !$blad_nazwa_nabywcy && !$blad_ulica_nabywcy &&
        !$blad_kod_pocztowy_nabywcy && !$blad_miasto_nabywcy && !$blad_produkt &&
        !$blad_netto && !$blad_ilosc && !$blad_stawka) {

        $podatek = ($netto * $ilosc) * ($stawka / 100);
        $brutto = ($netto * $ilosc) + $podatek;

        $sql = "INSERT INTO faktury(data, nip_podatnika, nazwa_podatnika, ulica_podatnika, kod_pocztowy_podatnika,
                    miasto_podatnika, nip_nabywcy, nazwa_nabywcy, ulica_nabywcy, kod_pocztowy_nabywcy,
                    miasto_nabywcy, produkt, netto, ilosc, stawka, podatek, brutto) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssssssssssdiidd", $data_wystawienia, $nip_podatnika, $nazwa_podatnika,
                $ulica_podatnika, $kod_pocztowy_podatnika, $miasto_podatnika, $nip_nabywcy, $nazwa_nabywcy,
                $ulica_nabywcy, $kod_pocztowy_nabywcy, $miasto_nabywcy, $produkt, $netto, $ilosc, $stawka, $podatek, $brutto);
            if (mysqli_stmt_execute($stmt)) {
                header("location: faktury.php");
                exit();
            } else {
                header("location: blad.php");
                exit();
            }
        }
    }


} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $sql = "SELECT * FROM faktury WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        echo "<div>No data</div>";
    } else {
        $row = mysqli_fetch_array($result);

        $numer_faktury = $row['id'];
        $podatek = $row['podatek'];
        $brutto = $row['brutto'];

        $data_wystawienia = $row['data'];

        $nip_podatnika = $row['nip_podatnika'];
        $nazwa_podatnika = $row['nazwa_podatnika'];
        $ulica_podatnika = $row['ulica_podatnika'];
        $miasto_podatnika = $row['miasto_podatnika'];
        $kod_pocztowy_podatnika = $row['kod_pocztowy_podatnika'];

        $nip_nabywcy = $row['kod_pocztowy_nabywcy'];
        $nazwa_nabywcy = $row['nazwa_nabywcy'];
        $ulica_nabywcy = $row['ulica_nabywcy'];
        $miasto_nabywcy = $row['miasto_nabywcy'];
        $kod_pocztowy_nabywcy = $row['kod_pocztowy_nabywcy'];

        $produkt = $row['produkt'];
        $netto = $row['netto'];
        $ilosc = $row['ilosc'];
        $stawka = $row['stawka'];
    }
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
        <form action="edytuj.php" method="post">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h1>Edytuj fakture</h1>
                    </div>
                    <div class="col-6">
                        <input class="btn btn-primary" type="submit" value="Edytuj">
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <label for="data_wystawienia">Data wystawienia</label>
                        <input class="form-control <?php if ($blad_data_wystawienia) echo "is-invalid" ?>"
                               type="date" name="data_wystawienia" id="data_wystawienia"
                               value="<?php echo $data_wystawienia ?>">
                        <div class="invalid-feedback">Wprowadz date</div>
                    </div>
                    <div class="col-6">
                        <label>Numer faktury</label>
                        <input class="form-control" readonly type="text" placeholder="Autogenerowane"
                            <?php if($numer_faktury) echo "value='$numer_faktury'" ?>
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h2>Podatnik</h2>
                        <div>
                            <label for="nip_podatnika">NIP</label>
                            <input class="form-control <?php if ($blad_nip_podatnika) echo "is-invalid" ?>"
                                   type="text" name="nip_podatnika" id="nip_podatnika"
                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                   value="<?php echo $nip_podatnika ?>"
                                   placeholder="Wprowadź NIP podatnika">
                            <div class="invalid-feedback">Wpisz NIP podatnika</div>
                        </div>
                        <div>
                            <label for="nazwa_podatnika">Nazwa</label>
                            <input class="form-control <?php if ($blad_nazwa_podatnika) echo "is-invalid" ?>"
                                   type="text" name="nazwa_podatnika" id="nazwa_podatnika"
                                   value="<?php echo $nazwa_podatnika ?>"
                                   placeholder="Wprowadź nazwę podatnika">
                            <div class="invalid-feedback">Wpisz nazwę podatnika</div>
                        </div>
                        <div>
                            <label for="ulica_podatnika">Ulica</label>
                            <input class="form-control <?php if ($blad_ulica_podatnika) echo "is-invalid" ?>"
                                   type="text" name="ulica_podatnika" id="ulica_podatnika"
                                   value="<?php echo $ulica_podatnika ?>"
                                   placeholder="Wprowadź ulice podatnika">
                            <div class="invalid-feedback">Wpisz ulicę podatnika</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="kod_pocztowy_podatnika">Kod Pocztowy</label>
                                <input class="form-control <?php if ($blad_kod_pocztowy_podatnika) echo "is-invalid" ?>"
                                       type="text" name="kod_pocztowy_podatnika"
                                       id="kod_pocztowy_podatnika"
                                       value="<?php echo $kod_pocztowy_podatnika ?>"
                                       placeholder="Wprowadź ulice podatnika">
                                <div class="invalid-feedback">Wpisz kod pocztowy podatnika</div>
                            </div>
                            <div class="col-8">
                                <label for="miasto_podatnika">Miasto</label>
                                <input class="form-control <?php if ($blad_miasto_podatnika) echo "is-invalid" ?>"
                                       type="text" name="miasto_podatnika"
                                       id="miasto_podatnika"
                                       value="<?php echo $miasto_podatnika ?>"
                                       placeholder="Wprowadź ulice podatnika">
                                <div class="invalid-feedback">Wpisz miasto podatnika</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <h2>Nabywca</h2>
                        <div>
                            <label for="nip_nabywcy">NIP</label>
                            <input class="form-control <?php if ($blad_nip_nabywcy) echo "is-invalid" ?>"
                                   type="text" name="nip_nabywcy" id="nip_nabywcy"
                                   value="<?php echo $nip_nabywcy ?>"
                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                   placeholder="Wprowadź NIP nabywcy">
                            <div class="invalid-feedback">Wpisz NIP nabywcy</div>
                        </div>
                        <div>
                            <label for="nazwa_nabywcy">Nazwa</label>
                            <input class="form-control <?php if ($blad_nazwa_nabywcy) echo "is-invalid" ?>"
                                   type="text" name="nazwa_nabywcy" id="nazwa_nabywcy"
                                   value="<?php echo $nazwa_nabywcy ?>"
                                   placeholder="Wprowadź nazwę nabywcy">
                            <div class="invalid-feedback">Wpisz nazwę nabywcy</div>
                        </div>
                        <div>
                            <label for="ulica_nabywcy">Ulica</label>
                            <input class="form-control <?php if ($blad_ulica_nabywcy) echo "is-invalid" ?>"
                                   type="text" name="ulica_nabywcy" id="ulica_nabywcy"
                                   value="<?php echo $ulica_nabywcy ?>"
                                   placeholder="Wprowadź ulice nabywcy">
                            <div class="invalid-feedback">Wpisz ulicę nabywcy</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="kod_pocztowy_nabywcy">Kod Pocztowy</label>
                                <input class="form-control <?php if ($blad_kod_pocztowy_nabywcy) echo "is-invalid" ?>"
                                       type="text" name="kod_pocztowy_nabywcy"
                                       id="kod_pocztowy_nabywcy"
                                       value="<?php echo $kod_pocztowy_nabywcy ?>"
                                       placeholder="Wprowadź kod podatnika">
                                <div class="invalid-feedback">Wpisz kod pocztowy nabywcy</div>
                            </div>
                            <div class="col-8">
                                <label for="miasto_nabywcy">Miasto</label>
                                <input class="form-control <?php if ($blad_miasto_nabywcy) echo "is-invalid" ?>"
                                       type="text" name="miasto_nabywcy"
                                       id="miasto_nabywcy"
                                       value="<?php echo $miasto_nabywcy ?>"
                                       placeholder="Wprowadź ulice nabywcy">
                                <div class="invalid-feedback">Wpisz miasto nabywcy</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2>Dane</h2>
                <div class="row">
                    <div class="col-4">
                        <label for="produkt">Produkt</label>
                        <input class="form-control <?php if ($blad_produkt) echo "is-invalid" ?>"
                               type="text" name="produkt" id="produkt"
                               value="<?php echo $produkt ?>">
                        <div class="invalid-feedback">Wpisz nazwę produktu</div>
                    </div>
                    <div class="col-2">
                        <label for="netto">Cena netto</label>
                        <input class="form-control <?php if ($blad_netto) echo "is-invalid" ?>"
                               type="text" name="netto" id="netto"
                               onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                               value="<?php echo $netto ?>">
                        <div class="invalid-feedback">Wpisz cenę netto</div>
                    </div>
                    <div class="col-1">
                        <label for="ilosc">Ilość</label>
                        <input class="form-control <?php if ($blad_ilosc) echo "is-invalid" ?>"
                               type=text name="ilosc" id="ilosc"
                               onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                               value="<?php echo $ilosc ?>">
                        <div class="invalid-feedback">Wpisz ilość</div>
                    </div>

                    <div class="col-1">
                        <label for="stawka">Stawka</label>
                        <select class="form-select" name="stawka" id="stawka">
                            <option value="5" <?php if ($stawka == 5) echo "selected" ?>>5%</option>
                            <option value="12" <?php if ($stawka == 12) echo "selected" ?>>12%</option>
                            <option value="23" <?php if ($stawka == 23) echo "selected" ?>>23%</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label>Podatek</label>
                        <input class="form-control" type="text" placeholder="Autogenerowane" readonly
                            <?php if($podatek) echo "value='$podatek'" ?>
                        >
                    </div>
                    <div class="col-2">
                        <label>Cena brutto</label>
                        <input class="form-control" readonly type="text" placeholder="Autogenerowane"
                            <?php if($brutto) echo "value='$brutto'" ?>>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


</body>
</html>