<?php

$excel = new PHPExcel();


# Add the basic information
$excel->setActiveSheetIndex(0)->setTitle('Peri Labs Data Template')
        ->setCellValue('A1', 'Peri Labs Data Template')
        ->setCellValue('B1', 'Date Created:')
        ->setCellValue('C1', date('j/n/Y'))
        ->setCellValue('E1', 'Peri Labs Trial ID# (do not change!)')
        ->setCellValue('E2', $model->trial_id)
        ->setCellValue('A3', 'Experiment Title:')
        ->setCellValue('B3', $model->experiment->title)
        ->setCellValue('A4', 'Goal/Hypothesis:')
        ->setCellValue('B4', $model->experiment->goal)
        ->setCellValue('A5', 'Constants:');

foreach($model->experiment->constants as $constant):
        $row = array_search($constant, $model->experiment->constants) + 6;
        $excel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, $row, $constant->title)
                ->setCellValueByColumnAndRow(1, $row, $constant->description);
endforeach;

$constantsCount = sizeof($model->experiment->constants);
$rowCount = $constantsCount + 5;

# Add the instructions
$excel->getActiveSheet()
        ->setCellValueByColumnAndRow(0, ($rowCount+2), 'Instructions:')
        ->setCellValueByColumnAndRow(0, ($rowCount+3), 'This template has been created to help import your data. Do not make any changes to the information above this row')
        ->setCellValueByColumnAndRow(0, ($rowCount+4), 'or to the names of the metrics. All rows below will be added to your trial on import.');

# Add the header rows
$excel->getActiveSheet()
        ->setCellValueByColumnAndRow(0, ($rowCount+6), 'Name, Title, or ID#');
foreach($model->experiment->metrics as $metric):
        $column = array_search($metric, $model->experiment->metrics) + 1;
        $excel->getActiveSheet() 
                ->setCellValueByColumnAndRow($column, ($rowCount+6), $metric->title);
endforeach;
$excel->getActiveSheet()
        ->setCellValueByColumnAndRow(0, ($rowCount+7), '');

# Bold all the necessary cells
$bold_style_array = array(
        'font' => array(
                'bold' => true
        )
);
$header_row = $rowCount + 6;
$excel->getActiveSheet()
        ->getStyle("A1:G$header_row")
        ->applyFromArray($bold_style_array);

# Set a right-hand border on description cells
$right_border_array = array(
        'borders' => array(
                'right' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                )
        )
); 
$excel->getActiveSheet()
        ->getStyle("G1:G$rowCount")
        ->applyFromArray($right_border_array);

# Set a bottom border on description cells
$bottom_border_array = array(
        'borders' => array(
                'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                )
        )
);
$excel->getActiveSheet()
        ->getStyle("A$rowCount:G$rowCount")
        ->applyFromArray($bottom_border_array);

$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

# Write the file to the browser
$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
$writer->save('php://output');
?>
