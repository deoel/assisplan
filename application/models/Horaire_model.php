<?php

if ( !defined( 'BASEPATH' ) )
exit( 'No direct script access allowed' );

class Horaire_model extends CI_Model {

    public $table = 'horaire';
    public $id = 'id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get all

    function get_all() {
        $this->db->order_by( $this->id, $this->order );
        return $this->db->get( $this->table )->result();
    }

    // get data by id

    function get_by_id( $id ) {
        $this->db->where( $this->id, $id );
        return $this->db->get( $this->table )->row();
    }

    function get_by_meme_heure($jour, $quantiemeheure, $classe_id) {
        $this->db->where( 'jour', $jour );
        $this->db->where( 'quantiemeheure', $quantiemeheure );
        $this->db->where( 'classe_id', $classe_id );
        return $this->db->get( $this->table )->row();
    }

    function get_by_meme_enseignant($jour, $quantiemeheure, $enseignant_id) {
        $this->db->where( 'jour', $jour );
        $this->db->where( 'quantiemeheure', $quantiemeheure );
        $this->db->where( 'enseignant_id', $enseignant_id );
        return $this->db->get( $this->table )->row();
    }

    function get_ligne_by_classe($classe_id, $quantiemeheure) {
        $this->db->where( 'classe_id', $classe_id );
        $this->db->where( 'quantiemeheure', $quantiemeheure );
        return $this->db->get( $this->table )->result();
    }

    function get_ligne_by_enseignant($enseignant_id, $quantiemeheure) {
        $this->db->where( 'enseignant_id', $enseignant_id );
        $this->db->where( 'quantiemeheure', $quantiemeheure );
        return $this->db->get( $this->table )->result();
    }

    function get_total_heure_enseignant($enseignant_id) {
        $this->db->where( 'enseignant_id', $enseignant_id );
        $this->db->from( $this->table );
        return $this->db->count_all_results();
    }

    // get total rows

    function total_rows( $q = NULL ) {
        $this->db->like( 'id', $q );
        $this->db->or_like( 'jour', $q );
        $this->db->or_like( 'quantiemeheure', $q );
        $this->db->or_like( 'anneedebut', $q );
        $this->db->or_like( 'anneefin', $q );
        $this->db->or_like( 'classe_id', $q );
        $this->db->or_like( 'cours_id', $q );
        $this->db->or_like( 'enseignant_id', $q );
        $this->db->from( $this->table );
        return $this->db->count_all_results();
    }

    // get data with limit and search

    function get_limit_data( $limit, $start = 0, $q = NULL ) {
        $this->db->order_by( $this->id, $this->order );
        $this->db->like( 'id', $q );
        $this->db->or_like( 'jour', $q );
        $this->db->or_like( 'quantiemeheure', $q );
        $this->db->or_like( 'anneedebut', $q );
        $this->db->or_like( 'anneefin', $q );
        $this->db->or_like( 'classe_id', $q );
        $this->db->or_like( 'cours_id', $q );
        $this->db->or_like( 'enseignant_id', $q );
        $this->db->limit( $limit, $start );
        return $this->db->get( $this->table )->result();
    }

    // insert data

    function insert( $data ) {
        $this->db->insert( $this->table, $data );
    }

    // update data

    function update( $id, $data ) {
        $this->db->where( $this->id, $id );
        $this->db->update( $this->table, $data );
    }

    // delete data

    function delete( $id ) {
        $this->db->where( $this->id, $id );
        $this->db->delete( $this->table );
    }

}

/* End of file Horaire_model.php */
/* Location: ./application/models/Horaire_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-08 07:49:26 */
/* http://harviacode.com */