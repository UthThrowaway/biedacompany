<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
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
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <label for="data_wystawienia">Data wystawienia</label>
                        <input class="form-control <?php if ($blad_data_wystawienia) echo "is-invalid" ?>"
                               type="date" name="data_wystawienia" id="data_wystawienia" readonly
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
                                   value="<?php echo $nip_podatnika ?>" readonly
                                   placeholder="Wprowadź NIP podatnika">
                            <div class="invalid-feedback">Wpisz NIP podatnika</div>
                        </div>
                        <div>
                            <label for="nazwa_podatnika">Nazwa</label>
                            <input class="form-control <?php if ($blad_nazwa_podatnika) echo "is-invalid" ?>"
                                   type="text" name="nazwa_podatnika" id="nazwa_podatnika"
                                   value="<?php echo $nazwa_podatnika ?>" readonly
                                   placeholder="Wprowadź nazwę podatnika">
                            <div class="invalid-feedback">Wpisz nazwę podatnika</div>
                        </div>
                        <div>
                            <label for="ulica_podatnika">Ulica</label>
                            <input class="form-control <?php if ($blad_ulica_podatnika) echo "is-invalid" ?>"
                                   type="text" name="ulica_podatnika" id="ulica_podatnika"
                                   value="<?php echo $ulica_podatnika ?>" readonly
                                   placeholder="Wprowadź ulice podatnika">
                            <div class="invalid-feedback">Wpisz ulicę podatnika</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="kod_pocztowy_podatnika">Kod Pocztowy</label>
                                <input class="form-control <?php if ($blad_kod_pocztowy_podatnika) echo "is-invalid" ?>"
                                       type="text" name="kod_pocztowy_podatnika"
                                       id="kod_pocztowy_podatnika" readonly
                                       value="<?php echo $kod_pocztowy_podatnika ?>"
                                       placeholder="Wprowadź ulice podatnika">
                                <div class="invalid-feedback">Wpisz kod pocztowy podatnika</div>
                            </div>
                            <div class="col-8">
                                <label for="miasto_podatnika">Miasto</label>
                                <input class="form-control <?php if ($blad_miasto_podatnika) echo "is-invalid" ?>"
                                       type="text" name="miasto_podatnika"
                                       id="miasto_podatnika" readonly
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
                                   value="<?php echo $nip_nabywcy ?>" readonly
                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                   placeholder="Wprowadź NIP nabywcy">
                            <div class="invalid-feedback">Wpisz NIP nabywcy</div>
                        </div>
                        <div>
                            <label for="nazwa_nabywcy">Nazwa</label>
                            <input class="form-control <?php if ($blad_nazwa_nabywcy) echo "is-invalid" ?>"
                                   type="text" name="nazwa_nabywcy" id="nazwa_nabywcy"
                                   value="<?php echo $nazwa_nabywcy ?>" readonly
                                   placeholder="Wprowadź nazwę nabywcy">
                            <div class="invalid-feedback">Wpisz nazwę nabywcy</div>
                        </div>
                        <div>
                            <label for="ulica_nabywcy">Ulica</label>
                            <input class="form-control <?php if ($blad_ulica_nabywcy) echo "is-invalid" ?>"
                                   type="text" name="ulica_nabywcy" id="ulica_nabywcy"
                                   value="<?php echo $ulica_nabywcy ?>" readonly
                                   placeholder="Wprowadź ulice nabywcy">
                            <div class="invalid-feedback">Wpisz ulicę nabywcy</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="kod_pocztowy_nabywcy">Kod Pocztowy</label>
                                <input class="form-control <?php if ($blad_kod_pocztowy_nabywcy) echo "is-invalid" ?>"
                                       type="text" name="kod_pocztowy_nabywcy"
                                       id="kod_pocztowy_nabywcy" readonly
                                       value="<?php echo $kod_pocztowy_nabywcy ?>"
                                       placeholder="Wprowadź kod podatnika">
                                <div class="invalid-feedback">Wpisz kod pocztowy nabywcy</div>
                            </div>
                            <div class="col-8">
                                <label for="miasto_nabywcy">Miasto</label>
                                <input class="form-control <?php if ($blad_miasto_nabywcy) echo "is-invalid" ?>"
                                       type="text" name="miasto_nabywcy"
                                       id="miasto_nabywcy" readonly
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
                               type="text" name="produkt" id="produkt" readonly
                               value="<?php echo $produkt ?>">
                        <div class="invalid-feedback">Wpisz nazwę produktu</div>
                    </div>
                    <div class="col-2">
                        <label for="netto">Cena netto</label>
                        <input class="form-control <?php if ($blad_netto) echo "is-invalid" ?>"
                               type="text" name="netto" id="netto" readonly
                               onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                               value="<?php echo $netto ?>">
                        <div class="invalid-feedback">Wpisz cenę netto</div>
                    </div>
                    <div class="col-1">
                        <label for="ilosc">Ilość</label>
                        <input class="form-control <?php if ($blad_ilosc) echo "is-invalid" ?>"
                               type=text name="ilosc" id="ilosc" readonly
                               onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                               value="<?php echo $ilosc ?>">
                        <div class="invalid-feedback">Wpisz ilość</div>
                    </div>

                    <div class="col-1">
                        <label for="stawka">Stawka</label>
                        <select class="form-select" name="stawka" id="stawka" disabled>
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
    </div>
</div>


</body>
</html>