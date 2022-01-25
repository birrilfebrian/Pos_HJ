<?php
require_once(APPPATH.'vendor/mike42/escpos-php/autoload.php');
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Printer-ESCPOS-PDF-0.003\lib\Printer::ESCPOS;
// use Printer-ESCPOS-PDF-0.003\lib\XML::Printer::ESCPOS;

    $b=$data->row_array();
    $date = date('d-M-Y H:i:s');  
        $connector = new CupsPrintConnector("Receipt_printer", $_SERVER["REMOTE_ADDR"]);
        // $logo = EscposImage::load("./assets/img/logo.png", false);
        $printer = new Printer($connector);
        $printer -> initialize();      
        /* Name of shop */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        // $printer -> graphics($logo);
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> setTextSize(2,2);
        $printer -> text("Hasil Jaya\n");
        $printer -> setTextSize(1,1);
        $printer -> selectPrintMode();
        $printer -> text("Jl. HOS. COKROAMINOTO NO 62\n");
        $printer -> text("0331-485951\n");
        $printer -> text("JEMBER\n");
        $printer -> text("=================================\n");
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("No Faktur    : ");
        $printer -> text($b['jual_nofak']);
        $printer -> feed();
        /* Title of receipt */
        $printer -> setEmphasis(true);
        $printer -> text("Nama");
        $printer -> text("      Qty");
        $printer -> text("  Harga");
        $printer -> text("    Total");
        $printer -> setEmphasis(false);
        $printer ->feed();
        $printer -> text("---------------------------------\n"); 
        foreach ($data->result_array() as $i) {
        // $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text(wordwrap($nabar=$i['d_jual_barang_nama'],10,"\n"));
        $printer -> text("       ".$qty=$i['d_jual_qty']);
        $printer -> text("  ".$harjul=$i['d_jual_barang_harjul']);
        $printer -> text("  ".number_format($total=$i['d_jual_total']));
        $printer -> feed();
        }
        $printer -> text("--------------------------------\n");
       // $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $printer -> setEmphasis(true);
        $printer -> text("     Total     : ");
        $printer -> text("Rp.".number_format($b['jual_total']).",-");
        $printer -> setEmphasis(false);
        $printer -> feed(); 
        $printer -> text("     Tunai     : ");        
        $printer -> text("Rp.".number_format($b['jual_jml_uang']).",-");
        $printer -> feed();
        $printer -> text("     Diskon    : ");        
        $printer -> text("Rp.".number_format($diskon=$i['d_jual_diskon']).",-");
        $printer -> feed();
        $printer -> text("     Kembalian : ");        
        $printer -> text("Rp.".number_format($b['jual_kembalian']).",-");
        $printer -> feed();
        $printer -> text("--------------------------------\n");
        /* Footer */
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Terima Kasih Atas Kunjungan Anda");
        $printer -> feed();
        $printer -> text($date . "\n");
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setFont(Printer::FONT_B);
        $printer -> text("*Barang yang sudah dibeli \n");
        $printer -> text("tidak dapat ditukar/dikembalikan \n");


        /* Cut the receipt and open the cash drawer */
        $printer -> cut();
        $printer->save_pdf('test.pdf');
        $printer -> pulse();
        $printer -> close();