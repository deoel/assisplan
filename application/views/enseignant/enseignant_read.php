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

        <h2 style="margin-top:0px">Enseignant Read</h2>
        <table class="table">
	    <tr><td>Nomcomplet</td><td><?php echo $nomcomplet; ?></td></tr>
	    <tr><td>Qualification</td><td><?php echo $qualification; ?></td></tr>
	    <tr><td>Annee Debut</td><td><?php echo $annee_debut; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('enseignant') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>