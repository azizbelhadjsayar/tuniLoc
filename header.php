<?php 
include "./phpScripts/config.php";
if (session_status() === PHP_SESSION_NONE) session_start(); 
?>
<link rel="stylesheet" href="header.css">
<header>
    <div id="logoContainer"></div>
    <div id="searchContainer">
        <form action="explore.php" method="GET">
        <div class="input-group rounded">
            <input style="font-size: 18px; padding: 11px; border:none; border-radius: 20px 0px 0px 20px; background-color: rgb(208, 208, 208, 0.4)" id="searchInputField" name="titre" type="search" class="form-control" placeholder="Rechcercher un article" aria-label="Search" aria-describedby="search-addon" />
            <span style="background-color: rgb(208, 208, 208, 0.4); border-radius: 0px 20px 20px 0px;" class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
        </div>
        </form>
    </div>
    <div id="navigationContainer">
        <a href="">Comment ça fonctionne</a>
        <?php if (isset($_SESSION['id'])) { 
                    $resultpdp = $conn->query("SELECT photo_profil FROM utilisateurs where id = ".$_SESSION['id']);
                    if($resultpdp)$pdp = $resultpdp->fetch();
                    $locationsInbox = $conn->query("SELECT count(*) as nbRequests from locations WHERE statut='enattente' and proprietaire_id = ".$_SESSION['id']);
                    if($locationsInbox) $nbRequests = $locationsInbox->fetch();
                    ?>
        <a href="ajouterArticle.php">Publier un article</a>    
        <div id="profilenav" onclick="hidedisplayMenu(this)">
            <?php if($nbRequests['nbRequests']>0) echo "<div class='enAttenteAlert'></div>" ?>
            <div id="username"><?php echo $_SESSION['prenom'] ?></div>
            <div id="image" style="background-image:url('<?php echo $pdp['photo_profil']?>')"></div>
            <div id="nav" class="hiddenNav">
                <a id="boitereception" href="reception.php">Boite de reception <?php if($nbRequests['nbRequests']>0) echo "<div>{$nbRequests['nbRequests']}</div>" ?></a>
                <a href="meslocations.php">Location</a>
                <a href="explore.php?liked=<?php echo $_SESSION['id'];?>">Favoris</a>
                <a href="profile.php">Profil</a>
                <!-- <a href="profile.php">Mes articles</a> -->
                <a href="logout.php" style="color:red; border-top: 1px solid rgb(205, 205, 205); padding-top:10px;">Se déconnecter</a>
            </div>
        </div>
        <?php } else{ ?>
        <a href="login.php">Se connecter</a>
        <a href="register.php">S'inscrire</a>
        <?php }?>
    </div>
</header>
<script src="header.js"></script>