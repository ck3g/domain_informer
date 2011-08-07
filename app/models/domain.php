<?php

 
class DomainModel {

    public static function PopulateSheet($domain_info, PHPExcel $p_excel, $sheet_index = 0) {
        if ($sheet_index)
            $p_excel->createSheet($sheet_index);

        $p_excel->setActiveSheetIndex($sheet_index);
        $a_sheet = $p_excel->getActiveSheet();
        $a_sheet->setTitle('sheet');

        $base_font = array(
            'font' => array(
                'size' => '10',
                'bold' => false
            )
        );

        $bold_font = array(
            'font' => array(
                'size' => '10',
                'bold' => true
            )
        );

        $center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );

        $a_sheet->setCellValue('A1', 'Url');
        $a_sheet->setCellValue('A2', $domain_info->url);
        $a_sheet->getColumnDimension('A')->setWidth(35);
        $a_sheet->getStyle('A1')->applyFromArray($bold_font)->applyFromArray($center);

        $a_sheet->setCellValue('B1', 'Country');
        $a_sheet->setCellValue('B2', $domain_info->country_code);
        $a_sheet->getColumnDimension('B')->setWidth(35);
        $a_sheet->getStyle('B1')->applyFromArray($bold_font)->applyFromArray($center);

        $a_sheet->setCellValue('C1', 'IP Address');
        $a_sheet->setCellValue('C2', $domain_info->ip_address);
        $a_sheet->getColumnDimension('C')->setWidth(15);
        $a_sheet->getStyle('C1')->applyFromArray($bold_font)->applyFromArray($center);

        $a_sheet->setCellValue('D1', 'G. index');
        $a_sheet->setCellValue('D2', $domain_info->google_results);
        $a_sheet->getStyle('D1')->applyFromArray($bold_font)->applyFromArray($center);

        if (!empty($domain_info->external_links)) {
            $a_sheet->setCellValue('A4', 'Keyword');
            $a_sheet->getStyle('A4')->applyFromArray($bold_font)->applyFromArray($center);
            $a_sheet->setCellValue('B4', 'Url');
            $a_sheet->getStyle('B4')->applyFromArray($bold_font)->applyFromArray($center);

            $index = 5;
            foreach ($domain_info->external_links as $link) {
                $is_image = strpos($link['text'], '<img') !== false;
                $keyword = $is_image ? '[IMG]' : strip_tags($link['text']);
                $a_sheet->setCellValue("A{$index}", $keyword);
                $a_sheet->setCellValue("B{$index}", $link['url']);
                $index++;
            }
        }
        else {
            $a_sheet->setCellValue('A4', "Haven't external links");
        }

        return $p_excel;
    }
}
