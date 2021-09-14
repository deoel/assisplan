<!doctype html>
<html>
    <head>
        <title>AssisPlan</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#"><h1>AssisPlan</h1></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                           <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('classe');?>">Classe</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('cours');?>">Cours</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('enseignant');?>">Enseignant</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Horaires
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo site_url('horaire');?>">Planification horaire</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo site_url('horaire/par_classe');?>">Horaire par classe</a>
                                    <a class="dropdown-item" href="<?php echo site_url('horaire/par_enseignant');?>">Horaire par enseignant</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <h2 style="margin-top:0px">Horaire par Enseignant</h2>

        <?php 
            foreach ($tab_horaires_enseignants as $nom_enseignant => $horaire_classe) {
                echo '
                <table class="table table-bordered" style="margin-bottom: 10px">
                    <tr>
                        <th class="text-center" colspan="7">'.$nom_enseignant.'</th>
                    </tr>
                    <tr>
                        <th>Heures</th>
                        <th>LUNDI</th>
                        <th>MARDI</th>
                        <th>MERCREDI</th>
                        <th>JEUDI</th>
                        <th>VENDREDI</th>
                        <th>SAMEDI</th>
                    </tr>';

                    foreach ($horaire_classe as $heure => $ligne_horaire) {
                        echo '
                        <tr>
                            <td>'.$heure.'e H</td>
                            <td>'.$ligne_horaire['lundi'].'</td>
                            <td>'.$ligne_horaire['mardi'].'</td>
                            <td>'.$ligne_horaire['mercredi'].'</td>
                            <td>'.$ligne_horaire['jeudi'].'</td>
                            <td>'.$ligne_horaire['vendredi'].'</td>
                            <td>'.$ligne_horaire['samedi'].'</td>
                        </tr>
                        ';
                    }
                    
                echo '
                </table>
                ';
            }
        ?>

        
        
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>