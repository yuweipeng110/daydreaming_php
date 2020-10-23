<?php

class Excel {
	private static $cellKeyTab = array (
			'A',
			'B',
			'C',
			'D',
			'E',
			'F',
			'G',
			'H',
			'I',
			'J',
			'K',
			'L',
			'M',
			'N',
			'O',
			'P',
			'Q',
			'R',
			'S',
			'T',
			'U',
			'V',
			'W',
			'X',
			'Y',
			'Z',
			'AA',
			'AB',
			'AC',
			'AD',
			'AE',
			'AF',
			'AG',
			'AH',
			'AI',
			'AJ',
			'AK',
			'AL',
			'AM',
			'AN',
			'AO',
			'AP',
			'AQ',
			'AR',
			'AS',
			'AT',
			'AU',
			'AV',
			'AW',
			'AX',
			'AY',
			'AZ' 
	);

	public static function CreateXlsxFromTemplate($title, $templateFile, $dataList, $xlsFileName) {
		// 模板写入数据
		$cellKey = self::$cellKeyTab;
		require_once (PUBLICDIR . '/tool/PHPExcel/Classes/PHPExcel.php');
		// $objPHPExcel = new PHPExcel ();
		$objPHPExcel = \PHPExcel_IOFactory::load ( $templateFile );
		$topNumber = 2;
		
		// 处理表头标题
		$objPHPExcel->getActiveSheet ()->mergeCells ( 'A1:' . $cellKey [count ( $dataList [0] ) - 1] . '1' ); // 合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
		$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A1', $title );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setBold ( true );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setSize ( 18 );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		
		// 处理数据
		foreach ( $dataList as $k => $v ) {
			for($j = 0; $j < count ( $dataList [0] ); $j ++) {
				if (preg_match ( '/^-?[0-9]+\.[0-9]{2}$/', $v [$j] )) {
					$objPHPExcel->getActiveSheet ()->getStyle ( $cellKey [$j] . ($k + 1 + $topNumber) )->getNumberFormat ()->setFormatCode ( "0.00" );
					$objPHPExcel->getActiveSheet ()->getStyle ( $cellKey [$j] . ($k + 1 + $topNumber) )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
				}
				$objPHPExcel->setActiveSheetIndex ()->setCellValue ( $cellKey [$j] . ($k + 1 + $topNumber), $v [$j] );
			}
		}
		// 导出execl
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="' . $xlsFileName . '"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = \PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		$objWriter->save ( 'php://output' );
	}

	public static function CreateXlsx($title, $headList, $dataList, $xlsFileName) {
		$cellKey = self::$cellKeyTab;
		require_once (PUBLICDIR . '/tool/PHPExcel/Classes/PHPExcel.php');
		$objPHPExcel = new PHPExcel ();
		$topNumber = 2;
		
		// 处理表头标题
		$objPHPExcel->getActiveSheet ()->mergeCells ( 'A1:' . $cellKey [count ( $headList ) - 1] . '1' ); // 合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
		$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A1', $title );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setBold ( true );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setSize ( 18 );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		
		// 处理表头
		foreach ( $headList as $k => $v ) {
			$objPHPExcel->getActiveSheet ()->setCellValue ( $cellKey [$k] . $topNumber, $v );
			$objPHPExcel->getActiveSheet ()->getStyle ( $cellKey [$k] . $topNumber )->getFont ()->setBold ( true ); // 设置是否加粗
			$objPHPExcel->getActiveSheet ()->getStyle ( $cellKey [$k] . $topNumber )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER ); // 垂直居中
			$objPHPExcel->getActiveSheet ()->getColumnDimension ( $cellKey [$k] )->setAutoSize ( true ); // 设置列宽度
				                                                                                             // $objPHPExcel->getActiveSheet ()->getColumnDimension ( $cellKey [$k] )->setWidth ( 12 ); // 设置列宽度
		}
		
		// 处理数据
		foreach ( $dataList as $k => $v ) {
			for($j = 0; $j < count ( $dataList [0] ); $j ++) {
				if (preg_match ( '/^-?[0-9]+\.[0-9]{2}$/', $v [$j] )) {
					$objPHPExcel->getActiveSheet ()->getStyle ( $cellKey [$j] . ($k + 1 + $topNumber) )->getNumberFormat ()->setFormatCode ( "0.00" );
					$objPHPExcel->getActiveSheet ()->getStyle ( $cellKey [$j] . ($k + 1 + $topNumber) )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
				}
				$objPHPExcel->setActiveSheetIndex ()->setCellValue ( $cellKey [$j] . ($k + 1 + $topNumber), $v [$j] );
			}
		}
		// 导出execl
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="' . $xlsFileName . '"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = \PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		$objWriter->save ( 'php://output' );
	}
}