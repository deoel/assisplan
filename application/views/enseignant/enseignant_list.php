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

        <h2 style="margin-top:0px">Enseignant List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('enseignant/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('enseignant/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('enseignant'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nomcomplet</th>
		<th>Qualification</th>
		<th>Annee Début</th>
		<th>Ancienneté</th>
		<th>Charge horaire</th>
		<th>Action</th>
            </tr><?php
            $total_heures = 0;
            foreach ($enseignant_data as $enseignant)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $enseignant->nomcomplet ?></td>
			<td><?php echo $enseignant->qualification ?></td>
			<td><?php echo $enseignant->annee_debut ?></td>
			<td>
                <?php 
                    $a = date('Y') - $enseignant->annee_debut;
                    echo $a > 1 ? $a.' ans' : $a.' an'; 
                ?>
            </td>
			<td>
                <?php 
                    $tth = $this->Horaire_model->get_total_heure_enseignant($enseignant->id);
                    echo $tth.'H';
                    $total_heures += $tth; 
                ?>
            </td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('enseignant/update/'.$enseignant->id),'Update'); 
				echo ' | '; 
				echo anchor(site_url('enseignant/delete/'.$enseignant->id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
            <tr>
                <th colspan="5">TOTAL</th>
                <th><?php echo $total_heures; ?>H</th>
            </tr>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>