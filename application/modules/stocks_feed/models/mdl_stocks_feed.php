<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_stocks_feed extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
$table = "stocks_feed";
return $table;
}

function get_id_at_time($stock_symbol, $timestamp) {
$table = $this->get_table();
$this->db->select_max('id');
$this->db->where('stock_symbol', $stock_symbol);
$this->db->where('date_added <=', $timestamp);
$query=$this->db->get($table);
$row=$query->row();
$id=$row->id;
return $id;
}

function get_lowest_price_between_two_times($stock_symbol, $start_time, $end_time) {
$table = $this->get_table();
$this->db->select_min('price');
$this->db->where('stock_symbol', $stock_symbol);
$this->db->where('date_added >=', $start_time);
$this->db->where('date_added <=', $end_time);
$query=$this->db->get($table);
$row=$query->row();
$price=$row->price;
return $price; 
}

function get_highest_price_between_two_times($stock_symbol, $start_time, $end_time) {
$table = $this->get_table();
$this->db->select_max('price');
$this->db->where('stock_symbol', $stock_symbol);
$this->db->where('date_added >=', $start_time);
$this->db->where('date_added <=', $end_time);
$query=$this->db->get($table);
$row=$query->row();
$price=$row->price;
return $price; 
}




function get($order_by) {
$table = $this->get_table();
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$table = $this->get_table();
$this->db->limit($limit, $offset);
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function get_where($id) {
$table = $this->get_table();
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}

function get_where_custom($col, $value) {
$table = $this->get_table();
$this->db->where($col, $value);
$query=$this->db->get($table);
return $query;
}

function _insert($data) {
$table = $this->get_table();
$this->db->insert($table, $data);
}

function _update($id, $data) {
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->update($table, $data);
}

function _delete($id) {
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->delete($table);
}

function count_where($column, $value) {
$table = $this->get_table();
$this->db->where($column, $value);
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function count_all() {
$table = $this->get_table();
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function get_min_date() {
$table = $this->get_table();
$this->db->select_min('date_added');
$query = $this->db->get($table);
$row=$query->row();
$value=$row->date_added;
return $value;	
}



function get_max_alt($target_column, $where_column1, $where_value1, $where_column2, $where_value2) {
$table = $this->get_table();
$this->db->where($where_column1, $where_value1);
$this->db->where($where_column2, $where_value2);
$this->db->select_max($target_column);
$query = $this->db->get($table);
$row=$query->row();
$value=$row->$target_column;
return $value;
}

function get_max() {
$table = $this->get_table();
$this->db->select_max('id');
$query = $this->db->get($table);
$row=$query->row();
$id=$row->id;
return $id;
}

function _custom_query($mysql_query) {
$query = $this->db->query($mysql_query);
return $query;
}

}