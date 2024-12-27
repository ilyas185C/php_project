<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit();
    }
    include "connection.php";
    $sql="SELECT * FROM Categorie";
    $stm=$conn->query($sql);
    $categories=$stm->fetchAll(PDO::FETCH_ASSOC);
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
    <form action="ajouter.php" method="post" enctype="multipart/form-data">
        <h1>Ajouter Produit</h1>
        <table>
            <tr>
                <td>
                    Libelle<br>
                    <input type="text" name="libelle" required>
                </td>
                <td>
                    Prix Unitaire <br>
                    <input type="text" name="prixu" id="" required>
                </td>
            </tr>
            <tr>
                <td>
                    Date Achat<br>
                    <input type="date" name="datea" required>
                </td>
                <td>
                    Photo Produit <br>
                    <input type='file' name="photo" id="" required>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Categorie<br>
                    <select name="categorie" required>
                        <?php foreach($categories as $categorie){?>
                            <option value="<?php echo $categorie['idCategorie'] ?>"><?php echo $categorie['denomination'] ?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $libelle = $_POST['libelle'];
        $prixu = $_POST['prixu'];
        $datea = $_POST['datea'];
        $categorie = $_POST['categorie'];
        if (isset($_FILES['photo'])) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $sql="INSERT INTO Produit(libelle, prixUnitaire, dateAchat, photoProduit, idCategorie) VALUES (:libelle, :prixu, :datea, :target_file, :idcategorie)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':libelle', $libelle);
                $stmt->bindParam(':prixu', $prixu);
                $stmt->bindParam(':datea', $datea);
                $stmt->bindParam(':target_file', $target_file);
                $stmt->bindParam(':idcategorie', $categorie);
                $stmt->execute();
                header('location:dashboard.php');
                exit();
            }else {
                echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
            }
        } else {
            echo "Aucun fichier n'a été téléchargé ou une erreur est survenue lors du téléchargement.";
        }
        }

?>