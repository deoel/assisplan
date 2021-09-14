<?php

if ( !defined( 'BASEPATH' ) )
exit( 'No direct script access allowed' );

class Horaire extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model( 'Horaire_model' );
        $this->load->library( 'form_validation' );
    }

    public function par_classe() {
        $classes = $this->Classe_model->get_all();

        $tab_horaires_classes = array();
        foreach ($classes as $classe) {
            $tab_horaires_classes[$classe->nom] = array();
            for ($h=1; $h < 9; $h++) { 
                $ligne_planification = $this->Horaire_model->get_ligne_by_classe($classe->id, $h);
                $tab_horaires_classes[$classe->nom][$h] = array(
                    "lundi"=>"",
                    "mardi"=>"",
                    "mercredi"=>"",
                    "jeudi"=>"",
                    "vendredi"=>"",
                    "samedi"=>"",
                );
                foreach ($ligne_planification as $ligne) {
                    $cours = $this->Cours_model->get_by_id($ligne->cours_id);
                    $enseignant = $this->Enseignant_model->get_by_id($ligne->enseignant_id); 
                    $tab_horaires_classes[$classe->nom][$h][$ligne->jour] = '<strong>'.$cours->intitule.'</strong><br>'.$enseignant->nomcomplet; 
                }
            }
        }

        $data = array(
            'tab_horaires_classes' => $tab_horaires_classes,
        );
        $this->load->view( 'horaire/par_classe', $data );
    }

    public function par_enseignant() {
        $enseignants = $this->Enseignant_model->get_all();

        $tab_horaires_enseignants = array();
        foreach ($enseignants as $enseignant) {
            $tth = $this->Horaire_model->get_total_heure_enseignant($enseignant->id);
            $nom_enseignant = $enseignant->nomcomplet.'('.$tth.'H)';
            $tab_horaires_enseignants[$nom_enseignant] = array();
            for ($h=1; $h < 9; $h++) { 
                $ligne_planification = $this->Horaire_model->get_ligne_by_enseignant($enseignant->id, $h);
                $tab_horaires_enseignants[$nom_enseignant][$h] = array(
                    "lundi"=>"",
                    "mardi"=>"",
                    "mercredi"=>"",
                    "jeudi"=>"",
                    "vendredi"=>"",
                    "samedi"=>"",
                );
                foreach ($ligne_planification as $ligne) {
                    $cours = $this->Cours_model->get_by_id($ligne->cours_id);
                    $classe = $this->Classe_model->get_by_id($ligne->classe_id); 
                    $tab_horaires_enseignants[$nom_enseignant][$h][$ligne->jour] = '<strong>'.$cours->intitule.'</strong><br>'.$classe->nom; 
                }
            }
        }

        $data = array(
            'tab_horaires_enseignants' => $tab_horaires_enseignants,
        );
        $this->load->view( 'horaire/par_enseignant', $data );
    }

    public function index() {
        $q = urldecode( $this->input->get( 'q', TRUE ) );
        $start = intval( $this->input->get( 'start' ) );

        if ( $q <> '' ) {
            $config['base_url'] = base_url() . 'horaire/index.html?q=' . urlencode( $q );
            $config['first_url'] = base_url() . 'horaire/index.html?q=' . urlencode( $q );
        } else {
            $config['base_url'] = base_url() . 'horaire/index.html';
            $config['first_url'] = base_url() . 'horaire/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Horaire_model->total_rows( $q );
        $horaire = $this->Horaire_model->get_limit_data( $config['per_page'], $start, $q );

        $this->load->library( 'pagination' );
        $this->pagination->initialize( $config );

        $data = array(
            'horaire_data' => $horaire,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view( 'horaire/horaire_list', $data );
    }

    public function read( $id )  {
        $row = $this->Horaire_model->get_by_id( $id );
        if ( $row ) {
            $data = array(
                'id' => $row->id,
                'jour' => $row->jour,
                'quantiemeheure' => $row->quantiemeheure,
                'anneedebut' => $row->anneedebut,
                'anneefin' => $row->anneefin,
                'classe_id' => $row->classe_id,
                'cours_id' => $row->cours_id,
                'enseignant_id' => $row->enseignant_id,
            );
            $this->load->view( 'horaire/horaire_read', $data );
        } else {
            $this->session->set_flashdata( 'message', 'Record Not Found' );
            redirect( site_url( 'horaire' ) );
        }
    }

    public function create()  {
        $data = array(
            'button' => 'Create',
            'action' => site_url( 'horaire/create_action' ),
            'id' => set_value( 'id' ),
            'jour' => set_value( 'jour' ),
            'quantiemeheure' => set_value( 'quantiemeheure' ),
            'anneedebut' => set_value( 'anneedebut' ),
            'anneefin' => set_value( 'anneefin' ),
            'classe_id' => set_value( 'classe_id' ),
            'cours_id' => set_value( 'cours_id' ),
            'enseignant_id' => set_value( 'enseignant_id' ),
        );
        $this->load->view( 'horaire/horaire_form', $data );
    }

    public function create_action()  {
        $this->_rules();

        if ( $this->form_validation->run() == FALSE ) {
            $this->create();
        } else {
            $data = array(
                'jour' => $this->input->post( 'jour', TRUE ),
                'quantiemeheure' => $this->input->post( 'quantiemeheure', TRUE ),
                'anneedebut' => $this->input->post( 'anneedebut', TRUE ),
                'anneefin' => $this->input->post( 'anneefin', TRUE ),
                'classe_id' => $this->input->post( 'classe_id', TRUE ),
                'cours_id' => $this->input->post( 'cours_id', TRUE ),
                'enseignant_id' => $this->input->post( 'enseignant_id', TRUE ),
            );

            $horaire = $this->Horaire_model->get_by_meme_heure($data['jour'], $data['quantiemeheure'], $data['classe_id']);
            if($horaire) {
                $this->session->set_flashdata( 'message', 'On ne peut pas avoir deux cours le même jour à la même heure dans une même classe' );
                $this->create();
            } else {
                $horaire = $this->Horaire_model->get_by_meme_enseignant($data['jour'], $data['quantiemeheure'], $data['enseignant_id']);
                if($horaire) {
                    $this->session->set_flashdata( 'message', 'Un enseignant ne peut pas avoir deux cours à la même heure le même jour' );
                    $this->create();
                } else {
                    $this->Horaire_model->insert( $data );
                    $this->session->set_flashdata( 'message', 'Create Record Success' );
                    redirect( site_url( 'horaire' ) );
                }
            }
        }
    }

    public function update( $id )  {
        $row = $this->Horaire_model->get_by_id( $id );

        if ( $row ) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( 'horaire/update_action' ),
                'id' => set_value( 'id', $row->id ),
                'jour' => set_value( 'jour', $row->jour ),
                'quantiemeheure' => set_value( 'quantiemeheure', $row->quantiemeheure ),
                'anneedebut' => set_value( 'anneedebut', $row->anneedebut ),
                'anneefin' => set_value( 'anneefin', $row->anneefin ),
                'classe_id' => set_value( 'classe_id', $row->classe_id ),
                'cours_id' => set_value( 'cours_id', $row->cours_id ),
                'enseignant_id' => set_value( 'enseignant_id', $row->enseignant_id ),
            );
            $this->load->view( 'horaire/horaire_form', $data );
        } else {
            $this->session->set_flashdata( 'message', 'Record Not Found' );
            redirect( site_url( 'horaire' ) );
        }
    }

    public function update_action()  {
        $this->_rules();

        if ( $this->form_validation->run() == FALSE ) {
            $this->update( $this->input->post( 'id', TRUE ) );
        } else {
            $data = array(
                'jour' => $this->input->post( 'jour', TRUE ),
                'quantiemeheure' => $this->input->post( 'quantiemeheure', TRUE ),
                'anneedebut' => $this->input->post( 'anneedebut', TRUE ),
                'anneefin' => $this->input->post( 'anneefin', TRUE ),
                'classe_id' => $this->input->post( 'classe_id', TRUE ),
                'cours_id' => $this->input->post( 'cours_id', TRUE ),
                'enseignant_id' => $this->input->post( 'enseignant_id', TRUE ),
            );

            $horaire = $this->Horaire_model->get_by_meme_heure( $data['jour'], $data['quantiemeheure'], $data['classe_id']);
            if($horaire) {
                $this->session->set_flashdata( 'message', 'On ne peut pas avoir deux cours le même jour à la même heure dans une même classe' );
                $this->create();
            } else {
                $horaire = $this->Horaire_model->get_by_meme_enseignant($data['jour'], $data['quantiemeheure'], $data['enseignant_id']);
                if($horaire) {
                    $this->session->set_flashdata( 'message', 'Un enseignant ne peut pas avoir deux cours à la même heure le même jour' );
                    $this->create();
                } else {
                    $this->Horaire_model->update( $this->input->post( 'id', TRUE ), $data );
                    $this->session->set_flashdata( 'message', 'Update Record Success' );
                    redirect( site_url( 'horaire' ) );
                }
                
            }            
        }
    }

    public function delete( $id )  {
        $row = $this->Horaire_model->get_by_id( $id );

        if ( $row ) {
            $this->Horaire_model->delete( $id );
            $this->session->set_flashdata( 'message', 'Delete Record Success' );
            redirect( site_url( 'horaire' ) );
        } else {
            $this->session->set_flashdata( 'message', 'Record Not Found' );
            redirect( site_url( 'horaire' ) );
        }
    }

    public function _rules()  {
        $this->form_validation->set_rules( 'jour', 'jour', 'trim|required' );
        $this->form_validation->set_rules( 'quantiemeheure', 'quantiemeheure', 'trim|required' );
        $this->form_validation->set_rules( 'anneedebut', 'anneedebut', 'trim|required' );
        $this->form_validation->set_rules( 'anneefin', 'anneefin', 'trim|required' );
        $this->form_validation->set_rules( 'classe_id', 'classe id', 'trim|required' );
        $this->form_validation->set_rules( 'cours_id', 'cours id', 'trim|required' );
        $this->form_validation->set_rules( 'enseignant_id', 'enseignant id', 'trim|required' );

        $this->form_validation->set_rules( 'id', 'id', 'trim' );
        $this->form_validation->set_error_delimiters( '<span class="text-danger">', '</span>' );
    }
}
