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
//        $pdf->pages[] = $page;

        // define font resource
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $date = new Zend_Date();
        $image = Zend_Pdf_Image::imageWithPath('images/MEDDS.png');
        // set font for page
        // write text to page
        $page->drawImage($image, 0, 0, 1000, 100);
        
        

        $page->setFont($font, 24)
                ->drawText('Nanaimo Health Clinic', 72, 720);

        $page->setFont($font, 12)
                ->drawText('Requested List', 72, 700);


        $patients = $sessionRole->arrayInfo;

//
        $page->setFont($font, 12);
//                ->drawText(print_r($patients), 72, 700);
        //     if (isset($patients)) {

        $pos = 650;
        $pos2 = 634;
        $count = 16;
        $count2 = 16;
        foreach ($patients as $key => $value) {

           

            $myVar = $value['patient'];
//            $type = $value['patientType'];
          
//            $id = $value['patientId'];
                  $person = $myVar['lastName'] . ", " . $myVar['firstName'];
            $page->setFont($font, 14)
                   ->drawText($person, 100, $pos - 100);
            $pos += $count;
        }          
//        }
//                     foreach ($patients as $key => $value) {
//         foreach ($value['assignedPhysician'] as $newKey => $value2) {
//               $count2 - 32;
////                $assignedPhysician2 = "Dr. " . $value2['firstName'] . " " . $value2['lastName'];
//                
////                foreach ($value2 as $newKey2 => $value3) {
////                $page->setFont($font, 16)
////                    ->drawText("Dr. " . $value3['firstName'] . " " . $value3['lastName'], 100, $pos2);
////                    $pos2 += $count2;
////                }
//         }
//          }

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