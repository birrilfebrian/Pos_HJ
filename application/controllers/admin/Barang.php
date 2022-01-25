<?php
error_reporting(0);
class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->library('barcode');
	}
	function index(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='3'){
		$data['data']=$this->m_barang->tampil_barang();
		$data['sup']=$this->m_suplier->tampil_suplier();
		$data['kat']=$this->m_kategori->tampil_kategori();
		$data['kat2']=$this->m_kategori->tampil_kategori();
		$this->load->view('admin/v_barang',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_barang(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='3'){
		$kobar=$this->m_barang->get_kobar();
		$nabar=$this->input->post('nabar');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$suplier=$this->input->post('suplier');
		$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harjul=str_replace(',', '', $this->input->post('harjul'));
		$harjul_grosir=str_replace(',', '', $this->input->post('harjul_grosir'));
		$stok=$this->input->post('stok');
		$min_stok=$this->input->post('min_stok');
		$this->m_barang->simpan_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$harjul_grosir,$stok,$min_stok,$suplier);

		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function storing_data(){
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$x=$this->m_barang->tampil_barang();
		$b= $x->result();
		$i = 1;
		foreach($b as $dt){
			$data[] = array(
				$i,
				$dt->barang_id,
				$dt->barang_nama,
				$dt->barang_satuan,
				$dt->barang_harpok,
				$dt->barang_harjul,
				$dt->barang_harjul_grosir,
				$dt->barang_stok,
				$dt->barang_min_stok,
				$dt->kategori_nama,
				$dt->suplier_nama,
				"<a class='btn btn-xs btn-warning' href='#modalEditPelanggan".$dt->barang_id."' data-toggle='modal' title='Edit'><span class='fa fa-edit'></span> Edit</a>
				<a class='btn btn-xs btn-danger' href='#modalHapusPelanggan".$dt->barang_id."' data-toggle='modal' title='Hapus'><span class='fa fa-close'></span> Hapus</a>",
			);
			$i++;
		}

		$result = array(
			  "draw" => $draw,
			  "recordsTotal" => $x->num_rows(),
			  "recordsFiltered" => $x->num_rows(),
			  "data" => $data
		 );
		
		// foreach($b as $a){
		// 	$b[$i]['no'] = $i;
		// 	$b[$i]['aksi'] ="<a class='btn btn-xs btn-warning' href='#modalEditPelanggan".$a['barang_id']."' data-toggle='modal' title='Edit'>
		// 	<a class='btn btn-xs btn-danger' href='#modalHapusPelanggan".$a['barang_id']."' data-toggle='modal' title='Hapus'><span class='fa fa-close'></span> Hapus</a>";
		// 	$i++;

		// }
		echo json_encode($result);

	}
	function edit_barang(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='3'){
		$kobar=$this->input->post('kobar');
		$nabar=$this->input->post('nabar');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harjul=str_replace(',', '', $this->input->post('harjul'));
		$harjul_grosir=str_replace(',', '', $this->input->post('harjul_grosir'));
		$stok=$this->input->post('stok');
		$min_stok=$this->input->post('min_stok');
		$this->m_barang->update_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$harjul_grosir,$stok,$min_stok);
		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function cetak_barcode($id=''){
		$data['data']=$this->m_barang->cetak_barcode($id);
		$this->load->view('admin/laporan/v_barcode',$data);
		redirect('admin/barang');
	}
	function hapus_barang(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->m_barang->hapus_barang($kode);
		redirect('admin/barang');
	}else{
        redirect('admin/barang');
    }
	}
}