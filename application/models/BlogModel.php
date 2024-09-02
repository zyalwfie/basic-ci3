<?php

class BlogModel extends CI_Model
{
  public function getBlogs($limit, $offset)
  {
    $filter = $this->input->get('keyword');
    $blogs = $this->db->like('title', $filter)->limit($limit, $offset)->order_by('title')->get('blogs');
    return $blogs;
  }

  public function getCountBlogs()
  {
    $filter = $this->input->get('keyword');
    $blogs = $this->db->like('title', $filter);
    return $blogs->count_all_results('blogs');
  }

  public function getBlog($id)
  {
    // return $this->db->where('id', $id)->get('blogs');
    return $this->db->where('id', $id)->get('blogs');
  }

  public function insertData($data)
  {
    $this->db->insert('blogs', $data);
    return $this->db->insert_id();
  }

  public function updateBlog($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('blogs', $data);
    return $this->db->affected_rows();
  }

  public function deleteBlog($id)
  {
    $this->db->where('id', $id)->delete('blogs');
    return $this->db->affected_rows();
  }
}
