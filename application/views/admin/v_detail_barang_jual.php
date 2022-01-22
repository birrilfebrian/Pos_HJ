					<?php 
						error_reporting(0);
						$b=$brg;
						$c =$this->db->query("select suplier_nama from tbl_suplier where suplier_id ='".$b['suplier_id']."'")->row_array();
					?>
					<table>
						<tr>
		                    <th style="width:200px;"></th>
		                    <th>Nama Barang</th>
							<th>Nama Suplier</th>
		                    <th>Satuan</th>
		                    <th>Stok</th>
		                    <th>Harga(Rp)</th>
		                    <th>Diskon(Rp)</th>
		                    <th>Jumlah</th>
		                </tr>
						<tr>
							<td style="width:200px;"></th>
							<td><input type="text" name="nabar" value="<?php echo $b['barang_nama'];?>" style="width:130px;margin-right:5px;" class="form-control input-sm" readonly></td>
							<td><input type="text" name="nabar" value="<?php echo $c['suplier_nama'];?>" style="width:150px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="satuan" value="<?php echo $b['barang_satuan'];?>" style="width:120px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="stok" value="<?php echo $b['barang_stok'];?>" style="width:60px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="harjul" value="<?php echo number_format($b['barang_harjul']);?>" style="width:120px;margin-right:5px;text-align:right;" class="form-control input-sm" readonly></td>
		                    <td><input type="number" name="diskon" id="diskon" value="0" min="0" class="form-control input-sm" style="width:130px;margin-right:5px;" required></td>
		                    <td><input type="number" name="qty" id="qty" value="1" min="1" max="<?php echo $b['barang_stok'];?>" class="form-control input-sm" style="width:90px;margin-right:5px;" required></td>
		                    <td><button type="submit" class="btn btn-sm btn-primary">Ok</button></td>
						</tr>
					</table>
					