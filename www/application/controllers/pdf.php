<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pdf_Controller extends Controller
{
        const ALLOW_PRODUCTION = TRUE;

        public $template = 'layouts/template';

        public function __construct()
        {
                parent::__construct();
               // die("pdf");
        }


        public function index()
        {
              //  die("pdf");
                require_once 'system/vendor/tcpdf/tcpdf.php'; // подключаем библиотеку

	// создаем объект TCPDF - документ с размерами формата A4
	// ориентация - книжная
	// единицы измерения - миллиметры
	// кодировка - UTF-8
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	// убираем на всякий случай шапку и футер документа
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	$pdf->SetMargins(20, 25, 25); // устанавливаем отступы (20 мм - слева, 25 мм - сверху, 25 мм - справа)

	$pdf->AddPage(); // создаем первую страницу, на которой будет содержимое

	//$pdf->SetXY(90, 10);           // устанавливаем координаты вывода текста в рамке:
	                               // 90 мм - отступ от левого края бумаги, 10 мм - от верхнего

	//$pdf->SetDrawColor(0, 0, 200); // устанавливаем цвет рамки (синий)
	//$pdf->SetTextColor(0, 200, 0); // устанавливаем цвет текста (зеленый)

	$pdf->SetFont('arial', '', 9); // устанавливаем имя шрифта и его размер (9 пунктов)
	$pdf->Cell(30, 6, 'Привет, Мир!', '', '', 'C'); // выводим ячейку с надпис

	$pdf->Output('doc.pdf', 'I'); // выводим документ в браузер, заставляя его вкл
        }

}


?>