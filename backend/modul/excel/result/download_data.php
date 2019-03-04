<?php
session_start();
include "../../inc/config.php";
require_once '../../inc/lib/Writer.php';


$writer = new XLSXWriter();
$style =
        array (
            array(
              'border' => array(
                'style' => 'thin',
                'color' => '000000'
                ),
            'allfilleddata' => true
            ),
            
            array(
                'fill' => array(
                    'color' => 'ff0000'
                    ),
                'cells' => array(
                   'A1'
                    ),
                'border' => array(
                    'style' => 'thin',
                    'color' => '000000'
                    ),
                'verticalAlign' => 'center',
                'horizontalAlign' => 'center',
            ),
            
            array(
                'fill' => array(
                    'color' => '00ff00'
                    ),
                'cells' => array(
                  'B1'
                    ),
                'border' => array(
                    'style' => 'thin',
                    'color' => '000000'
                    ),
                'verticalAlign' => 'center',
                'horizontalAlign' => 'center',
            ),
            );
//column width
$col_width = array(
1 => 9,
2 => 10
  );
$writer->setColWidth($col_width);

$header = array(
	"Kode ID" => "string",
"Fakultas" => "string"
);

$data_rec = array();

$jur_filter = "";
  $angkatan_filter = "";
  

  if (isset($_POST['jur_filter'])) {
		
      if ($_POST['jur_filter']!='all') {
        $jur_filter = ' and change_your_column_here="'.$_POST['jur_filter'].'"';
      }
  
      if ($_POST['angkatan_filter']!='all') {
        $angkatan_filter = ' and change_your_column_here="'.$_POST['angkatan_filter'].'"';
      }
  
}
        $order_by = "order by your order here";

    
        $temp_rec = $db->query("your query here $jur_filter $angkatan_filter  ");
                    foreach ($temp_rec as $key) {

                      $data_rec[] = array(
                      				$key->id,
															$key->nama_fakultas
                        );

            }


$filename = 'mahasiswa.xlsx';
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$writer->writeSheet($data_rec,'Data Tagihan Mhs', $header, $style);
$writer->writeToStdOut();
exit(0);
?>