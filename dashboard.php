<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}
include 'connection.php';
$login=$_SESSION['login'];
$sql="SELECT * FROM CompteProprietaire where loginProp='$login'";
$stm=$conn->query($sql);
$compte=$stm->fetch(PDO::FETCH_ASSOC);
$hour=date('H');

$sql1 = "SELECT * FROM Produit INNER JOIN Categorie ON Produit.idCategorie = Categorie.idCategorie ORDER BY libelle";
$stm1=$conn->query($sql1);
$produits=$stm1->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "header.php"; ?>
    <?php 
        if($hour<18 && $hour>6){
            echo '<h1>Bonjour '. $compte['prenom'].' '.$compte['nom'].'</h1>';
        }else{
            echo '<h1>Bonsoir '. $compte['prenom'].' '.$compte['nom'].'</h1>';
        }
    ?>

    <H2>Produits</H2>
    <table border="1px">
        <tr>
            <th>Reference</th>
            <th>libelle</th>
            <th>Prix Unitaire</th>
            <th>Date Achat</th>
            <th>Photo produit</th>
            <th>categorie</th>
            <th>action</th>
        </tr>
    
    <?php foreach( $produits as $produit){?>
        <tr>
            <td><?php echo $produit['reference']; ?></td>
            <td><?php echo $produit['libelle']; ?></td> 
            <td><?php echo $produit['prixUnitaire']; ?></td>
            <td><?php echo $produit['dateAchat']; ?></td>
            <td><img src="<?php echo $produit['photoProduit']; ?>" width="100px" height="100px"></td>
            <td><?php echo $produit['denomination']; ?></td>
            <td>
                <button><a href="modifier.php?reference=<?php echo $produit['reference']; ?>">modifier</a></button>
                <button><a href="delete.php?reference=<?php echo $produit['reference']; ?>"
                onclick="return confirm('do you want delete this product?')"
                >delete</a></button>
            </td>
        </tr>
    <?php }?>
</table>
</body>
</html>