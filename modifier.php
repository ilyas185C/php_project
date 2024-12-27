<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit();
    }
    include "connection.php";

    // Process form if submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $reference = $_POST['reference'];
        $libelle = $_POST['libelle'];
        $prixu = $_POST['prixu'];
        $datea = $_POST['datea'];
        $idCategorie = $_POST['cat'];

        $sql = "UPDATE produit SET libelle=:libelle, prixUnitaire=:prixu, dateAchat=:datea, idCategorie=:idCategorie WHERE reference=:reference";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':reference', $reference);
        $stm->bindParam(':libelle', $libelle);
        $stm->bindParam(':prixu', $prixu);
        $stm->bindParam(':datea', $datea);
        $stm->bindParam(':idCategorie', $idCategorie);
        $stm->execute();

        header('Location: dashboard.php');
        exit();
    }

    // Fetch categories
    $sql = "SELECT * FROM Categorie";
    $stm = $conn->query($sql);
    $categories = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Fetch product details
    $reference = $_GET['reference'];
    $sql1 = "SELECT * FROM Produit WHERE reference = :reference";
    $stm1 = $conn->prepare($sql1);
    $stm1->bindParam(':reference', $reference);
    $stm1->execute();
    $produit = $stm1->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
</head>
<body>
<?php include "header.php"; ?>
    <form action="modifier.php" method="post">
        <h1>Modifier Produit</h1>
        <input type="hidden" name="reference" value="<?php echo $produit['reference']; ?>">
        <label for="libelle">Libelle</label><br>
        <input type="text" name="libelle" id="libelle" value="<?php echo $produit['libelle']; ?>"><br>
        <label for="prixu">Prix Unitaire</label><br>
        <input type="text" name="prixu" id="prixu" value="<?php echo $produit['prixUnitaire']; ?>"><br>
        <label for="datea">Date Achat</label><br>
        <input type="text" name="datea" id="datea" value="<?php echo $produit['dateAchat']; ?>"><br>
        <label for="cat">Categorie</label><br>
        <select name="cat" id="cat">
            <?php foreach ($categories as $categorie) { ?>
                <option value="<?php echo $categorie['idCategorie']; ?>" <?php if ($produit['idCategorie'] == $categorie['idCategorie']) { echo "selected"; } ?>>
                    <?php echo $categorie['denomination']; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>
