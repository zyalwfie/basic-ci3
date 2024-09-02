<?php

class Blog extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('BlogModel');
  }

  public function index($offset = 0)
  {
    // $this->load->database();
    // $query = $this->db->query('SELECT * FROM blogs');

    // $query = $this->BlogModel->getBlogs();
    // $blogs = $query->result_array();

    $this->load->library('pagination');

    $config['base_url'] = site_url('blog/index');
    $config['total_rows'] = $this->BlogModel->getCountBlogs();
    $config['per_page'] = 2;

    $this->pagination->initialize($config);

    $query = $this->BlogModel->getBlogs($config['per_page'], $offset);
    $blogs = $query->result_array();

    $data = [
      'blogs' => $blogs
    ];

    $this->load->view('blogs', $data);

    // $data = [
    //   'blogs' => [
    //     [
    //       'title' => 'first blog title',
    //       'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    //     ],
    //     [
    //       'title' => 'second blog title',
    //       'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    //     ],
    //     [
    //       'title' => 'third blog title',
    //       'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    //     ],
    //     [
    //       'title' => 'fourth blog title',
    //       'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    //     ],
    //     [
    //       'title' => 'fifth blog title',
    //       'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    //     ]
    //   ]
    // ];
  }

  public function show($id)
  {
    $id = (int) $id;

    // $query = $this->db->query("SELECT * FROM blogs WHERE id=$id");
    $query = $this->BlogModel->getBlog($id);

    if ($query->num_rows() == 0) {
      show_404();
      return;
    }

    $blog = $query->row_array();

    $data = [
      'blog' => $blog
    ];

    $this->load->view('blog', $data);
  }

  public function create()
  {
    $this->load->view('create');
  }

  public function store()
  {
    $this->form_validation->set_rules('title', 'title', 'required');

    // var_dump($this->form_validation->run());
    // die;

    $title = $this->input->post('title');
    $slug = $this->input->post('slug');
    $body = $this->input->post('body');
    $author = $this->input->post('author');

    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'gif|jpg|png';

    $this->load->library('upload', $config);

    $doUpload = $this->upload->do_upload('cover');

    if (!$doUpload) {
      $error = array('error' => $this->upload->display_errors());
    } else {
      $fileName = $this->upload->data()['file_name'];
    }

    $data = [
      'title' => $title,
      'slug' => $slug,
      'body' => $body,
      'author' => $author,
      'cover' => $fileName
    ];

    $this->BlogModel->insertData($data);

    $this->session->set_flashData('success', 'New blog has been added');
    return redirect('blog');
  }

  public function edit($id)
  {
    $query = $this->BlogModel->getBlog($id);
    $blog = $query->row_array();

    $data = [
      'blog' => $blog
    ];

    $this->load->view('edit', $data);
  }

  public function update()
  {
    $id = $this->input->post('id');
    $title = $this->input->post('title');
    $slug = $this->input->post('slug');
    $body = $this->input->post('body');
    $author = $this->input->post('author');

    $blogData = $this->BlogModel->getBlog($id);
    $rowBlog = $blogData->row_array();

    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'gif|jpg|png';

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('cover')) {
      if (empty($rowBlog['cover'])) {
        $fileName = 'default.jpg';
      } else {
        $fileName = $rowBlog['cover'];
      }
    } else {
      $fileName = $this->upload->data('file_name');
    }

    $data = [
      'id' => $id,
      'title' => $title,
      'slug' => $slug,
      'body' => $body,
      'author' => $author,
      'cover' => $fileName
    ];

    $this->BlogModel->updateBlog($id, $data);

    return redirect('blog');
  }

  public function destroy($id)
  {
    $this->BlogModel->deleteBlog($id);
    redirect('blog');
  }

  public function login()
  {
    if ($this->input->post()) {
      $username = $this->input->post('username');
      $password = $this->input->post('password');

      if ($username === 'admin' && $password == 123) {
        $_SESSION['login'] = 'admin';
        $this->session->set_flashData('login', 'You has been login!');
        redirect('blog');
      } else {
        redirect('blog/login');
      }
    }

    $this->load->view('login');
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('blog/login');
  }
}
