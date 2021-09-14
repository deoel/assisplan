<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cours extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cours_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'cours/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'cours/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'cours/index.html';
            $config['first_url'] = base_url() . 'cours/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cours_model->total_rows($q);
        $cours = $this->Cours_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cours_data' => $cours,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('cours/cours_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Cours_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'intitule' => $row->intitule,
		'abbreviation' => $row->abbreviation,
	    );
            $this->load->view('cours/cours_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cours'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('cours/create_action'),
	    'id' => set_value('id'),
	    'intitule' => set_value('intitule'),
	    'abbreviation' => set_value('abbreviation'),
	);
        $this->load->view('cours/cours_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'intitule' => $this->input->post('intitule',TRUE),
		'abbreviation' => $this->input->post('abbreviation',TRUE),
	    );

            $this->Cours_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('cours'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Cours_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('cours/update_action'),
		'id' => set_value('id', $row->id),
		'intitule' => set_value('intitule', $row->intitule),
		'abbreviation' => set_value('abbreviation', $row->abbreviation),
	    );
            $this->load->view('cours/cours_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cours'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'intitule' => $this->input->post('intitule',TRUE),
		'abbreviation' => $this->input->post('abbreviation',TRUE),
	    );

            $this->Cours_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('cours'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Cours_model->get_by_id($id);

        if ($row) {
            $this->Cours_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('cours'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cours'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('intitule', 'intitule', 'trim|required');
	$this->form_validation->set_rules('abbreviation', 'abbreviation', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

