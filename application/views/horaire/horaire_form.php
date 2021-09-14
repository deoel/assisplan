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

        <h2 style="margin-top:0px">Horaire <?php echo $button ?></h2>
        <span class="text-danger"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></span>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="enum">Jour <?php echo form_error('jour') ?></label>
            <input type="text" class="form-control" name="jour" id="jour" placeholder="Jour" value="<?php echo $jour; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Quantième Heure <?php echo form_error('quantiemeheure') ?></label>
            <select class="form-control" name="quantiemeheure" id="quantiemeheure">
                <option value="1">1ère Heure</option>
                <option value="2">2e Heure</option>
                <option value="3">3e Heure</option>
                <option value="4">4e Heure</option>
                <option value="5">5e Heure</option>
                <option value="6">6e Heure</option>
                <option value="7">7e Heure</option>
                <option value="8">8e Heure</option>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Année de début <?php echo form_error('anneedebut') ?></label>
            <input type="text" class="form-control" name="anneedebut" id="anneedebut" placeholder="Anneedebut" value="<?php echo $anneedebut; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Année de fin <?php echo form_error('anneefin') ?></label>
            <input type="text" class="form-control" name="anneefin" id="anneefin" placeholder="Anneefin" value="<?php echo $anneefin; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Classe </label>
            <select class="form-control" name="classe_id" id="classe_id">
                <?php 
                    $classes = $this->Classe_model->get_all();
                    foreach ($classes as $c) {
                        echo '<option value="'.$c->id.'">'.$c->nom.'</option>';
                    }
                ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Cours <?php echo form_error('cours_id') ?></label>
            <select class="form-control" name="cours_id" id="cours_id">
                <?php 
                    $cours = $this->Cours_model->get_all();
                    foreach ($cours as $c) {
                        echo '<option value="'.$c->id.'">'.$c->intitule.'</option>';
                    }
                ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Enseignant Id <?php echo form_error('enseignant_id') ?></label>
            <select class="form-control" name="enseignant_id" id="enseignant_id">
                <?php 
                    $enseignants = $this->Enseignant_model->get_all();
                    foreach ($enseignants as $e) {
                        echo '<option value="'.$e->id.'">'.$e->nomcomplet.'</option>';
                    }
                ?>
            </select>
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('horaire') ?>" class="btn btn-default">Cancel</a>
	</form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>