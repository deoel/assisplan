<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classe extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Classe_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'classe/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'classe/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'classe/index.html';
            $config['first_url'] = base_url() . 'classe/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Classe_model->total_rows($q);
        $classe = $this->Classe_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'classe_data' => $classe,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('classe/classe_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Classe_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nom' => $row->nom,
		'abbreviation' => $row->abbreviation,
	    );
            $this->load->view('classe/classe_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classe'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('classe/create_action'),
	    'id' => set_value('id'),
	    'nom' => set_value('nom'),
	    'abbreviation' => set_value('abbreviation'),
	);
        $this->load->view('classe/classe_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'abbreviation' => $this->input->post('abbreviation',TRUE),
	    );

            $this->Classe_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('classe'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Classe_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('classe/update_action'),
		'id' => set_value('id', $row->id),
		'nom' => set_value('nom', $row->nom),
		'abbreviation' => set_value('abbreviation', $row->abbreviation),
	    );
            $this->load->view('classe/classe_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classe'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nom' => $this->input->post('nom',TRUE),
		'abbreviation' => $this->input->post('abbreviation',TRUE),
	    );

            $this->Classe_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('classe'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Classe_model->get_by_id($id);

        if ($row) {
            $this->Classe_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('classe'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('classe'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nom', 'nom', 'trim|required');
	$this->form_validation->set_rules('abbreviation', 'abbreviation', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

