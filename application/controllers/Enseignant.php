<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enseignant extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Enseignant_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'enseignant/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'enseignant/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'enseignant/index.html';
            $config['first_url'] = base_url() . 'enseignant/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Enseignant_model->total_rows($q);
        $enseignant = $this->Enseignant_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'enseignant_data' => $enseignant,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('enseignant/enseignant_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Enseignant_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nomcomplet' => $row->nomcomplet,
		'qualification' => $row->qualification,
		'annee_debut' => $row->annee_debut,
	    );
            $this->load->view('enseignant/enseignant_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('enseignant'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('enseignant/create_action'),
	    'id' => set_value('id'),
	    'nomcomplet' => set_value('nomcomplet'),
	    'qualification' => set_value('qualification'),
	    'annee_debut' => set_value('annee_debut'),
	);
        $this->load->view('enseignant/enseignant_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nomcomplet' => $this->input->post('nomcomplet',TRUE),
		'qualification' => $this->input->post('qualification',TRUE),
		'annee_debut' => $this->input->post('annee_debut',TRUE),
	    );

            $this->Enseignant_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('enseignant'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Enseignant_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('enseignant/update_action'),
		'id' => set_value('id', $row->id),
		'nomcomplet' => set_value('nomcomplet', $row->nomcomplet),
		'qualification' => set_value('qualification', $row->qualification),
		'annee_debut' => set_value('annee_debut', $row->annee_debut),
	    );
            $this->load->view('enseignant/enseignant_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('enseignant'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nomcomplet' => $this->input->post('nomcomplet',TRUE),
		'qualification' => $this->input->post('qualification',TRUE),
		'annee_debut' => $this->input->post('annee_debut',TRUE),
	    );

            $this->Enseignant_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('enseignant'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Enseignant_model->get_by_id($id);

        if ($row) {
            $this->Enseignant_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('enseignant'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('enseignant'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nomcomplet', 'nomcomplet', 'trim|required');
	$this->form_validation->set_rules('qualification', 'qualification', 'trim|required');
	$this->form_validation->set_rules('annee_debut', 'annee debut', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Enseignant.php */
/* Location: ./application/controllers/Enseignant.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-14 14:52:02 */
/* http://harviacode.com */