<?php

class PdfController extends Zend_Controller_Action {

    private $_entityManager;

    public function init() {

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
    }

    public function indexAction() {


        $this->getHelper('viewRenderer')->setNoRender();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
//  self::getFrontController()->setParam("noViewRenderer", true);
//        Zend_Layout::getMvcInstance()->disableLayout();
//Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);

        $sessionRole = new Zend_Session_Namespace('sessionRole');
        $pdf = new Zend_Pdf();

// Add new page to the document
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;

        // define font resource
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $date = new Zend_Date();
//        $image = Zend_Pdf_Image::imageWithPath('images/MEDDS.png');
        // set font for page
        // write text to page
//        $page->drawImage($image, 72, 820, 800, 400);

        $page->setFont($font, 24)
                ->drawText('Mr. Book', 72, 720);

        $page->setFont($font, 12)
                ->drawText('Your bookss:', 72, 700);


        $patients = $sessionRole->arrayInfo;

        $page->setFont($font, 12)
                ->drawText(print_r($patients), 72, 700);


        //     if (isset($patients)) {

        $pos = 820;
        $pos2 = 72;
        $count = 24;
        foreach ($patients as $key => $value) {

            $count + 24;

            $myVar = $value['patient'];
            $type = $value['patientType'];
            foreach ($value['assignedPhysician'] as $newKey => $value2) {
                $assignedPhysician = "Dr. " . $value2['firstName'] . " " . $value2['lastName'];
            }
            $id = $value['patientId'];
            $page->setFont($font, 16)
                    ->drawText($myVar['lastName'], 40, $pos)
                    ->drawText($myVar['firstName'], $pos2, 3200);
            $pos += $count;
            $pos2 += $count;
        }
        // ->drawText($books, 72, 680);
//        $page->setFont($font, 16)
//                ->drawText('Date: ' . $myVar['lastName'], 40, 820)
//                ->drawText('Keep this receipt for your records.', 72, 320)
//                ->drawText('You purchased ' . $count . ' books.', 72, 590)
//                ->drawText('Subtotal is: $' . $myVar['firstName'], 90, 500)
//                ->drawText('Taxes : $' . number_format($subTotal * .12, 2, '.', ''), 90, 470)
//                ->drawText('Total Charges: $' . number_format($subTotal * 1.12, 2, '.', ''), 90, 440);
        // add page to document
        $pdf->pages[] = $page;

        // save as file
        $pdfData = $pdf->render();

        header("Content-Disposition: inline; filename=result.pdf");
        header("Content-type: application/x-pdf");
        echo $pdfData;
        
        flush();
    }

}