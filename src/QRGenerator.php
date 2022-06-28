<?php declare(strict_types=1);

namespace JedenWeb\QRPayment;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Alignment\LabelAlignmentLeft;
use Endroid\QrCode\Label\Font\Font;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\PngWriter;
use Exception;


/**
 * @author Pavel Jurásek
 */
class QRGenerator
{

    /**
     * @param QRPayment $payment
     * @return string
     * @throws Exception
     */
	public function create(QRPayment $payment): string
	{
		return $this->createFromString($payment->toString());
	}

    /**
     * @param string $content
     * @return string
     * @throws Exception
     */
	public function createFromString(string $content): string
	{
        $writer = new PngWriter();

        $code = QrCode::create($content);
		$code->setSize(300);
		$code->setMargin(10);
		$code->setEncoding(new Encoding('UTF-8'));
		$code->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());

        $label = Label::create('QR platba');
        $label->setTextColor(new Color(0, 0, 0));
        $fontPath = $label->getFont()->getPath();
        $label->setFont(new Font($fontPath, 12));
        $label->setAlignment(new LabelAlignmentLeft());

		return $writer->write($code, null, $label)->getString();
	}

}
